<?php

namespace App\Services\Midtrans;

use App\Models\Orders\Order;
use Midtrans\Config;
use Midtrans\Notification;
use Midtrans\Snap;
use Exception;

class MidtransService {
    protected string $serverKey;
    protected string $isProduction;
    protected string $isSanitized;
    protected string $is3ds;

    public function __construct()
    {
        // Konfigurasi server key, environment, dan lainnya
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production');
        $this->isSanitized = config('midtrans.is_sanitized');
        $this->is3ds = config('midtrans.is_3ds');

        // Mengatur konfigurasi global Midtrans
        Config::$serverKey = $this->serverKey;
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = $this->isSanitized;
        Config::$is3ds = $this->is3ds;
    }

    /**
     * @throws Exception
     */
    public function createSnapToken(Order $order)
    {
        $params = [
            'transaction_details' => [
                'order_id' => $order->id,
                'gross_amount' => $order->orderDetails()->sum('subtotal')
            ],
//            'item_details' => $this->mapItemsToDetails($order),
            'customer_details' => $this->getCustomerDetails($order),
            "page_expiry" => [
                "duration" => 5,
                "unit" => "minutes"
            ]
        ];

        try {
            return Snap::getSnapToken($params);
        } catch (Exception $x) {
            throw new Exception($x->getMessage());
        }
    }

    // Validasi apakah signature yg diterima dari Midtrans
    public function isSignatureKeyVerified(): bool
    {
        $notification = new Notification();

        // Membuat signature key lokal dari data notifikasi
        $localSignatureKey = hash(
            'sha512',
            $notification->order_id . $notification->status_code .
            $notification->gross_amount . $this->serverKey
        );

        return $localSignatureKey == $notification->signature_key;
    }

    public function getOrder(): Order
    {
        $notification = new Notification();

        // Mengambil data order dari database berdasarkan order_id
        return Order::where('id', $notification->order_id)->first();
    }

    // Mendapatkan status transaksi
    public function getStatus(): string
    {
        $notification = new Notification();
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;

        return match ($transactionStatus) {
            'capture' => ($fraudStatus == 'accept') ? 'success' : 'pending',
            'settlement' => 'success',
            'deny' => 'failed',
            'cancel' => 'cancel',
            'expire' => 'expire',
            'pending' => 'pending',
            default => 'unknown',
        };
    }

    public function getPaymentOption(): string
    {
        $notification = new Notification();
        return $notification->payment_type ?? "";
    }

    protected function mapItemsToDetails(Order $order): array
    {
        return $order->orderDetails()->get()->map(function ($item) {
//            return [
//                'id' => $item->id,
//                'price' => $item->price,
//                'quantity' => $item->quantity,
//                'name' => $item->product_name,
//            ];
            return [
                'id' => $item->id,
                'price' => $item->subtotal,
                'note' => $item->note,
                'name' => $item->food->name
            ];
        })->toArray();
    }

    protected function getCustomerDetails(Order $order): array
    {
        // Sesuaikan data customer dengan informasi yang dimiliki oleh aplikasi Anda
        $customer = $order->customer;
        return [
            'first_name' => $customer->name,
            'email' => $customer->user->email,
        ];
    }
}
