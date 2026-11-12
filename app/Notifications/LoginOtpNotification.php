<?php

namespace App\Notifications;

use App\Models\WebsiteSetting;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LoginOtpNotification extends Notification
{
    public function __construct(public string $code, public int $minutes = 5)
    {
    }

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        $site = null;

        try {
            $site = WebsiteSetting::current();
        } catch (\Throwable $e) {
            // ignore
        }

        $siteName = $site->site_name ?? config('app.name');
        // Keep the one-time code out of the subject so it is not exposed in
        // lock-screen previews and so the subject stays clearly transactional.
        $subject = 'Your ' . $siteName . ' verification code';

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.otp', [
                'subject'  => $subject,
                'code'     => $this->code,
                'minutes'  => $this->minutes,
                'siteName' => $siteName,
            ])
            ->text('emails.otp-text', [
                'code'     => $this->code,
                'minutes'  => $this->minutes,
                'siteName' => $siteName,
            ]);
    }
}
