<?php

namespace App\Services\Couriers;

use App\Models\Order;
use App\Models\Shipment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class SteadfastDriver implements CourierDriver
{
    public function __construct(protected array $credentials)
    {
    }

    protected function http()
    {
        if (blank($this->credentials['api_key'] ?? null) || blank($this->credentials['secret_key'] ?? null)) {
            throw new RuntimeException('Steadfast API key / secret key is not set for this courier.');
        }

        return Http::withHeaders([
            'Api-Key'    => $this->credentials['api_key'],
            'Secret-Key' => $this->credentials['secret_key'],
            'Accept'     => 'application/json',
        ])->baseUrl(config('couriers.steadfast_base_url'))->timeout(20);
    }

    public function book(Order $order, float $cod, ?string $note, array $input = []): array
    {
        $address = $order->shippingAddress;

        $recipientAddress = collect([
            $address->address_line1 ?? null,
            $address->address_line2 ?? null,
            $address->city ?? null,
            $address->state ?? null,
            $address->postal_code ?? null,
        ])->filter()->implode(', ');

        $phone = $address->phone ?? $order->phone;
        $name  = $address->recipient_name ?? $order->name;

        if (blank($recipientAddress) || blank($phone) || blank($name)) {
            throw new RuntimeException('Recipient name, phone and address are required to book a courier.');
        }

        $response = $this->http()->post('/create_order', [
            'invoice'           => Str::of((string) ($order->order_number ?? $order->id))
                ->replaceMatches('/[^A-Za-z0-9\-_]/', '-')->toString(),
            'recipient_name'    => $name,
            'recipient_phone'   => $phone,
            'recipient_address' => $recipientAddress,
            'cod_amount'        => $cod,
            'note'              => $note,
        ]);

        $body = $response->json();

        if (! $response->successful() || (int) ($body['status'] ?? 0) !== 200 || empty($body['consignment'])) {
            Log::warning('Steadfast create_order failed', ['order' => $order->id, 'response' => $body]);

            throw new RuntimeException('Steadfast error: ' . ($body['message'] ?? 'Could not create the parcel.'));
        }

        $c = $body['consignment'];

        return [
            'consignment_id'  => (string) ($c['consignment_id'] ?? ''),
            'tracking_number' => $c['tracking_code'] ?? null,
            'status'          => $c['status'] ?? 'in_review',
        ];
    }

    public function status(Shipment $shipment): ?string
    {
        $response = $this->http()->get('/status_by_cid/' . $shipment->consignment_id);
        $body     = $response->json();

        if (! $response->successful() || empty($body['delivery_status'])) {
            throw new RuntimeException('Could not fetch courier status.');
        }

        return $body['delivery_status'];
    }
}