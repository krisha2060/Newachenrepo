<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingConfirmedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;  

    public function __construct($order)
    {
        $this->order = $order;  
    }

    public function build()
    {
        return $this->subject('Your Booking is Confirmed!')
                    ->view('mail.booking.confirm')
                    ->with([
                        'order' => $this->order  
                    ]);
    }
}