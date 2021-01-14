@component('mail::message')
# Temperature alert
{{ now()->parse($ccpEscData->SRT_DTM)->format('Y-m-d H:i:s') }}

## Device: {{ $ccpEscData->DEVICE_ID }}
## Temperature: {{ $ccpEscData->ESC_DATA }}

{{-- @component('mail::button', ['url' => ''])
Button Text
@endcomponent --}}

{{-- Thanks,<br> --}}
{{ config('app.name') }}
@endcomponent
