<?php

namespace App\Http\Controllers;

use App\Models\Foods\Category;
use App\Models\Foods\Food;
use Illuminate\Http\Request;
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
        return view('admin.food.add', compact('categories'));
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
            return redirect()->route('food.edit', $food->id)->with('success', 'Successfully updated food!');
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


}
