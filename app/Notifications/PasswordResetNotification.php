<?php

namespace App\Notifications;

use App\Aimentia\EmailBuilder;
use App\Mail\Builder;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * The callback that should be used to create the reset password URL.
     *
     * @var \Closure|null
     */
    public static $createUrlCallback;

    /**
     * Create a notification instance.
     *
     * @param  string  $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        //The user is not logged in when resetting password, but we want to send the e-mail in his chosen language
        //\App::setLocale($notifiable->locale->code);
        return (new Builder())
            ->subject(__('Password reset'))
            //->brand('img/aimentia_flower_outline.png')
            ->title(__('Password reset'))
            ->paragraph(__("You are receiving this email because we received a password reset request for your account."))
            ->button($this->resetUrl($notifiable), __('Reset password'))
            ->paragraph(
                __('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')])
                . " " .
                __('If you did not request a password reset, no further action is required.')
            )
            ->row(__('Sincerely,'))
            ->cursive('The Aimentia Team')
            ->separator()
            ->small(__('If the button is not working, copy and paste the following link into your browser') . ':')
            ->url($this->resetUrl($notifiable))
            ->params(['footer' => '© ' . date('Y') . ' Aimentia. All rights reserved.']);


    }

    /**
     * Get the reset URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function resetUrl($notifiable)
    {
        if (static::$createUrlCallback) {
            return call_user_func(static::$createUrlCallback, $notifiable, $this->token);
        }

        return url(route('forgotten-password.edit', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
            //'locale' => $notifiable->locale->code,
        ], false));
    }
}
