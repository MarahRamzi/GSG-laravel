<?php

namespace App\Models;

use App\Models\scopes\UserClassroomScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\str;

use Stringable;

class Classroom extends Model
{
    use HasFactory ,SoftDeletes;

    public static string $disk = 'public' ;

    protected $connection = 'mysql';

    protected $table = 'classrooms' ;

    protected $primarykey = 'id';

    protected $keyType = 'int';  //DT of PK

    public $incrementing = true; //PK is autoincrement

    public $timestamps = true ;

    //determine col name that are use with mass asignment in fillable
    protected $fillable =['name' , 'section' , 'subject' , 'room' , 'cover_image_path' , 'theme' ,'code' , 'user_id'];

    protected static function booted()
    {
        static::addGlobalScope('user' , function(Builder $query)
        {
            $query->where('user_id' , Auth::id());
        });


        static::creating(function  (Classroom $classroom){
            $classroom->code = Str::random(7);
            $classroom->user_id = Auth::id();
        });
    }

    public function gtRouteKeyName()
    {
        return 'id';
    }


    public function classworks() :HasMany
    {
        return $this->hasMany(ClassWork::class , 'classroom_id' , 'id');
    }

    public function topics() : HasMany
    {
        return $this->hasMany(Topic::class , 'topic_id' , 'id');
    }

    public function join($user_id , $role = 'student')
    {
        DB::table('classroom_user')->insert([ //join
            'classroom_id' => $this->id,
            'user_id' => $user_id,
            // 'role' => $request->input('role' , 'student'),
            'created_at' => now()
        ]);
    }

//get(attributeName)Attribute ,,to exists column
    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    //doesnt exists attribute
    public function getCoverImageUrlAttribute($value)
    {
        if($this->cover_image_path){
            return Storage::disk(static::$disk)->url($this->cover_image_path);
        }

        return 'https://placehold.co/800x300.png';
    }
//insted show route
    public function getUrlAttribute()
    {
        return route('classrooms.show',$this->id);
    }


    public function scopeActive(Builder $query , $status='active')
    {
        $query->where('status', '=' , $status );
    }

}