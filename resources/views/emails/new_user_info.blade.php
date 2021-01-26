@component('mail::message')
# {{ $introMessage }}

Here is your login information
@component('mail::table')
| Key           | Values         |
| ------------- |:-------------:|
| 휴대폰번호(ID) | {{ $user->USER_ID }}  |
| 비밀번호       | {{ $password }}  |
@endcomponent

@component('mail::button', ['url' => $url])
Change Password
@endcomponent

감사합니다.<br>
{{ config('app.name') }}
@endcomponent
