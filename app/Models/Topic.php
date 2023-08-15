<?php

namespace App\Models;

use App\Models\Scopes\UserClassroomScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Topic extends Model
{
    use HasFactory ,SoftDeletes;

    public $timestamps = false ;

protected $fillable = ['name'  ,'classroom_id' , 'user_id'];

protected static function booted()
{
    static::addGlobalScope(new UserClassroomScope);
}

public function classworks()
{
    return $this->hasMany(ClassWork::class , 'topic_id' , 'id');
}



}
