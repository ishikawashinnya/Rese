<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationReminder extends Mailable
{
    use Queueable, SerializesModels;

    protected $reservation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $reservationId = $this->reservation->id;

        $url = route('reservation.check', ['id' => $reservationId]);

        $qrCode = QrCode::format('png')->size(200)->generate($url);
        $base64 = base64_encode($qrCode);
        $qrCodeImage = 'data:image/png;base64,' . $base64;

        return $this->subject('予約リマインダー')
                    ->view('emails.reminder')
                    ->with([
                        'reservation' => $this->reservation,
                        'qrCode' => $qrCodeImage
                    ]);
    }
}
