<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id' , 'commentable_type' , 'commentable_id' , 'content' , 'ip' , 'user_agent'];

    protected $with = [
        'user' //automatic Eager load
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Deleted User'
        ]);
    }

    public function commentable():MorphTo
    {
        return $this->morphTo();
    }
}