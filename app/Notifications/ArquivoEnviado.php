<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ArquivoEnviado extends Notification
{
    use Queueable;

    private $arquivo;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($arquivo)
    {
        $this->arquivo = $arquivo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Olá,')
                    ->subject('Novo arquivo enviado ao TCC')
                    ->salutation(' ')
                    ->action('Visualizar Arquivo', route('etapaano', [$this->arquivo]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'arquivo' => $this->arquivo->id
        ];
    }
}
