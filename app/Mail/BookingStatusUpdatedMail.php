<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingStatusUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Booking $booking;
    public string $oldStatus;

    public function __construct(Booking $booking, string $oldStatus)
    {
        $this->booking = $booking;
        $this->oldStatus = $oldStatus;
    }

    public function build()
    {
        return $this
            ->subject('Your booking status was updated')
            ->view('emails.booking_status_updated');
    }
}
