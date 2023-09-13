<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCategoryReq;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $data = Category::with('children')->get();
      

        return response()->json([
            "status" => true,
            "message" => "Category retrieved successfully.",
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
    public function store(StoreCategoryReq $request)
    {
        
        $category=new Category;
        $category->name=$request->name;
        $category->description=$request->description;
        $category->parent_id=$request->parent_id;
        if ( $request->file('photo')) {
            $image=$request->file('photo');
            $destinationPath ='image/category/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $category->photo = $destinationPath.$profileImage;
        }
       $category->save();
        return response()->json([
            "status" => true,
            "message" => "Category created successfully.",
            "data" => $category,
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
        $category = Category::with('children')->find($id);
        if (is_null($category)) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ]);
        }

        return response()->json([
            "success" => true,
            "message" => "Category found.",
            "data" => $category,
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
    public function update(StoreCategoryReq $request, $id)
    {
        $category=Category::find($id);
        $category->name=$request->name;
        $category->description=$request->description;
        $category->parent_id=$request->parent_id;
        
                if ($image = $request->file('photo')) {
                    if($category->photo != null){
                        $file_old = $category->photo;
                        unlink($file_old);
                   }
                   $image=$request->file('photo');
                   $destinationPath ='image/category/';
                   $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                   $image->move($destinationPath, $profileImage);
                   $category->photo = $destinationPath.$profileImage;
                }
                $category->save();
                return response()->json([
                    "status" => true,
                    "message" => "Category updated successfully.",
                    "data" => $category
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
        $category=Category::find($id);
        if($category){
        $category->delete();
        return response()->json([
            "status" => true,
            "message" => "Category deleted successfully.",
            "data" => $category
        ]);
    }
    else{
        return response()->json([
            'status' => false,
            'message' => 'Sorry that Category not found for deletion'
        ]);
    }
    }
}
