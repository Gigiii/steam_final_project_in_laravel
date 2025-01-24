<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WeeklyFranchiseNotification extends Notification
{
    use Queueable;

    private $franchise;

    /**
     * Create a new notification instance.
     */
    public function __construct($franchise)
    {
        $this->franchise = $franchise;
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
        ->subject('Weekly Franchise!')
        ->greeting("Hello {$notifiable->username},")
        ->line('Here is the franchise that we think deserves a spotlight:')
        ->line("**{$this->franchise->title}**");

        foreach ($this->franchise->games as $game) {
            if ($game->sale_price !== null && $game->sale_price > 0) {
                $mailMessage->line("- **{$game->title}**: Original Price $ {$game->price}, Sale Price $ {$game->sale_price}");
            }else{
                $mailMessage->line("- **{$game->title}**: Price $ {$game->price}");
            }
        }

        $mailMessage->line("Please give a round of applause to the developer {$this->franchise->developer->name}!");

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
