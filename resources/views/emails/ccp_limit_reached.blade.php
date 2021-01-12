@component('mail::message')
# CCP Limit reached

Device: {{ $ccpLimit->DEVICE_ID }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent