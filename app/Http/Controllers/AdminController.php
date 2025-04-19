<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Foods\Category;
use App\Models\Foods\Food;
use App\Models\Orders\Order;
use App\Models\Orders\OrderDetail;
use App\Models\Orders\Payments;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Response;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Component\HttpFoundation\RateLimiter\RequestRateLimiterInterface;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.index');
    }

    // Food Master

    public function showFood(){
        $foods = Food::all();
        return view('admin.food.index', compact('foods'));
    }

    public function editFood(String $id){
        $food = Food::find($id);
        $categories = Category::all();
        return view('admin.food.edit', compact('food', 'categories'));
    }

    public function addFood(){
        $categories = Category::all();
        return view('admin.food.insert', compact('categories'));
    }

    public function insertFood(Request $request)
    {
        $food = new Food();
        $food->name = $request->name;
        $food->description = $request->description;
        $food->nutrition_value = $request->nutrition;
        $food->price = $request->price;
        $food->category_id = $request->category; 
        $food->created_at = Carbon::now();
        $food->updated_at = Carbon::now();

        if ($food->save()) {
            return redirect()->route('food.index')->with('success', 'Successfully added data!');
        }
        return redirect()->route('food.index')->withErrors('Failed to add data. Please try again.');
    }


    public function updateFood(Request $request){
        $food = Food::find($request->id);
        $food->name = $request->name;
        $food->description = $request->description;
        $food->nutrition_value = $request->nutrition;
        $food->price = $request->price;
        $food->category->id = $request->category;
        if ($food->save()) {
            return redirect()->route('food.index')->with('success', 'Successfully updated food!');
        }    
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update food!']);
    }

    public function deleteFood($id)
    {
        $food = Food::find($id);

        if (!$food) {
            return redirect()->route('food.index')->withErrors(['error' => 'Food not found!']);
        }
        $foodName = $food->name;

        if ($food->delete()) {
            return redirect()->route('food.index')->with('success', 'Successfully delete ' . $foodName);
        }

        return redirect()->route('food.index')->withErrors(['error' => 'Failed to delete ' . $foodName]);
    }

    // Master Category

    public function showCategory(){
        $categories = Category::all();
        return view('admin.category.index', compact('categories'));
    }

    public function addCategory(){
        return view('admin.category.insert');
    }

    public function editCategory($id){
        $category = Category::find($id);
        return view('admin.category.edit', compact('category'));

    }

    public function updateCategory(Request $request){
        $category = Category::find($request->id);
        $category->name = $request->name;
        if ($category->save()) return redirect()->route('category.index')->with('success', 'Successfully Edit Category!');
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update customer!']);

    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('category.index')->withErrors(['error' => 'Category not found!']);
        }
        $categoryName = $category->name;

        if ($category->delete()) {
            return redirect()->route('category.index')->with('success', 'Successfully delete ' . $categoryName);
        }

        return redirect()->route('category.index')->withErrors(['error' => 'Failed to delete ' . $categoryName]);
    }

    public function insertCategory(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->created_at = Carbon::now();
        $category->updated_at = Carbon::now();

        if ($category->save()) {
            return redirect()->route('category.index')->with('success', 'Successfully added data!');
        }
        return redirect()->route('category.index')->withErrors('Failed to add data. Please try again.');
    }

    //Master Customer
    public function showCustomer(){
        $customers = Customer::all();
        return view('admin.customer.index', compact('customers'));
    }

    public function addCustomer(){
        $users = User::all();
        return view('admin.customer.insert', compact('users'));
    }

    public function insertCustomer(Request $request){
        $customer = new Customer();
        $customer->name = $request->name;
        $customer->user_id = $request->user_id;
        $customer->member_start_date = Carbon::createFromFormat('Y-m-d', $request->start_date)->format('Y-m-d');
        $customer->member_end_date = Carbon::createFromFormat('Y-m-d', $request->end_date)->format('Y-m-d');
        $customer->status = $request->status;
        $customer->created_at = Carbon::now();
        $customer->updated_at = Carbon::now();
        if ($customer->save()) {
            return redirect()->route('customer.index')->with('success', 'Successfully added data!');
        }
        return redirect()->route('customer.index')->withErrors('Failed to add data. Please try again.');
        
    }

    public function editCustomer($id){
        $customer = Customer::find($id);
        $users = User::all();
        return view('admin.customer.edit', compact('customer', 'users'));
    }

    public function updateCustomer(Request $request){
        $customer = Customer::find($request->id);
        $customer->name = $request->name;
        $customer->user_id = $request->user_id;
        $customer->member_start_date = $request->start_date;
        $customer->member_end_date = $request->end_date;
        $customer->status = $request->status;
        if ($customer->save()) return redirect()->route('customer.index')->with('success', 'Successfully Edit Customer!');
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update Customer!']);
    }

    public function deleteCustomer($id){
        $customer = Customer::find($id);
        if (!$customer) {
            return redirect()->route('customer.index')->withErrors(['error' => 'Customer not found!']);
        }
        $customerName = $customer->name;

        if ($customer->delete()) {
            return redirect()->route('customer.index')->with('success', 'Successfully delete ' . $customerName);
        }

        return redirect()->route('customer.index')->withErrors(['error' => 'Failed to delete ' . $customerName]);
    }

    //Master Order
    public function showOrder(){
        $orders = Order::all();
        return view('admin.order.index', compact('orders'));
    }

    public function addOrder(){
        $customers = Customer::all();
        $payments = Payments::all();
        return view('admin.order.insert', compact('customers', 'payments'));
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

    public function editOrder($id){
        $order = Order::find($id);
        $customers = Customer::all();
        $payments = Payments::all();
        return view('admin.order.edit', compact('order', 'customers', 'payments'));
    }

    public function updateOrder(Request $request){
        $order = Order::find($request->id);
        $order->customer_id = $request->customer_id;
        $order->payment_id = $request->payment_id;
        $order->date = Carbon::parse($request->date)->format('Y-m-d H:i:s');
        $order->queue_number = $request->queue_number;
        $order->type = $request->type;
        $order->status = $request->status;
        $order->created_at = Carbon::now();
        $order->updated_at = Carbon::now();

        if ($order->save()) {
            return redirect()->route('order.index')->with(['success' => 'Successfully Update Order']);
        }
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update Order!']);
    }

    public function deleteOrder($id){
        $order = Order::find($id);
        $orderQueue = $order->queue_number;

        if ($order->delete()) {
            return redirect()->route('order.index')->with(['success' => 'Successfully Delete Order ' . $orderQueue]);
        }
        return redirect()->route('order.index')->with(['error' => 'Failed to delete Order ' . $orderQueue]);
    }

    public function showReportCategory(){
        $categories = Category::withCount('foods')->orderBy('foods_count', 'desc')->get();
        return view('admin.report.category', compact('categories'));
    }

    public function showReportRecap(Request $request){
        $monthYear = $request->input('monthYear'); // format: 2025-04

        if ($monthYear) {
            [$year, $month] = explode('-', $monthYear);
        } else {
            $month = now()->month;
            $year = now()->year;
        }

        $orders = Order::whereYear('date', $year)
                        ->whereMonth('date', $month)
                        ->pluck('id');

        $totalRevenue = OrderDetail::whereIn('order_id', $orders)->sum('subtotal');

        $foodOrders = OrderDetail::whereIn('order_id', $orders)
                        ->select('food_id')
                        ->selectRaw('COUNT(*) as total_order')
                        ->groupBy('food_id')
                        ->orderBy('total_order', 'desc')
                        ->with('food')
                        ->get();

        $totalCustomers = Order::whereYear('date', $year)
                        ->whereMonth(column: 'date', operator: $month)
                        ->distinct('customer_id')
                        ->count('customer_id');

        // return response()->json(compact( 'totalRevenue', 'foodOrders', 'totalCustomers'));
        return view('admin.report.recap', compact( 'totalRevenue', 'foodOrders', 'totalCustomers'));
    }

    public function showReportCustomer(){
        $customers = Customer::withCount('orders')->orderBy('orders_count', 'desc')->get();
        return view('admin.report.customer', compact('customers'));
    }

    public function showReportFood(){
        $foods = OrderDetail::with('food')
            ->selectRaw('food_id, COUNT(*) as sold_count')
            ->groupBy('food_id')
            ->orderByDesc('sold_count')
            ->get()
            ->map(function ($item) {
                return (object)[
                    'id' => $item->food->id,
                    'name' => $item->food->name,
                    'sold_count' => $item->sold_count,
                ];
            });
        return view('admin.report.food', compact('foods'));
    }

    public function showReportDate(){
        $orders = Order::selectRaw('DATE(date) as order_date, COUNT(*) as order_count')
            ->groupBy('order_date')
            ->orderByDesc('order_count')
            ->get();
        return view('admin.report.date', compact('orders'));
    }       
}
