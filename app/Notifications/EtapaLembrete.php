<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EtapaLembrete extends Notification {

    use Queueable;

    private $etapa;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($etapa) {

        return $this->etapa = $etapa;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) {

        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {

        return (new MailMessage)
                    ->line('Nova etapa criada')
                    ->action('View nova etapa', route('etapa.email', [$this->etapa]))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {

        return [
            'etapa' => $this->etapa->id
        ];
    }
}
