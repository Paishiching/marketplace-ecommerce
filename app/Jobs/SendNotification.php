<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Notifications\Notification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    /**
     * @param  mixed  $notifiable  Any model using the Notifiable trait
     */
    public function __construct(
        protected mixed $notifiable,
        protected Notification $notification
    ) {
    }

    public function handle(): void
    {
        $this->notifiable->notify($this->notification);
    }
}
