<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductReq;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function index()
    {
        $data = Product::with('categories')->get();
        return response()->json([
            "status" => true,
            "message" => "Product retrieved successfully.",
            "baseUrl" => Url('/')."/",
            "data" => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductReq $request)
    {
        $input = $request->all();
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->minimum_qty = $request->minimum_qty;
        $product->stock_qty = $request->stock_qty;
        if ($request->file('photo')) {
            $image=$request->file('photo');
            // print_r($image);
            $destinationPath ='image/product/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $product->photo = $destinationPath.$profileImage;
        }
        $product->save();
        if ($request->has('categories')) {
            $category = Category::find($input['categories']);
            $product->categories()->attach($category);
        }
        return response()->json([
            "status" => true,
            "message" => "Product created successfully.",
            "data" => $product,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::with('categories')->find($id);
        if (is_null($product)) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Product found.",
            "data" => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductReq $request, $id)
    {
        $product = Product::find($id);
        $input = $request->all();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->minimum_qty = $request->minimum_qty;
        $product->stock_qty = $request->stock_qty;
        if ($request->file('photo')) {
            if($product->photo != null){
                $file_old = $product->photo;
                unlink($file_old);
           }
            $image=$request->file('photo');
            $destinationPath ='image/product/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $product->photo = $destinationPath.$profileImage;
        }
        $product->save();
        if ($request->has('categories')) {

            $category = Category::find($input['categories']);
            $product->categories()->sync($category);
        }
        return response()->json([
            "status" => true,
            "message" => "Product created successfully.",
            "data" => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            $product->categories()->detach();
            return response()->json([
                "status" => true,
                "message" => "Product deleted successfully.",
                "data" => $product
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Sorry!! Product not found for deletion'
            ]);
        }
    }
}
