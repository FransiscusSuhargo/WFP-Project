<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Foods\Category;
use App\Models\Foods\Food;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
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
        $customer->member_start_date = Carbon::createFromFormat('Y-m-d', $request->start_date)->format('Y-m-d');;
        $customer->member_end_date = Carbon::createFromFormat('Y-m-d', $request->end_date)->format('Y-m-d');
        $customer->status = $request->status;
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


}
