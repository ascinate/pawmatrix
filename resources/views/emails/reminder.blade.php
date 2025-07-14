<x-mail::message>
@component('mail::message')
# {{ $subjectLine }}

Dear {{ $name }},

This is a reminder for your upcoming appointment:

- **Pet**: {{ $appointment->pet->name }}
- **Date**: {{ $appointment->appointment_datetime->format('l, F j, Y') }}
- **Time**: {{ $appointment->appointment_datetime->format('h:i A') }}
- **Type**: {{ $appointment->service_type }}

Please arrive 10 minutes early.

Thanks,  
{{ config('app.name') }}
@endcomponent

</x-mail::message>
