<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CompareList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    // একসাথে সর্বোচ্চ কয়টা product compare করা যাবে
    private const MAX_ITEMS = 4;

    public function index()
    {
        $items = CompareList::where('user_id', Auth::id())
            ->with(['product' => function ($q) {
                $q->with(['category', 'primaryImage', 'colorValues'])
                    ->withSum('inventories', 'quantity')
                    ->withAvg('reviews', 'rating');
            }])
            ->whereHas('product') // soft-deleted product বাদ যাবে
            ->oldest()
            ->get();

        return view('frontend.compare.index', compact('items'));
    }

    // Add / remove toggle
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $query = CompareList::where('user_id', Auth::id())
            ->where('product_id', $request->product_id);

        $existing = $query->first();

        if ($existing) {
            $existing->delete();
            $added   = false;
            $message = 'Product removed from compare list.';
        } else {
            $count = CompareList::where('user_id', Auth::id())->count();

            if ($count >= self::MAX_ITEMS) {
                $message = 'You can compare maximum ' . self::MAX_ITEMS . ' products at a time.';

                if ($request->expectsJson()) {
                    return response()->json([
                        'status'  => false,
                        'added'   => false,
                        'message' => $message,
                    ], 422);
                }

                return back()->with('error', $message);
            }

            CompareList::create([
                'user_id'    => Auth::id(),
                'product_id' => $request->product_id,
            ]);

            $added   = true;
            $message = 'Product added to compare list.';
        }

        if ($request->expectsJson()) {
            return response()->json([
                'status'  => true,
                'added'   => $added,
                'message' => $message,
                'count'   => CompareList::where('user_id', Auth::id())->count(),
            ]);
        }

        return back()->with('success', $message);
    }

    public function destroy(CompareList $item)
    {
        // অন্যের compare item delete করা যাবে না
        abort_unless($item->user_id === Auth::id(), 403);

        $item->delete();

        return back()->with('success', 'Product removed from compare list.');
    }
}
