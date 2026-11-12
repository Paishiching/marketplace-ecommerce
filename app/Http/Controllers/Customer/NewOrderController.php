<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewOrderController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $customer = Customer::firstOrCreate(['user_id' => $user->id]);
        $phone = $user->phone ?? ($customer->phone ?? '');
        $addresses = $customer->shippingAddress()->latest()->get();

        return view('customer.account.new-order', compact('user', 'customer', 'phone', 'addresses'));
    }

    public function searchProducts(Request $request)
    {
        $term = trim((string) $request->query('q', ''));
        if ($term !== '' && mb_strlen($term) < 2) {
            return response()->json(['data' => [], 'has_more' => false]);
        }

        $products = Product::query()
            ->where('status', '!=', 'rejected')
            ->when($term !== '', function ($query) use ($term) {
                $query->where(function ($query) use ($term) {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('sku', 'like', "%{$term}%")
                    ->orWhere('model_number', 'like', "%{$term}%")
                    ->orWhereHas('productSpecifications', function ($spec) use ($term) {
                        $spec->where('name', 'like', '%model%')->where('value', 'like', "%{$term}%");
                    })
                    ->orWhereHas('productAttributes', function ($attribute) use ($term) {
                        $attribute->whereHas('attribute', fn ($q) => $q->where('name', 'like', '%model%'))
                            ->whereHas('attributeValue', fn ($q) => $q->where('value', 'like', "%{$term}%"));
                    });
                });
            })
            ->with(['brand', 'primaryImage', 'productSpecifications' => fn ($q) => $q->where('name', 'like', '%model%'), 'productAttributes.attribute', 'productAttributes.attributeValue'])
            ->orderBy('name')
            ->paginate(24);

        return response()->json([
            'data' => $products->getCollection()->map(function (Product $product) {
                $model = $product->productSpecifications->first()?->value;
                if (! $model) {
                    $modelAttribute = $product->productAttributes->first(fn ($item) => str_contains(strtolower((string) $item->attribute?->name), 'model'));
                    $model = $modelAttribute?->attributeValue?->value;
                }

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'model' => $product->model_number ?: $model,
                    'brand' => $product->brand?->name,
                    'image' => $product->display_image,
                    'price' => (float) ($product->discount_price > 0 ? $product->discount_price : $product->price),
                ];
            })->values(),
            'has_more' => $products->hasMorePages(),
            'next_page' => $products->currentPage() + 1,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:150'],
            'shipping_address_id' => ['nullable', 'integer'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['required', 'array', 'min:1', 'max:50'],
            'items.*.product_id' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:100000'],
        ]);

        $customer = Customer::firstOrCreate(['user_id' => $request->user()->id]);
        $shippingAddressId = null;
        if (! empty($validated['shipping_address_id'])) {
            $shippingAddressId = $customer->shippingAddress()->findOrFail($validated['shipping_address_id'])->id;
        }

        $products = Product::whereIn('id', collect($validated['items'])->pluck('product_id'))
            ->where('status', '!=', 'rejected')->get()->keyBy('id');
        abort_if($products->count() !== count($validated['items']), 422, 'One or more selected products are unavailable. Please refresh the product search.');

        session(['new_order_checkout' => [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'shipping_address_id' => $shippingAddressId,
            'items' => collect($validated['items'])->map(fn ($item) => [
                'product_id' => (int) $item['product_id'],
                'quantity' => (int) $item['quantity'],
            ])->values()->all(),
        ]]);

        return redirect()->route('checkout.index')->with('success', 'Your items are ready. Confirm delivery details and choose a payment method to place the order.');
    }
}
