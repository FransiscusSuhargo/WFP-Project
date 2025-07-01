<?php

namespace App\Http\Controllers;

use App\Events\NewOrderEvent;
use App\Models\Orders\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index');
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
