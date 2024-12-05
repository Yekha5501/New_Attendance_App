<?php
namespace App\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistered extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $plainPassword;

    public function __construct($user, $plainPassword)
    {
        $this->user = $user;
        $this->plainPassword = $plainPassword;
    }

    public function build()
    {
        return $this->subject('Welcome to the Worship Attendance Tracking System')
            ->view('emails.user_registered')
            ->with([
                'user' => $this->user,
                'password' => $this->plainPassword,
            ]);
    }
}
// php artisan make:mail UserRegistered