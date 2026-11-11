<?php

namespace App\Jobs;

use App\Services\ReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class GenerateReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $reportType,
        protected Carbon $from,
        protected Carbon $to,
        protected ?string $notifyEmail = null
    ) {
    }

    public function handle(ReportService $reportService): void
    {
        $data = match ($this->reportType) {
            'sales' => $reportService->salesSummary($this->from, $this->to),
            'top_products' => $reportService->topProducts($this->from, $this->to),
            'vendor_performance' => $reportService->vendorPerformance($this->from, $this->to),
            'commission' => $reportService->commissionSummary($this->from, $this->to),
            default => [],
        };

        $filename = "reports/{$this->reportType}-{$this->from->format('Ymd')}-{$this->to->format('Ymd')}.json";

        Storage::put($filename, json_encode($data, JSON_PRETTY_PRINT));

        // Placeholder: email $this->notifyEmail a link/attachment once
        // a Mailable for reports exists.
    }
}
