<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;

class SendVetNotifications extends Command
{
    protected $signature = 'reminders:send-vet';
    protected $description = 'Send vet and client appointment reminders';

    public function handle()
    {
        $upcomingAppointments = Appointment::with(['vet', 'pet', 'client'])
            ->whereBetween('appointment_datetime', [now(), now()->addDay()])
            ->get();

        foreach ($upcomingAppointments as $appointment) {
            // Send to vet
            if ($appointment->vet && $appointment->vet->email) {
                $this->sendAppointmentReminder(
                    $appointment->vet->email,
                    $appointment->vet->name,
                    $appointment,
                    'Vet Appointment Reminder'
                );
            }

            // Send to client
            if ($appointment->client && $appointment->client->email) {
                $this->sendAppointmentReminder(
                    $appointment->client->email,
                    $appointment->client->name,
                    $appointment,
                    'Pet Appointment Reminder'
                );
            }
        }

        $this->info('Reminders sent successfully!');
    }

    private function sendAppointmentReminder($to, $name, $appointment, $subject)
    {
        $messageBody = "
            <html>
            <body>
                <h2>{$subject}</h2>
                <p>Dear {$name},</p>
                <p>This is a reminder for your upcoming appointment:</p>

                <p><strong>Pet:</strong> {$appointment->pet->name}</p>
                <p><strong>Date:</strong> {$appointment->appointment_datetime->format('l, F j, Y')}</p>
                <p><strong>Time:</strong> {$appointment->appointment_datetime->format('h:i A')}</p>
                <p><strong>Type:</strong> {$appointment->service_type}</p>

                <p>Please arrive 10 minutes before your scheduled time.</p>
                <p>Thank you for choosing our veterinary services!</p>
            </body>
            </html>";

        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8\r\n";
        $headers .= "From: <no-reply@yourvetclinic.com>\r\n";

        mail($to, $subject, $messageBody, $headers);
    }
}
