<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\V1\StoreProductRequest;
use App\Http\Requests\V1\UpdateProductRequest;
use App\Http\Resources\V1\ProductCollection;
use App\Http\Resources\V1\ProductResource;
use App\Models\Cart;
use App\Models\Store;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new ProductCollection(Product::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        return new ProductResource(Product::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return new ProductResource($product);
    }

    public function destroy(string $id){
        $product = Product::find($id);
        $product->delete();

        return response([
            "message" => "the product that has the id $product->id has been deleted successfully",
        ],200);
    }

    public function AddToCart(string $id){
        $product = Product::find($id);
        $currUserId = Auth::user()->id;
        $oldCart = Session::has("cart".(string)$currUserId) ? Session::get("cart".(string)$currUserId) : null;
        $cart = new Cart($oldCart);
        $cart->add($product,$product->id);

        Session::put("cart".(string)$currUserId,$cart);

        return response([
            "message" => "Added Successfully",
            "cart" => $cart,
        ],200);
    }

    public function GetCart(){
        $currUserId = Auth::user()->id;
        return response([
            "Cart" => Session::get("cart".(string)$currUserId),
        ],200);
    }

    public function DeleteCartProduct(string $id){
        $currUserId = Auth::user()->id;
        $product = Product::find($id);
        $oldCart = Session::get("cart".(string)$currUserId);
        $cart = new Cart($oldCart);

        $bool = $cart->delete($product,$id);

        Session::put("cart".(string)$currUserId,$cart);

        if(!$bool) return response([
            "message" => "nothing to delete here",
        ],404);

        return response([
            "message" => "Deleted Successfully",
            "new cart" => Session::get("cart".(string)$currUserId),
        ],200);
    }

}
