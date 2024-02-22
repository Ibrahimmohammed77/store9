<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($category)
    {
        try{
            $category = Category::where("id", $category)->active()->firstOrFail();
           
        }catch(\Exception $e){
            return redirect()->back()->with("error", $e->getMessage());
        }
        return view('front.category.category_products')
        ->with('category', $category);
        // return view('front.category.show')
        // ->with([
        //     'product'=> $category->products()->paginate(),
        //     'categories'=>Category::select('name','id')->get(),
        // ]);

    }
}
