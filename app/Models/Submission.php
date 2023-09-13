<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = ['user_id' , 'classroom_work_id' , 'content' , 'type'];

    public function classwork():BelongsTo
    {
        return $this->belongsTo(ClassroomWork::class , 'classroom_work_id' ,'id');
    }
}
