<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;

class QuickEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $user;

    private $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, Request $request)
    {
        $this->user = $user;
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from = $this->request->get('from');
        $name = $this->user->name;
        $subject = $this->request->get('subject');

        return $this->view('emails.quick')
            ->from($this->request->get('email'), $name)
            ->replyTo($from, $name)
            ->subject($subject)
            ->with([
                'user' => $this->user,
                'msg' => $this->request->get('message')
            ]);
    }
}
