<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\scopes\UserClassroomScope;
use App\scopes\ActiveScope;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Translation\HasLocalePreference;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable; #alias
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail ,HasLocalePreference
{
    use HasApiTokens, HasFactory, Notifiable; #traits

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    protected function email()
    {
        return Attribute::make(
            get: fn ($value) => strtoupper($value),
            set: fn ($value) => strtolower($value)
        );
    }

    public function classrooms():BelongsToMany
    {
  return $this->belongsToMany(Classroom::class , 'classroom_user' , 'user_id' ,'classroom_id' , 'id' , 'id' )
      ->withPivot(['rule']);

    //    return $this->belongsToMany(Classroom::class , 'classroom_user' ,'classroom_id' , 'user_id' , 'id' , 'id' )
    //    ->withPivot(['rule','classroom_id']);
                         // (model , pivot table , fk in pivot table , pk related to fk)
    }

    public function classroomWorks()
    {
        return $this->belongsToMany(ClassroomWork::class)
        ->using(ClassworkUser::class)
        ->withPivot('grade' , 'status' , 'submited_at' , 'created_at');
    }

    public function comments():HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function submissions() : HasMany
    {
        return $this->hasMany(Submission::class);
    }

    public function profile():HasOne
    {
        return $this->hasOne(Profile::class)
        ->withDefault();
    }

    public function subscriptions() :HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function routeNotificationForMail( $notification = null)
    {
        // change column use to send email
            return $this->email;
    }

    public function routeNotificationForVonage( $notification = null)
    {
            // change column use to resive sms msg
            // return $this->mobile;
            return '972599050979';
    }

    // public function receivesBroadcastNotificationsOn()
    // {
    //     customize channel name in broadcast notifications and change name in channels file in routes
    //     return 'Notifications.' . $this->id;
    // }

    public function preferredLocale()
    {
        // send notification according receive user language (default according sent server language)
        return $this->profile->locale;
    }

}