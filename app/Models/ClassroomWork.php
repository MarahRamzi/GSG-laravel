<?php

namespace App\Models;

use App\Enums\classworkType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassroomWork extends Model
{
    use HasFactory;

    const TYPE_ASSIGNMENT = 'assignment' ;
    const TYPE_MATERIAL = 'material' ;
    const TYPE_QUESTION = 'question';

   const STATUS_PUBLISHED = 'published';
   const STATUS_DRAFT = 'draft';



    protected $fillable = [
        'classroom_id' , 'user_id' , 'topic_id' , 'title' ,
        'descreption', 'type' ,'status' , 'published_at' , 'options'
    ];

    protected $casts = [
        'options' => 'json',
        'published_at' => 'datetime',
        // 'type' => classworkType::class,
        //قيمة الحقل لما بدي اخزنو او اقرا  منو لازم يكون نوع من انواع(enum)
    ];

    protected static function booted()
    {
        static::creating(function(ClassroomWork $classwork){
            if(!$classwork->published_at){
                $classwork->published_at = now();
            }
        });
    }

    public function scopeFilter(EloquentBuilder $builder , $filters )
   {
        $builder->when($filters['search']  ?? '', function ($query , $value){
            $query->where(function($query) use ($value){ //group
                $query->where('title' , 'LIKE' , "%{$value}%")
                ->orWhere('descreption', 'LIKE' , "%{$value}%");
            });
        });
   }

    public function getPublishedDateAttribute()
    {
        if($this->published_at)
        {
            return  $this->published_at->format('Y-m-d'); //published_at => carbon object because passed in cast property
        }
    }


    public function classroom() : BelongsTo
    {
        return $this->belongsTo(Classroom::class , 'classroom_id' , 'id');
    }

    public function topic() : BelongsTo
    {
        return $this->belongsTo(Topic::class , 'topic_id' , 'id');
    }

    public function users()
    {
        return $this -> belongsToMany(User::class)
          ->withPivot('grade' , 'submited_at' , 'status' , 'created_at')
          ->using(ClassworkUser::class);

    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class , 'commentable')->latest();
    }

    public function submissions() : HasMany
    {
        return $this->hasMany(Submission::class , 'classroom_work_id' ,'id');
    }
}
