<?php

namespace App\Http\Controllers;

use App\Models\PaymentDepositDetail;
use Illuminate\Support\Facades\Storage;

class PaymentDepositReceiptController extends Controller
{
    public function show(PaymentDepositDetail $deposit)
    {
        abort_unless(auth()->user()?->hasAnyRole(['admin', 'superadmin']), 403);
        abort_unless(Storage::disk('local')->exists($deposit->receipt_path), 404);

        return response()->file(Storage::disk('local')->path($deposit->receipt_path), [
            'Cache-Control' => 'private, no-store',
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }
}
