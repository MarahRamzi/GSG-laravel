<?php
namespace App\Notifications\Channels;

use Illuminate\Support\Facades\Notification;

class HadaraSmsChannel
{
    public function send(object $notifiable , Notification $notification )
    {
            Http::get();
    }
}