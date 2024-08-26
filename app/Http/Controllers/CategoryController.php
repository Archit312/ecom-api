<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Store a new category
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $category_name = $request->input('category_name');
        $category_code = $category_name . '-' . rand(1000, 9999);

        $category = Category::create([
            'category_code' => $category_code,
            'category_name' => $category_name,
        ]);

        return response()->json($category, 201);
    }

    // Fetch a category by category_code
    public function show($category_code)
    {
        $category = Category::where('category_code', $category_code)->first();


        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category, 200);
    }

    // Update a category by category_code
    public function update(Request $request, $category_code)
    {
        $request->validate([
            'category_name' => 'sometimes|string|max:255',
        ]);
        
        $category = Category::where('category_code', $category_code)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->update($request->only('category_name'));

        return response()->json($category, 200);
    }

    // Delete a category by category_code
    public function destroy($category_code)
    {
        $category = Category::where('category_code', $category_code)->first();

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
