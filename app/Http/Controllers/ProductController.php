<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Fetch all products
    public function index()
    {
        return Product::all();
    }

    // Fetch a single product
    public function show($id)
    {
        return Product::find($id);
    }

    // Insert a new product
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_category' => 'required|string|max:255',
            'product_quantity' => 'required|string|max:255',
            'product_desc' => 'required|string|max:255',
            'product_price' => 'required|integer',
            'product_img_main' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50',
            'product_img_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50',
            'product_img_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50',
            'product_img_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50',
            'product_delivery_time' => 'required|integer',
        ]);

        // Generate unique product code
        $firstWord = strtok($request->product_name, " ");
        do {
            $productCode = $firstWord . rand(1000, 9999);
        } while (Product::where('product_code', $productCode)->exists());

        $validatedData['product_code'] = $productCode;

        // Handle main image upload
        if ($request->hasFile('product_img_main')) {
            $imageNameMain = $request->product_name . '_main_' . rand(1000, 9999) . '.' . $request->product_img_main->extension();
            $request->product_img_main->move(public_path('images'), $imageNameMain);
            $validatedData['product_img_main'] = 'images/' . $imageNameMain;
        }

        // Handle optional images upload
        if ($request->hasFile('product_img_1')) {
            $imageName1 = $request->product_name . '_1_' . rand(1000, 9999) . '.' . $request->product_img_1->extension();
            $request->product_img_1->move(public_path('images'), $imageName1);
            $validatedData['product_img_1'] = 'images/' . $imageName1;
        }

        if ($request->hasFile('product_img_2')) {
            $imageName2 = $request->product_name . '_2_' . rand(1000, 9999) . '.' . $request->product_img_2->extension();
            $request->product_img_2->move(public_path('images'), $imageName2);
            $validatedData['product_img_2'] = 'images/' . $imageName2;
        }

        if ($request->hasFile('product_img_3')) {
            $imageName3 = $request->product_name . '_3_' . rand(1000, 9999) . '.' . $request->product_img_3->extension();
            $request->product_img_3->move(public_path('images'), $imageName3);
            $validatedData['product_img_3'] = 'images/' . $imageName3;
        }

        // Create product
        return Product::create($validatedData);
    }


    // Update an existing product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'product_name' => 'required|string|max:255',
            'product_category' => 'required|string|max:255',
            'product_quantity' => 'required|string|max:255',
            'product_desc' => 'required|string|max:255',
            'product_price' => 'required|integer',
            'product_img_main' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50',
            'product_img_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50',
            'product_img_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50',
            'product_img_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50',
            'product_delivery_time' => 'required|integer',
        ]);

        // Generate unique product code if product_name is changed
        if ($product->product_name !== $request->product_name) {
            $firstWord = strtok($request->product_name, " ");
            do {
                $productCode = $firstWord . rand(1000, 9999);
            } while (Product::where('product_code', $productCode)->exists());

            $validatedData['product_code'] = $productCode;
        }

        // Handle main image upload
        if ($request->hasFile('product_img_main')) {
            $imageNameMain = $request->product_name . '_main_' . rand(1000, 9999) . '.' . $request->product_img_main->extension();
            $request->product_img_main->move(public_path('images'), $imageNameMain);
            $validatedData['product_img_main'] = 'images/' . $imageNameMain;
        }

        // Handle optional images upload
        if ($request->hasFile('product_img_1')) {
            $imageName1 = $request->product_name . '_1_' . rand(1000, 9999) . '.' . $request->product_img_1->extension();
            $request->product_img_1->move(public_path('images'), $imageName1);
            $validatedData['product_img_1'] = 'images/' . $imageName1;
        }

        if ($request->hasFile('product_img_2')) {
            $imageName2 = $request->product_name . '_2_' . rand(1000, 9999) . '.' . $request->product_img_2->extension();
            $request->product_img_2->move(public_path('images'), $imageName2);
            $validatedData['product_img_2'] = 'images/' . $imageName2;
        }

        if ($request->hasFile('product_img_3')) {
            $imageName3 = $request->product_name . '_3_' . rand(1000, 9999) . '.' . $request->product_img_3->extension();
            $request->product_img_3->move(public_path('images'), $imageName3);
            $validatedData['product_img_3'] = 'images/' . $imageName3;
        }

        $product->update($validatedData);

        return $product;
    }


    // Delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json("Deleted Sucessfully", 200);
    }
}
