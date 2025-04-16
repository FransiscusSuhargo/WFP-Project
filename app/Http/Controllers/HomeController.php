<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Orders\Order;
use App\Models\Orders\OrderDetail;
use Illuminate\Http\Request;
use Reflector;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('customer.index');
    }

    public function showProfile(){
        $profile = Customer::where('user_id', Auth::id())->get();
        return view('customer.profile', compact($profile));
    }
    public function updateProfile(Request $request){
        $profile = Customer::where('user_id', Auth::id())->get();
        $profile->name = $request->name;
        $profile->member_start_date = $request->start_date;
        $profile->member_end_date = $request->end_date;
        $profile->status = $request->status;

        if($profile->save()) return redirect()->route('profile.index')->with('success', 'Successfully Edit Customer!');
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update Customer!']);
    }

    public function showOrder(){
        $orders = Order::with(['orderDetails'])->where('customer_id', Auth::id())->get();
        return view('customer.order', compact('orders'));
    }
    public function insertOrder(Request $request){
        $order = new Order();
        $order->customer_id = $request->customer_id;
        $order->payment_id = $request->payment_id;
        $order->date = Carbon::parse($request->date)->format('Y-m-d H:i:s');
        $order->queue_number = $request->queueNumber;
        $order->type = $request->type;
        $order->status = $request->status;
        $order->created_at = Carbon::now();
        $order->updated_at = Carbon::now();
        if ($order->save()) {
            return redirect()->route('order.index')->with(['success' => 'Successfully add Order']);
        }
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to add Order!']);
    }
    public function updateOrder(Request $request){
        $order = Order::where('id', $request->id)->get();
        $order->payment_id = $request->payment_id;
        $order->date = $request->date;
        $order->member_end_date = $request->end_date;
        $order->status = $request->status;

        if($profile->save()) return redirect()->route('order.index')->with('success', 'Successfully Edit Order!');
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update Order!']);
    }
    public function showOrderDetail(Request $request){
        $order = Order::with(['orderDetails.food, orderDetails.modifiers, orderDetails.addons'])->where('customer_id', Auth::id())->where('id', $request->id)->first();
        return view('customer.orderDetail', compact('order'));
    }
    public function insertOrderDetail(Request $request){
        $orderDetail = new OrderDetail();
        $orderDetail->food_id = $request->food_id;
        $orderDetail->order_id = $request->order_id;
        $orderDetail->subtotal = $request->subtotal;
        $orderDetail->note = $request->note;
        $orderDetail->created_at = Carbon::now();
        $orderDetail->updated_at = Carbon::now();
        if ($orderDetail->save()) {
            return redirect()->route('order.detail')->with(['success' => 'Successfully add Order Detail']);
        }
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to add Order Detail!']);
    }
    public function updateOrderDetail(Request $request){
        $orderDetail = OrderDetail::where('id', $request->id)->get();
        $orderDetail->food_id = $request->food_id;
        $orderDetail->order_id = $request->order_id;
        $orderDetail->subtotal = $request->subtotal;
        $orderDetail->note = $request->note;
        $orderDetail->created_at = Carbon::now();
        $orderDetail->updated_at = Carbon::now();
        if ($orderDetail->save()) {
            return redirect()->route('order.detail')->with(['success' => 'Successfully add Order Detail']);
        }
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to add Order Detail!']);
    }
    public function deleteOrderDetail(Request $request){
        $order = OrderDetail::where('id', $request->id)->get();

        if ($order->delete()) {
            return redirect()->route('order.detail')->with(['success' => 'Successfully Delete Order Detail']);
        }
        return redirect()->route('order.detail')->with(['error' => 'Failed to delete Order Detail']);
    }
}
