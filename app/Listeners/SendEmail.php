<?php

namespace App\Listeners;

use App\Events\UserHasContacted;
use App\Mail\SendEmailUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param UserHasContacted $event
     * @return void
     */
    public function handle(UserHasContacted $event)
    {
        $data = $event->data;
        Mail::to($data->email)->send(new SendEmailUser($data));
    }
}
