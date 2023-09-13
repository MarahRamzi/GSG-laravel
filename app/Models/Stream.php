<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Stream extends Model
{
    use HasFactory , HasUuids;

    public $incrementing = false ;

    protected $keyType = 'string' ;

    protected $fillable = ['classroom_id' , 'user_id' , 'content' , 'link'];

    public function getUpdatedAtColumn()
    {
        //unsupport updated_at column
    }

//    public function setUpdatedAt($value)
//    {
//     return $this;
//    }

protected static function booted()
{
    // static::creating(function(Stream $stream){
    //         $stream->id = Str::uuid(); // Not MassAssignment
    // });
}

// public function uniqueIds()
// {
    // return [     بعرف بداخلها الاعمدة الي بدي اياها تتعرف تلقائي من لارفيل باستخدام uuid
    //     'id' , 'uuid' ,
    // ];
// }



    public function user()
    {
        return  $this->belongsTo(User::class);
    }

    public function classroom()
    {
        return  $this->belongsTo(Classroom::class);
    }

}
