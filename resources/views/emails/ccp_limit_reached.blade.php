@component('mail::message')
# 한계이탈 경고
{{ now()->parse($ccpEscData->SRT_DTM)->format('Y-m-d H:i:s') }}

## 한계이탈장비: {{ $ccpEscData->device ? $ccpEscData->device->COMM2_NM : $ccpEscData->DEVICE_ID }}
## 온도: {{ $ccpEscData->ESC_DATA }}

{{-- 점검바랍니다!,<br> --}}
{{ config('app.name') }}
@endcomponent
