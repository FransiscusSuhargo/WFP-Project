<?php

namespace App\Http\Controllers;

use App\Events\NewOrderEvent;
use App\Models\Foods\Food;
use App\Models\Orders\Order;
use App\Models\Orders\OrderDetail;
use App\Services\Midtrans\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function cancelOrder(Order $order)
    {
        $order->delete();

    }

    public function test(Request $request)
    {
//        $order = Order::query()->findOrFail($request->order_id);
//        dd(MidtransService::mapItemsToDetails($order));
        return response()->json([
            'status' => "OK",
            'code' => 200
        ]);
    }

    public function listOrders(Request $request)
    {
//        dd(Auth::user()->customer);
        $orders = Order::query()
            ->where('customer_id', Auth::user()->customer->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('customer.order.index', compact('orders'));
    }

    public function checkout(Request $request, MidtransService $midtransService)
    {
        $cart = $request->session()->get("cart");

        if (!$cart) {
            return redirect()->back();
        }

        // Bikin Order
        DB::beginTransaction();
        try {
            $todayLastOrder = Order::query()
                ->whereDate('created_at', Carbon::now())
                ->orderBy('created_at', 'DESC')
                ->first();
            $lastQueue = $todayLastOrder != null ? (int)$todayLastOrder->queue_number : 0;
            $nextQueue = str_pad($lastQueue + 1, 4, '0', STR_PAD_LEFT);

            $order = Order::create([
                'customer_id' => Auth::user()->customer->id,
                'date' => Carbon::now(),
                'queue_number' => $nextQueue,
                'type' => $request->get("order_type"),
                'status' => 'pending'
            ]);
            $orderId = $order->id;

            // Bikin Order Detail (beserta modifiers dan addons)
            foreach ($cart as $item) {
                $quantity = $item['quantity'];
                $note = $item['note'];

                for ($cnt = 0; $cnt < $quantity; $cnt++)
                {
                    $foodId = $item['id'];
                    $food = Food::find($foodId);
                    $subTotal = $food->price;

                    $orderDetail = OrderDetail::query()
                        ->create([
                            'food_id' => $food->id,
                            'order_id' => $orderId,
                            'subtotal' => $subTotal,
                            'note' => $note
                        ]);

                    // Modifiers
                    $modifiersArray = $item['modifiers'];
                    if (count($modifiersArray) > 0)
                    {
                        $orderDetail
                            ->modifiers()
                            ->attach($modifiersArray);
                    }

                    // Addons
                    $addonsArray = $item['addons'];
                    if (count($addonsArray) > 0)
                    {
                        $orderDetail
                            ->addons()
                            ->attach($addonsArray);
                    }
                }
            }

            // Bikin Snap token
            $snapToken = $midtransService->createSnapToken($order);
            $order->snap_token = $snapToken;
            $order->save();

            DB::commit();

            // Kasih response snap token dan order id
            return response()->json([
                'snap_token' => $snapToken,
                'order_id' => $order->id
            ], 200);
        } catch (\Throwable $ex) {
            DB::rollBack();
            return response()->json([
                'status' => "Internal Server Error",
                'code' => 500,
                'message' => $ex->getMessage()
            ], 500);
        }
//        return view('customer.order.detail', compact('order', 'snapToken'));
    }

    public function onSuccessCheckout(Request $request)
    {
        $request->session()->forget('cart');
        return response()->json([
            'status' => "OK",
            'code' => 200,
            'redirect_url' => route('customer.order.index'),
        ], 200);
    }

    public function onFailedCheckout(Request $request)
    {
        try {
            $order = Order::find($request->get("order_id"));
            $order->delete();
        } catch (\Throwable) {

        }
        return response()->json([
            'status' => "OK",
            'code' => 200,
            'redirect_url' => route('customer.order.index'),
        ], 200);
    }

    // Callback Notification
    public function midtransCallback(Request $request, MidtransService $midtransService)
    {
        if ($midtransService->isSignatureKeyVerified()) {
            $order = $midtransService->getOrder();

            if ($midtransService->getStatus() == 'success') {
                $order->update([
                    'status' => 'process',
                    'payment_type' => $midtransService->getPaymentOption()
                ]);
//                NewOrderEvent::dispatch();
            }

            if ($midtransService->getStatus() == 'pending') {
                // lakukan sesuatu jika pembayaran masih pending, seperti mengirim notifikasi ke customer
                // bahwa pembayaran masih pending dan harap selesai pembayarannya
                $order->update([
                    'status' => 'pending',
                ]);
            }

            if ($midtransService->getStatus() == 'expire') {
                // lakukan sesuatu jika pembayaran expired, seperti mengirim notifikasi ke customer
                // bahwa pembayaran expired dan harap melakukan pembayaran ulang
//                $order->update([
//                    'status' => 'expired',
//                ]);
                $order->delete();
            }

            if ($midtransService->getStatus() == 'cancel') {
                // lakukan sesuatu jika pembayaran dibatalkan
//                $order->update([
//                    'status' => 'expired',
//                ]);
                $order->delete();
            }

            if ($midtransService->getStatus() == 'failed') {
                // lakukan sesuatu jika pembayaran gagal
//                $order->update([
//                    'status' => 'expired',
//                ]);
                $order->delete();
            }

            event(new NewOrderEvent());

            return response()
                ->json([
                    'success' => true,
                    'message' => 'Notifikasi berhasil diproses',
                ]);
        } else {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }
    }

    public function forcePending()
    {

    }

    public function forceSuccess()
    {

    }

    public function forceExpired()
    {

    }
}
