<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $primaryKey ='user_id';
    protected $fillable =[
        'first_name','last_name','birth_day','gender','city','country','state','local'
    ];
    public function user(){
        return $this->hasOne(User::class,'user_id','id');
    }
}
