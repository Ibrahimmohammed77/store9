<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Str;

class ModelPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function before($user,$ability){
        if($user->super_admin){
            return true;
        }
    }
    public function __call($name, $args){
        $class_name=str_replace('Policy','',class_basename($name));
        $class_name=Str::plural(Str::lower($class_name));
        if($name=='viewAny'){
            $name='view';
        }
        $ability=$class_name .'.'.Str::kebab($name);
        $user=$args[0];
        if(isset($args[1])){
            $model=$args[1];
            if($model->store_id!==$user->store_id){
                return false;
            }
        }
        return $user->hasAbility($ability);
    }
}
