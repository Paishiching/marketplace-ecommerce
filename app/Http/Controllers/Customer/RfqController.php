<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Rfq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class RfqController extends Controller
{
    public function draft(Request $request)
    {
        $data = $request->validate([
            'product_name' => ['required', 'string', 'max:180'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);
        $apiKey = config('services.openai.key');
        if (! $apiKey) {
            return response()->json(['message' => 'AI writing is not configured yet. Please contact the store administrator.'], 503);
        }

        try {
            $response = Http::withToken($apiKey)->acceptJson()->timeout(30)->post(config('services.openai.responses_url'), [
                'model' => config('services.openai.model', 'gpt-6-astra'),
                'instructions' => 'Write a concise, professional buyer enquiry or sourcing requirement for a Bangladesh ecommerce marketplace. Use the same language as the customer notes where possible. Do not invent technical specifications, quantities, prices, deadlines, or certifications. If notes are brief, phrase them as a clear question to the supplier. Output only the editable enquiry text.',
                'input' => "Product: {$data['product_name']}\nCustomer notes: ".($data['notes'] ?? 'No extra notes provided.'),
                'max_output_tokens' => 450,
                'store' => false,
            ]);

            if (! $response->successful()) {
                Log::warning('AI RFQ draft request failed', ['status' => $response->status()]);
                return response()->json(['message' => 'The AI writer is temporarily unavailable. Please try again shortly.'], 503);
            }

            $text = collect($response->json('output', []))
                ->flatMap(fn ($item) => $item['content'] ?? [])
                ->where('type', 'output_text')
                ->pluck('text')
                ->implode("\n");

            if (trim($text) === '') {
                return response()->json(['message' => 'The AI could not draft this request. Please add a few details and try again.'], 502);
            }

            return response()->json(['draft' => trim($text)]);
        } catch (\Throwable $exception) {
            Log::warning('AI RFQ draft request error', ['message' => $exception->getMessage()]);
            return response()->json(['message' => 'The AI writer is temporarily unavailable. Please try again shortly.'], 503);
        }
    }

    public function index()
    {
        $rfqs = Rfq::where('user_id', auth()->id())->withCount('quotes')->latest()->paginate(10);
        return view('customer.rfqs.index', compact('rfqs'));
    }

    public function create()
    {
        return view('customer.rfqs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => ['required', 'string', 'max:180'],
            'requirements' => ['required', 'string', 'max:8000'],
            'quantity' => ['required', 'integer', 'min:1', 'max:100000000'],
            'unit' => ['required', 'in:Piece/Pieces,Unit/Units,Set/Sets,Pair/Pairs,Box/Boxes,Bag/Bags,Carton/Cartons,Kg/Kg,Metric Ton/Tons,Other'],
            'attachments' => ['nullable', 'array', 'max:4'],
            'attachments.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'share_business_card' => ['accepted'],
            'agree_rules' => ['accepted'],
        ]);

        $paths = collect($request->file('attachments', []))
            ->map(fn ($file) => $file->store('rfqs', 'public'))->all();

        $rfq = Rfq::create([
            'user_id' => auth()->id(),
            'product_name' => $data['product_name'],
            'requirements' => $data['requirements'],
            'attachments' => $paths,
            'quantity' => $data['quantity'],
            'unit' => $data['unit'],
            'share_business_card' => true,
        ]);

        return redirect()->route('customer.rfqs.show', $rfq)->with('success', 'Your sourcing request has been shared with suppliers.');
    }

    public function show(Rfq $rfq)
    {
        abort_unless($rfq->user_id === auth()->id(), 403);
        $rfq->load('quotes.supplier');
        return view('customer.rfqs.show', compact('rfq'));
    }
}
