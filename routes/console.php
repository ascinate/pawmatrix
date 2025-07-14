<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Scheduling\Schedule;
use App\Mail\AppointmentReminder;
use App\Models\Appointment;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('reminders:send-vet', function () {
    $appointments = Appointment::with(['vet', 'pet', 'client'])
        ->whereBetween('appointment_datetime', [now(), now()->addDay()])
        ->get();

    foreach ($appointments as $appointment) {
        // Send to Vet
        if ($appointment->vet && $appointment->vet->email) {
            Mail::to($appointment->vet->email)->send(
                new AppointmentReminder($appointment, $appointment->vet->name, 'Vet Appointment Reminder')
            );
        }

        // Send to Client
        if ($appointment->client && $appointment->client->email) {
            Mail::to($appointment->client->email)->send(
                new AppointmentReminder($appointment, $appointment->client->name, 'Pet Appointment Reminder')
            );
        }
    }
})->describe('Send vet and client appointment reminders.');

// ✅ Schedule the command daily at 8:00 AM
app(Schedule::class)->command('reminders:send-vet')->dailyAt('08:00');
