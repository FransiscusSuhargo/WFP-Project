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
        return redirect()->back()->withInput()->withErrors(['error' => 'Failed to update food!']);

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


}
