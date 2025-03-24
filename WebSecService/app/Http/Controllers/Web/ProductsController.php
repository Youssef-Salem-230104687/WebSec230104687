<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Web\Controller;
use App\Models\Product;

class ProductsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:employee')->except('list');
    }

    // Basic list method to fetch all products
    public function list(Request $request)
    {
        // Fetch all products (for demonstration purposes)
        $products = Product::all();

        // Example queries (for demonstration purposes)
        $productsLessThan20000 = Product::where('price', '<', 20000)->get();
        $productsCodeLikeTV = Product::where('code', 'like', 'tv%')->get();
        $productsOrderByPriceDesc = Product::orderBy('price', 'desc')->get();
        $productsBetween20000And40000 = Product::where('price', '>', 20000)->where('price', '<', 40000)->get();
        $productsGreaterThan40000OrLessThan20000 = Product::orWhere('price', '>', 40000)->orWhere('price', '<', 20000)->get();

        // Dynamic query building based on request parameters
        $query = Product::select("products.*");

        // Filter by keywords (name)
        $query->when($request->keywords, function ($q) use ($request) {
            return $q->where("name", "like", "%{$request->keywords}%");
        });

        // Filter by minimum price
        $query->when($request->min_price, function ($q) use ($request) {
            return $q->where("price", ">=", $request->min_price);
        });

        // Filter by maximum price
        $query->when($request->max_price, function ($q) use ($request) {
            return $q->where("price", "<=", $request->max_price);
        });

        // Sort by column and direction
        $query->when($request->order_by, function ($q) use ($request) {
            return $q->orderBy($request->order_by, $request->order_direction ?? "ASC");
        });

        // Execute the query and get the results
        $products = $query->get();

        // Pass the products to the view
        return view("products.list", compact('products'));
    }

    public function edit(Request $request, Product $product = null)
    {
        $product = $product ?? new Product();
        return view("products.edit", compact('product'));
    }

    public function save(Request $request, Product $product = null)
    {
        $this->validate($request, [
            'code' => ['required', 'string', 'max:32'],
            'name' => ['required', 'string', 'max:128'],
            'model' => ['required', 'string', 'max:256'],
            'description' => ['required', 'string', 'max:1024'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer'],
        ]);

        $product = $product ?? new Product();
        $product->fill($request->all());
        $product->save();

        return redirect()->route('products_list')->with('success', 'Product saved successfully.');
    }

    public function delete(Request $request, Product $product)
    {
        $product->delete();
        return redirect()->route('products_list')->with('success', 'Product deleted successfully.');
    }

    public function purchase(Request $request, Product $product)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'You must be logged in to purchase products.');
        }

        if ($user->credit < $product->price) {
            return redirect()->back()->with('error', 'You do not have enough credit to purchase this product.');
        }

        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'This product is out of stock.');
        }

        // Deduct the product price from user's credit
        $user->credit -= $product->price;
        $user->save();

        // Reduce the product stock
        $product->stock -= 1;
        $product->save();

        // Record the purchase (assuming you have a Purchase model)
        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'price' => $product->price,
        ]);

        return redirect()->route('products_list')->with('success', 'Product purchased successfully!');
    }
}