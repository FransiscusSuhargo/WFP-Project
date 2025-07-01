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
        $modifiers = $food->modifiers()->get();
        return view('customer.order.customize', compact('addOns', 'modifiers', 'food', 'cart', 'id'));
    }

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
