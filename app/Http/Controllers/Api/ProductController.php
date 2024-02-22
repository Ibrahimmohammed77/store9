<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return Product::filter($request->query())->with('category','store')->paginate();
        $products= Product::filter($request->query())->with('category','store')->paginate();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max: 255',
            'description'=>'nullable|string|max: 255',
            'status'=>'in:active,inactive',
            'category_id'=>'required|integer|exists:categories,id',
            'price'=>'required|numeric|min:0',
            'compare_price'=>'nullable|numeric|gt:price',
        ]);
        // $user=$request->user();
        // $token_can=$user->tokenCan('product.create');
        // // dd($user);
        // if(isset($token_can)){
        //     return Response::json([
        //         'message'=>' not Allowed to create You do not have ability to create'
        //     ],403);
        // }
        $product = Product::create($request->all());
        return Response::json($product,201,[
            'Location' =>route("products.show",$product->id)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // return $product->load('category:id,name','store:id,name');
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=>'sometimes|required|string|max: 255',
            'description'=>'nullable|string|max: 255',
            'status'=>'in:active,inactive',
            'category_id'=>'sometimes|required|integer|exists:categories,id',
            'price'=>'sometimes|required|numeric|min:0',
            'compare_price'=>'nullable|numeric|gt:price',
        ]);
        // $user=$request->user();
        // if(!$user->tokenCan('product.update')){
        //     return Response::json([
        //         'message'=>' not Allowed to update You do not have ability to create'
        //     ],403);
        // }
        $product->update($request->all());
        return Response::json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $user=Auth::guard('sanctum')->user();
        // if(!$user->tokenCan('product.delete')){
        //     return Response::json([
        //         'message'=>' not Allowed to delete You do not have ability to create'
        //     ],403);
        // }
        Product::destroy($id);
        return response()->json([
            'message' => 'Success deleting',
        ],200);
    }
}
