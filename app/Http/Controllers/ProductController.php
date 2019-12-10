<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {

        $products = Product::all();

        return response()->json($products);
    }

    public function show(Request $request)
    {
        $product = Product::find($request->product);

        return response()->json($product);
    }

    public function store(ProductRequest $request)
    {

        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->save();

        info("Stored new company id=$product->id");

        return response()->json(true);
    }

    public function update(ProductRequest $request)
    {

        $product = Product::find($request->product);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->update();

        info("Updated company id=$product->id");

        return response()->json(true);
    }

    public function destroy(Product $product)
    {

        $product->delete();

        info("Deleted company id=$product->id");

        return response()->json(true);
    }
}
