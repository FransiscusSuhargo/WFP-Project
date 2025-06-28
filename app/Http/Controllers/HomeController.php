<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Foods\Addon;
use App\Models\Foods\Food;
use App\Models\Foods\Modifier;
use App\Models\Orders\Order;
use App\Models\Orders\OrderDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $foods = Food::all();
        return view('customer.index', compact('foods'));
    }

    Public function detailMenu($id)
    {
        $food = Food::find($id); 
        return view("customer.food.detail", compact("food"));
    }
    //profile
    public function showProfile()
    {
        $profile = Customer::with('user')->where('user_id', Auth::id())->get();
        // return $profile;
        return view('customer.profile.index', compact('profile'));
    }
    public function editProfile(){
        $profile = Customer::with('user')->where('user_id', Auth::id())->get();
        return view('customer.profile.edit', compact('profile'));

    }
    public function updateProfile(Request $request)
    {
        $profile = Customer::where('user_id', Auth::id())->firstOrFail();
        $user = $profile->user;

        $profile->name = $request->name;
        $user->email = $request->email;

        // Simpan dua-duanya
        $userSaved = $user->save();
        $profileSaved = $profile->save();

        if ($userSaved && $profileSaved) {
            return redirect()->route('profile.index')->with('success', 'Successfully Edit Customer!');
        }

        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update Customer!']);
    }

    //order
    public function showOrder()
    {
        $orders = Order::with(['orderDetails'])->where('customer_id', Auth::id())->get();
        return view('customer.order', compact('orders'));
    }
    public function insertOrder(Request $request)
    {
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
    public function updateOrder(Request $request)
    {
        $order = Order::where('id', $request->id)->get();
        $order->payment_id = $request->payment_id;
        $order->date = $request->date;
        $order->member_end_date = $request->end_date;
        $order->status = $request->status;

        if ($order->save()) return redirect()->route('order.index')->with('success', 'Successfully Edit Order!');
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update Order!']);
    }
    public function showOrderDetail(Request $request)
    {
        $order = Order::with(['orderDetails.food, orderDetails.modifiers, orderDetails.addons'])->where('customer_id', Auth::id())->where('id', $request->id)->first();
        return view('customer.orderDetail', compact('order'));
    }
    public function insertOrderDetail(Request $request)
    {
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
    public function updateOrderDetail(Request $request)
    {
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
    public function deleteOrderDetail(Request $request)
    {
        $order = OrderDetail::where('id', $request->id)->get();

        if ($order->delete()) {
            return redirect()->route('order.detail')->with(['success' => 'Successfully Delete Order Detail']);
        }
        return redirect()->route('order.detail')->with(['error' => 'Failed to delete Order Detail']);
    }

    //cart
    public function cart(Request $request)
    {
        $cart = $request->session()->get("cart", []);
        $cart = $this->loadCartDetail($cart);

        return view("customer.cart.index", compact("cart"));
    }
    public function putCart(Request $request, Food $food)
    {
        $cart = $request->session()->get("cart", []);
        $idx = -1;

        for ($i = 0; $i < count($cart); $i++) {
            if ($cart[$i]["id"] == $food->id) {
                $idx = $i;
            }
        }

        if ($idx < 0) {
            $cart[] = [
                "id" => $food->id,
                "quantity" => $request->quantity,
                "modifiers" => [],
                "addons" => [],
                "note" => ""
            ];
        } else {
            // Jangan hapus detail lain!
            $cart[$idx]["quantity"] = $request->quantity;
        }

        $request->session()->put("cart", $cart);

        return redirect()->route("cart")->with("status", "Sukses menambah Menu yang dibeli");
    }

    public function deleteCart($food)
    {
        $cart = session()->get("cart");
        if (!$cart) {
            $cart = array();
        }
        $idx = -1;
        for ($i = 0; $i < count($cart); $i++) {
            //perlu penyesuaian detail
            if ($cart[$i]["id"] == $food) {
                $idx = $i;
            }
        }
        if ($idx >= 0) {
            array_splice($cart, $idx, 1);
        }
        session()->put("cart", $cart);
        return redirect()->route("cart")->with("status", "Sukses menghapus data");
    }
    function checkout(Request $request){
        $cart = $request->session()->get("cart");
        
        if (!$cart) {
            return redirect()->back();
        }
        
        //perlu penyesuaian
        // $order=Order::createMyTransaction($cart); 
        
        foreach ($cart as $r) {
            // $order->foods()->attach($r["id"], ["quantity" => $r["quantity"]]);
        }
        
        $request->session()->forget("cart");
        return redirect("/cart")->with("status", 
            "Sukses mengirimkan semua laporan ke admin");
    }

    function showCustomizeOrder($id, Request $request){
        $cart = $request->session()->get("cart")[$id];
        $food = Food::find($cart['id']);
        $addOns = Addon::all();
        $modifiers = Modifier::all();
        return view('customer.order.customize', compact('addOns', 'modifiers', 'food', 'cart', 'id'));        
    }

    // public function customizeOrder($id, Request $request)
    // {
    //     $cart = session()->get('cart', []);

    //     if (!isset($cart[$id])) {
    //         return back()->with('error', 'Item not found in cart.');
    //     }

    //     // Update modifiers, addons, and note
    //     $cart[$id]['modifiers'] = $request->modifiers ?? [];
    //     $cart[$id]['addons'] = $request->addons ?? [];
    //     $cart[$id]['note'] = $request->note ?? '';

    //     // Tambahkan data detail untuk kebutuhan UI
    //     foreach ($cart as $i => $item) {
    //         $food = Food::find($item["id"]);
    //         // Jaga-jaga jika food tidak ditemukan
    //         if (!$food) continue;
    //         $food->modifiers = [];
    //         $food->addons = [];
    //         if ($id == $i) {
    //             $food->note = $request->note;
    //         }

    //         if (isset($item['modifiers']) && is_array($item['modifiers'])) {
    //             $modifiers = [];
    //             foreach ($item['modifiers'] as $modifierId) {
    //                 $modifier = Modifier::find($modifierId);
    //                 if ($modifier) {
    //                     $modifiers[] = $modifier;
    //                 }
    //             }
    //             $food->modifiers = $modifiers;
    //         }
    //         if (isset($item['addons']) && is_array($item['addons'])) {
    //             $addons = [];
    //             foreach ($item['addons'] as $addonId) {
    //                 $addon = Addon::find($addonId);
    //                 if ($addon) {
    //                     $addons[] = $addon;
    //                 }
    //             }
    //             $food->addons = $addons;
    //         }
    //         $cart[$i]["food"] = $food;
    //     }

    //     session()->put('cart', $cart);
    //     // return $cart;
    //     return view('customer.cart.index', compact('cart'));
    // }
    public function customizeOrder($id, Request $request)
    {
        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return back()->with('error', 'Item not found in cart.');
        }

        // Update data kustomisasi
        $cart[$id]['modifiers'] = $request->modifiers ?? [];
        $cart[$id]['addons'] = $request->addons ?? [];
        $cart[$id]['note'] = $request->note ?? '';

        // Simpan kembali ke session
        session()->put('cart', $cart);

        // Tambahkan detail model Food, Modifier, Addon ke item cart
        $cart = $this->loadCartDetail($cart);

        return view('customer.cart.index', compact('cart'));
    }


    private function loadCartDetail($cart)
    {
        foreach ($cart as $i => $item) {
            $food = Food::find($item["id"]);
            if (!$food) continue;

            // Siapkan data tampilan
            $food->note = $item['note'] ?? '';
            $food->modifiers = [];
            $food->addons = [];

            if (!empty($item['modifiers']) && is_array($item['modifiers'])) {
                $food->modifiers = Modifier::whereIn('id', $item['modifiers'])->get();
            }

            if (!empty($item['addons']) && is_array($item['addons'])) {
                $food->addons = Addon::whereIn('id', $item['addons'])->get();
            }

            $cart[$i]['food'] = $food;
        }

        return $cart;
    }


}
