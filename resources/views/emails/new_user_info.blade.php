@component('mail::message')
# {{ $introMessage }}

Here is your information
@component('mail::table')
| Key           | Values         |
| ------------- |:-------------:|
| 휴대폰번호(ID) | {{ $user->USER_ID }}  |
| 이름          | {{ $user->USER_NM }}  |
| 비밀번호       | {{ $user->USER_PW }}  |
| 이메일         | {{ $user->EMAIL }}    |
| 메뉴접근권한   | {{ implode(',', $roles->pluck('COMM2_NM')->toArray()) }}    |
| 담당업무       | {{ implode(',', $approvals->pluck('COMM2_NM')->toArray()) }}    |
| 사용여부       | {{ $user->USER_STS_YN }}    |
@endcomponent

@component('mail::button', ['url' => $url])
Change Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
