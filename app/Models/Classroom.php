<?php

namespace App\Models;

use App\Models\scopes\UserClassroomScope;
use App\Observers\ClassroomObserver;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\str;
use PhpParser\Node\Stmt\Static_;
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


    protected $appends= [
        'cover_image_url' ,

    ];

    protected $hidden =[
        'cover_image_path',
        'deleted_at'
    ];

    protected static function booted()
    {
        // static::addGlobalScope('user' , function(Builder $query)
        // {
        //     $query->where('user_id' , Auth::id());
        // });

        static::addGlobalScope(new UserClassroomScope());
        static::observe(ClassroomObserver::class);


        // static::creating(function  (Classroom $classroom){
        //     $classroom->code = Str::random(7);
        //     $classroom->user_id = Auth::id();
        // });

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function classworks() :HasMany
    {
        return $this->hasMany(ClassroomWork::class , 'classroom_id' , 'id');
    }

    public function streams() :HasMany
    {
        return $this->hasMany(Stream::class );
    }


   public function topics() :HasMany
   {
    return $this->hasMany(Topic::class , 'classroom_id' , 'id');
   }

   public function users():BelongsToMany
   {
      return $this->belongsToMany(User::class , 'classroom_user' ,'classroom_id' , 'user_id' , 'id' , 'id' )
      ->withPivot(['rule']);
                        // (model , pivot table , fk in pivot table , pk related to fk)
   }

   public function teachers()
   {
     return $this->users()->where('rule' , '=' , 'teacher');
   }

   public function students()
   {
     return  $this->users()->where('rule' , '=' , 'student');
   }

   public function posts()
   {
        return $this->hasMany(Post::class);
   }

    public function gtRouteKeyName()
    {
        return 'id';
    }

    public static function deleteCoverImage($path){
        if($path && Storage::disk(Classroom::disk)->exists($path)){
            return  Storage::disk(Classroom::disk)->delete($path);
        }
    }


    public function join($user_id , $rule='student'){

            $exists = $this->users()->wherePivot('user_id' , '=' , $user_id)->exists();

        if($exists){
            throw new Exception('user already joined the classroom');

    }
        return $this->users()->attach($user_id , [
            'rule' => $rule,
            'created_at' => now(),
        ]);
    //    return DB::table('classroom_user')->insert([
    //         'classroom_id' => $this->id,
    //         'user_id' => $user_id,
    //         'rule' => $rule,
    //         'created_at' => now(),
    //        ]);


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