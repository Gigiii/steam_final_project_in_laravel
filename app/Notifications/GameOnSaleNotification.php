<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GameOnSaleNotification extends Notification
{
    use Queueable;

    private $games;

    /**
     * Create a new notification instance.
     */
    public function __construct($games)
    {
        $this->games = $games;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
        ->subject('Games on Your Wishlist Are On Sale!')
        ->greeting("Hello {$notifiable->username},")
        ->line('Here are the games from your wishlist that are currently on sale:');

        foreach ($this->games as $game) {
            $mailMessage->line("- **{$game->title}**: Original Price $ {$game->price}, Sale Price $ {$game->sale_price}");
        }

        $mailMessage->action('View Your Wishlist', url('/wishlist'))
                    ->line('Hurry! Some sales may end soon!');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
