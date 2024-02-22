<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'slug', 'price', 'store_id', 'category_id', 'compare_price', 'status', 'image', 'description'
    ];
    protected $hidden=[
        'created_at', 'updated_at', 'image'
    ];
     protected $appends=[
        'image_url'
     ];
    public static function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }

    protected static function booted()
    {
        // static::addGlobalScope('store', function (Builder $builder) {
        //     $user = Auth::user();
        //     if ($user->store_id) {
        //         $builder->where('store_id', $user->store_id);
        //     }
        // });
        static::addGlobalScope(new StoreScope());
        static::creating(function(Product $product){
            $product->slug=Str::slug($product->name);
        });
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id'
        );
    }
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return asset("assets/front/images/products/product-1.jpg");
        }
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            // return $this->image;
            return asset("assets/front/images/products/product-1.jpg");
        }
        return asset("storage/" . $this->image);

    }
    public function getSalePercentPriceAttribute()
    {
        if (!$this->compare_price) {
            return 0;
        }
        return round(100 -(100 * $this->price / $this->compare_price),1);
    }
    public function scopeFilter(Builder $builder,$filters){
        $options=array_merge([
            'store_id' =>null,
            'category_id' =>null,
            'status'=>'active',
            'tag_id' =>null
        ],$filters);
        // store_id 
        $builder->when($options['store_id'],function($builder,$value){
            $builder->where('store_id',$value);
        });   
        // category_id
         $builder->when($options['category_id'],function($builder,$value){
            $builder->where('category_id',$value);
        });
        // status 
        $builder->when($options['category_id'],function($builder,$value){
            $builder->where('category_id',$value);
        });
        // tag_id
        // $builder->whereRaw('EXISTS (SELECT 1 FROM product_tag WHERE tag_id =? AND product_id=products.id)');
         $builder->when($options['tag_id'],function($builder,$value){
            $builder->whereExists(function ($query) use ($value){
                $query->select(1)
                ->from('product_tag')
                ->whereRaw('product_id= products.id')
                ->where('tag_id',$value);
            });
        });
    }
}
