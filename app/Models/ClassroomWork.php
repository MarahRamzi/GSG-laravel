<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassroomWork extends Model
{
    use HasFactory;

    const TYPE_ASSIGNMENT = 'Assignment' ;
    const TYPE_MATERIAL = 'Material' ;
    const TYPE_QUESTION = 'Question';

   const STATUS_PUBLISHED = 'Published';
   const STATUS_DRAFT = 'Draft';



    protected $fillable = [
        'classroom_id' , 'user_id' , 'topic_id' , 'title' ,
        'descreption', 'type ','status' , 'published_at' , 'options'
    ];

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

    public function comments()
    {
        return $this->morphMany(Comment::class , 'commentable')->latest();
    }
}