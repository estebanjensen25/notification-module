<?php

namespace Modules\Notification\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Modules\Notification\Channels\WhatsappChannel;
use Modules\Notification\Channels\CustomDbChannel;

class NotificationAlliotec extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
    public function via($notifiable)
    {
        switch($this->data['channels'])
        {
            case [1,2,3]:
                return [WhatsappChannel::class, 'mail', CustomDbChannel::class];
            break;
            case [1,2]:
                return [WhatsappChannel::class, 'mail'];
            break;
            case [1,3]:
                return [WhatsappChannel::class, CustomDbChannel::class];
            break;
            case [2,3]:
                return ['mail', CustomDbChannel::class];
            break;
            case [1]:
                return [WhatsappChannel::class];
            break;
            case [2]:
                return ['mail'];
            break;
            case [3]:
                return [CustomDbChannel::class];
            break;
        }
        
    }

    public function toMail($notifiable)
    {
        /*return (new MailMessage)
                    ->line($this->data['title'])
                    ->action('Notification Action', $this->data['url'])
                    ->line($this->data['body']);*/
        return (new MailMessage)
            ->line('Text Title')
            ->action('Notification Action', 'URL')
            ->line('Text Body');
    }
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Text Title',
            'body'  => 'Text Body',
            'url'  => 'URL',
            'transmitter_user_id' => $this->data['transmitter_user_id'],
            'transmitter_establishment_id' => $this->data['transmitter_establishment_id']
        ];
    }

    public function toWhatsapp($notifiable)
    {
        return [
            'title' => $this->data['title'],
            'body'  => $this->data['body'],
            'url'  => $this->data['url']
        ];       
    }
}
