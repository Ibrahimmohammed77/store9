<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Gate::allows('categories.view')){
            abort(403);
        }
        // $categories = Category::paginate(2);
        $request = request();
        // $query=Category::query();
        // if($name=$request->query('name')){
        //     $query->where('name','LIKE',"%{$name}%");
        // }
        //  if($name=$request->query('status')){
        //     $query->whereStatus("$name");
        // }

        // $categories = Category::leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
        //     ->select([
        //         'categories.*',
        //         'parents.name as parent_name'
        //     ])
        //     ->filter($request->query())
        //     ->orderBy('categories.name')
        //     ->paginate();
            $categories = Category::with(['parent'])
            // Return Count Products To Category with out use relation
            // ->select('categories.*')
            // ->selectRaw('(SELECT COUNT(*) FROM products WHERE products.category_id=categories.id) as products_count' )
            // Return Count Products To Category with  use relation
            ->withCount('products')
            ->filter($request->query())
            ->orderBy('categories.name')
            ->paginate();
        return view('dashboard/categories/index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('categories.create');
        $category = new Category();
        $parents = Category::all();
        return view('dashboard/categories/create', compact('category', 'parents'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        Gate::authorize('categories.create');
        $request->validate(Category::rules());
        // $request->validate([
        //     'name' =>'required|string|min:3|unique:categories,name',
        //     'parent_id'=>['nullable','integer','exists:categories,id'],
        //     'image'=>'image|max:1048567|dimensions:min_width:100,min_height:100',
        //     'status'=>'in:active,archive'
        // ]);
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);
        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);
        $category = Category::create($data);
        return redirect()->route('dashboard.categories.index')->with('success', 'create success');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $products=$category->products()->with('store')->paginate(5);
        return view('dashboard.categories.show')->with(['category'=>$category,'products'=>$products]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (Exception $e) {
            return redirect()->route('dashboard.categories.index')
                ->with('error', 'not Found');
        }
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })->get();
        // ->orWhere('parent_id', '')
        return view('dashboard/categories/edit')->with([
            'category' => $category, 'parents' => $parents
        ]);
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
        $request->validate(Category::rules($id));
        $category = Category::findOrFail($id);
        $old_image = $category->image;
        $data = $request->except('image');
        // if ($request->hasFile('image')) {
        //     $file = $request->file('image');
        // $path = $file->store('category', [
        //     'disk' => 'uploads'
        // ]);
        //     $path = $file->store('uploads', [
        //         'disk' => 'public'
        //     ]);
        $new_img = $this->uploadImage($request);
        if ($new_img) {
            $data['image'] = $new_img;
        }
        $category->update($data);
        // }
        // if ($old_image && new_img) {
        //     Storage::disk('public')->delete($old_image);
        // }
        $this->deleteImage($old_image, $new_img);
        return redirect()->route('dashboard.categories.index')
            ->with('success', 'success updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        // if ($category->image) {
        //     Storage::disk('public')->delete($category->image);
        // }
        return redirect()->route('dashboard.categories.index')
            ->with('success', 'deleted success');
    }
    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public',
        ]);
        return $path;
    }
    protected function deleteImage($old_image, $new_img)
    {
        if ($old_image && $new_img) {
            Storage::disk('public')->delete($old_image);
            return;
        }
        return;
    }
    public function trash()
    {
        $categories = Category::leftJoin('categories as parents','parents.id','=','categories.parent_id')
        ->select([
            'categories.*',
            'parents.name as parent_name'
        ])
        ->onlyTrashed()
        ->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }
    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.index')
        ->with('success','Category Restored !');
    }
    public function forceDelete(Request $request,$id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.trash')
        ->with('success','Category Deleted Forever !');
    }
}
