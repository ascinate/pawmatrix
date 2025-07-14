<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Appointment;

class AppointmentReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $name;
    public $subjectLine;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment, $name, $subjectLine)
    {
        $this->appointment = $appointment;
        $this->name = $name;
        $this->subjectLine = $subjectLine;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->subjectLine)
                    ->markdown('emails.reminder')
                    ->with([
                        'appointment' => $this->appointment,
                        'name' => $this->name,
                        'subjectLine' => $this->subjectLine,
                    ]);
    }
}
