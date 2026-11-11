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
        $logoRel  = ! empty($site->logo_dark) || ! empty($site->logo)
            ? ltrim($site->logo ?: $site->logo_dark, '/')
            : null;

        // Embed na kore public URL : tahole Gmail e attachment chip ashbe na
        $logoUrl = $logoRel
            ? rtrim(config('app.url'), '/') . '/storage/' . $logoRel
            : null;

        $subject = $this->code . ' is your ' . $siteName . ' verification code';

        return (new MailMessage)
            ->subject($subject)
            ->view('emails.otp', [
                'subject'  => $subject,
                'code'     => $this->code,
                'minutes'  => $this->minutes,
                'siteName' => $siteName,
                'logoUrl'  => $logoUrl,
            ]);
    }
}