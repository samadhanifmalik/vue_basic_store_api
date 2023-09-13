<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Cart::with('product')->get();
        // $condition = Cart::where('product_id', 32)->get();
        return response()->json([
            "status" => true,
            "message" => "Cart Item retrieved successfully.",
            "baseUrl" => Url('/')."/",
            "data" => $data
        ]);
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
    public function store(Request $request)
    {
        $cart=new Cart;
        // $productcondition = Cart::where('product_id', $request->product_id)->get();
        // $usercondition = Cart::where('user_id', $request->user_id)->get();
        // if(!$usercondition){
            $cart->quantity= $request->quantity;
            $cart->user_id=$request->user_id;
            $cart->product_id=$request->product_id;
            $cart->save();
            return response()->json([
            "status" => true,
            "message" => "Added to Cart successfully.",
            "data" => $cart]);            
        // }
        // else{
        //     if(!$productcondition)
        //     {
        //         $cart->quantity= $request->quantity;
        //     $cart->user_id=$request->user_id;
        //     $cart->product_id=$request->product_id;
        //     $cart->save();
        //     return response()->json([
        //     "status" => true,
        //     "message" => "Added to Cart successfully.",
        //     "data" => $cart]); 
        //     }
        //     else
        //     {
        //         return response()->json([
        //             "status" => true,
        //             "message" => "Product is already in the Cart",
        //             "user" => $usercondition,
        //             "pro" => $usercondition,
        //         ]);
        //     }
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cart = Cart::with('product')->where('user_id', $id)->get();

    
        if (is_null($cart)) {
            return response()->json([
                'status' => false,
                'message' => 'Cart Item not found'
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Cart Item found.",
            "baseUrl" => Url('/')."/",
            "data" => $cart,
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
    public function update(Request $request, $id)
    {
        $cart=Cart::find($id);
        $cart->quantity=$request->quantity;
        
                $cart->save();
                return response()->json([
                    "status" => true,
                    "message" => "Cart updated successfully.",
                    "data" => $cart
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
        $cart=Cart::find($id);
        if($cart){
        $cart->delete();
        return response()->json([
            "status" => true,
            "message" => "Cart Item deleted successfully.",
            "data" => $cart
        ]);
    }
    else{
        return response()->json([
            'status' => false,
            'message' => 'Sorry that Cart item not found for deletion'
        ]);
    }
    }
}
