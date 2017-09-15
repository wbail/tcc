<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class EtapaLembrete extends Notification {

    use Queueable;

    private $etapaano;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($etapaano) {

        return $this->etapaano = $etapaano;
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
                    ->subject('Nova etapa do TCC')
                    ->greeting('Olá,')
                    ->line('Uma nova etapa foi adicionada ao TCC')
                    ->action('Visualizar etapa', route('etapaano', [$this->etapaano]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable) {

        return [
            'etapa' => $this->etapaano->id
        ];
    }
}
