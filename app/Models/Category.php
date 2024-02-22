<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'name', 'parent_id', 'description', 'slug', 'image', 'status'
    ];


    public static function scopeActive(Builder $builder)
    {
        $builder->where('status', 'active');
    }
    public function scopeFilter(Builder $build,$filters){
        $build->when($filters['name']??false,function($build,$value){
            // $build->where('name','LIKE',"%{$value}%");
            // becous Make Left Join I write Like This
            $build->where('categories.name','LIKE',"%{$value}%");
        });
        $build->when($filters['status']??false,function($build,$value){
            // $build->where('status','=',$value);
            // becous Make Left Join I write Like This
            $build->where('categories.status','=',$value);
        });
        // if($name=$filters->query('name')){
        //     $build->where('name','LIKE',"%{$name}%");
        // }
        //  if($name=$filters->query('status')){
        //     $build->whereStatus("$name");
        // }
    }

    public function parent(){
        return $this->belongsTo(Category::class,'parent_id','id')
        ->withDefault([
            'name' => '-'
        ]);
    }
    public function childs(){
        return $this->hasMany(Category::class,'parent_id','id');
    }
    public function products(){
        return $this->hasMany(Product::class,'category_id','id');
    }
    public static function rules($id = 0)
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                "unique:categories,name,$id",
                'filter:php,laravel',
                new Filter(['laravel','php']),
                function ($attribute, $value, $fails) {
                    if(strtolower($value)=="laravel"){
                        $fails("this is forbiden");
                    }
                }
            ],
            'parent_id' => ['nullable', 'integer', 'exists:categories,id'],
            'image' => 'image|max:1048567|dimensions:min_width:100,min_height:100',
            'status' => 'in:active,archive'
        ];
    }
}
