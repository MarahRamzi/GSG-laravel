<?php

namespace App\Models\scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class UserClassroomScope implements Scope
{
    public function  apply(Builder $builder , Model $model):void
     {

        if($id = Auth::id()){

            $builder->where('user_id' , '=', $id );
           }
    }


}