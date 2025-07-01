<?php

namespace App\Http\Controllers;

use App\Events\NewOrderEvent;
use App\Models\Orders\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    private function getProcessOrders()
    {
        $orders = Order::query()
            ->whereDate("created_at", Carbon::now())
            ->where('status', 'process')
            ->orderBy('queue_number', 'DESC')
            ->paginate(7);

        return $orders;
    }

    private function getReadyOrder()
    {
        $orders = Order::query()
            ->whereDate("created_at", Carbon::now())
            ->where('status', 'ready')
            ->orderBy('queue_number', 'DESC')
            ->paginate(7);

        return $orders;
    }


    public function index()
    {
        $orders = $this->getProcessOrders();

        $orderView = view('employee.components.order_layout', compact('orders'))->render();

        return view('employee.index', compact('orders', 'orderView'));
    }

    public function readyOrder()
    {
        $orders = $this->getReadyOrder();

        $orderView = view('employee.components.order_layout', compact('orders'))->render();

        return view('employee.finish-order', compact('orders', 'orderView'));
    }

    public function detailOrder(Request $request, int $order_id)
    {
        $order = Order::with([
            'orderDetails',
            'orderDetails.modifiers',
            'orderDetails.addons'
        ])
        ->find($order_id);
        $total = $order->orderDetails()->get()->sum('subtotal');
//        dd($order);
        return view('employee.order', compact('order', 'total'));
    }

//    public function refreshOrder(Request $request)
//    {
//        $orders = Order::query()
//            ->whereDate("created_at", Carbon::now())
//            ->where('status', 'process')
//            ->orderBy('queue_number', 'DESC')
//            ->paginate(7);
//
//        $orderView = view('employee.components.order_layout', compact('orders'))->render();
//
//
//        return response()->json([
//            'status' => "OK",
//            'code' => 200,
//            'order_view' => $orderView
//        ], 200);
//    }

    public function setReady(Request $request)
    {
        $orderId = $request->get('order_id');
        $order = Order::find($orderId);

        $order->update([
           'status' => "ready"
        ]);

        event(new NewOrderEvent());

        $orders = $this->getProcessOrders();

        $orderView = view('employee.components.order_layout', compact('orders'))->render();

        return response()->json([
            'status' => 'OK',
            'order_view' => $orderView
        ], 200);
    }

    public function setFinish(Request $request)
    {
        $orderId = $request->get('order_id');
        $order = Order::find($orderId);

        $order->update([
            'status' => "finished"
        ]);

        event(new NewOrderEvent());

        $orders = $this->getReadyOrder();

        $orderView = view('employee.components.order_layout', compact('orders'))->render();

        return response()->json([
            'status' => 'OK',
            'order_view' => $orderView
        ], 200);
    }

    public function refreshOrderTracking(Request $request)
    {
        $processOrders = Order::query()
            ->whereDate("created_at", Carbon::now())
            ->where('status', 'process')
            ->orderBy('queue_number', 'ASC')
            ->get();

        $viewProcess = view('employee.components.order_queue', [
            'orders' => $processOrders
        ])->render();

        $readyOrders = Order::query()
            ->whereDate("created_at", Carbon::now())
            ->where('status', 'ready')
            ->orderBy('queue_number', 'ASC')
            ->get();

        $viewReady = view('employee.components.order_queue', [
            'orders' => $readyOrders
        ])->render();

        return response()->json([
            'status' => "OK",
            'code' => 200,
            'view_process' => $viewProcess,
            'view_ready' => $viewReady
        ], 200);
    }

    public function testPusher(Request $request)
    {
        event(new NewOrderEvent());
        return response()->json([
            'status' => "OK"
        ]);
    }

    public function tracking(Request $request)
    {
//        $orders = Order::query()
//            ->whereDate("created_at", Carbon::now())
//            ->get();

        $processOrders = Order::query()
            ->whereDate("created_at", Carbon::now())
            ->where('status', 'process')
            ->orderBy('queue_number', 'ASC')
            ->get();

        $viewProcess = view('employee.components.order_queue', [
            'orders' => $processOrders
        ])->render();

        $readyOrders = Order::query()
            ->whereDate("created_at", Carbon::now())
            ->where('status', 'ready')
            ->orderBy('queue_number', 'ASC')
            ->get();

        $viewReady = view('employee.components.order_queue', [
            'orders' => $readyOrders
        ])->render();

        return view('employee.tracking', compact('viewReady', 'viewProcess'));
    }
}
