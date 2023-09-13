<?php

namespace App\Notifications;

use App\Models\ClassroomWork;
use DragonCode\Contracts\Cashier\Auth\Auth;
use DragonCode\Support\Facades\Helpers\Arr;
use Illuminate\Broadcasting\BroadcastManager;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\VonageMessage;

class NewClassworkNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected ClassroomWork $classwork)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // channels : mail , database , broadcast , vonage(sms) , slack
        $via = ['database' , 'broadcast' ,'vonage', 'mail'];
        return $via;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $classwork = $this->classwork ;
        $content = __(':name posted a new :type :title' , [ //translation function
            'name' =>$classwork->user->name,
            'type' => __($classwork->type),
            'title'=> $classwork->title,
        ]);

        return (new MailMessage)
                    ->subject(__('Add New :type' , ['type'=> $classwork->type ]))
                    ->greeting(__('Dear :name' , ['name' => $notifiable->name]))
                    ->line($content)
                    ->action(__('Go to classwork'), route('classrooms.classworks.show' , [$classwork->classroom->id , $classwork->id]))
                    ->line('Thank you for using our application!');
    }


    public function toDatabase(object $notifiable) :DatabaseMessage
    {

        return new DatabaseMessage($this->createMessage()); // DatabaseMessage => بياخد مصفوفة بالبيانات الفعلية الي بدي امررها
        // المصفوفة تتخزن في حقل data => الموجود في جدول notifications (json format)

    }

    public function toBroadcast(object $notifiable) :BroadcastMessage
    {


        return new BroadcastMessage($this->createMessage());
    }

    protected function createMessage() :array // حل التكرار
    {
        $classwork = $this->classwork ;
        $content = __(':name posted a new :type :title' , [ //translation function
            'name' =>$classwork->user->name,
            'type' => __($classwork->type),
            'title'=> $classwork->title,
        ]);

        return [
            'title' => __('Add New :type' , ['type'=> $classwork->type ]),
            'body' => $content,
            'image' => '',
            'link' => route('classrooms.classworks.show' , [$classwork->classroom->id , $classwork->id]),
            'classwork_id' => $classwork->id,

        ];

    }

    public function toVonage(object $notifiable)
    {

        return (new VonageMessage)
        ->content(__('Anew classwork created !'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
        //    default method using with database and broadcast(structure)
        ];
    }
}