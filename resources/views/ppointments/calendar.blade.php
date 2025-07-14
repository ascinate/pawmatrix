@extends('layouts.app')

@section('content')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    #calendar {
        max-width: 1100px;
        margin: 0 auto;
    }
    
    .fc-event {
        cursor: pointer;
    }
    
    .fc-event-scheduled {
        background-color: #2196F3;
        border-color: #2196F3;
    }
    
    .fc-event-completed {
        background-color: #4CAF50;
        border-color: #4CAF50;
    }
    
    .fc-event-cancelled {
        background-color: #F44336;
        border-color: #F44336;
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Appointments Calendar</h1>
        <a href="{{ route('appointments.index') }}" class="btn btn-primary">
            <i class="fas fa-list me-2"></i>List View
        </a>
    </div>
    <div id="calendar"></div>
</div>

<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: [
                @foreach($appointments as $appointment)
                {
                    id: '{{ $appointment->id }}',
                    title: '{{ $appointment->pet->name }} ({{ $appointment->client->name }})',
                    start: '{{ $appointment->appointment_datetime->format('Y-m-d\TH:i:s') }}',
                    end: '{{ $appointment->appointment_datetime->addMinutes($appointment->duration_minutes)->format('Y-m-d\TH:i:s') }}',
                    className: 'fc-event-{{ $appointment->status }}',
                    extendedProps: {
                        client: '{{ $appointment->client->name }}',
                        pet: '{{ $appointment->pet->name }}',
                        clinic: '{{ $appointment->clinic->name }}',
                        status: '{{ $appointment->status }}',
                        notes: '{{ $appointment->notes }}'
                    }
                },
                @endforeach
            ],
            eventClick: function(info) {
                // You can customize what happens when an event is clicked
                alert('Appointment Details:\n\n' +
                      'Client: ' + info.event.extendedProps.client + '\n' +
                      'Pet: ' + info.event.extendedProps.pet + '\n' +
                      'Clinic: ' + info.event.extendedProps.clinic + '\n' +
                      'Status: ' + info.event.extendedProps.status.charAt(0).toUpperCase() + 
                      info.event.extendedProps.status.slice(1) + '\n' +
                      'Notes: ' + (info.event.extendedProps.notes || 'N/A'));
            }
        });
        calendar.render();
    });
</script>
@endsection