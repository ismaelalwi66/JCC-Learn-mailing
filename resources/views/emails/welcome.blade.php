@component('mail::message')
Hello , {{ $name }}
<p>Selamat anda telah bergabung dengan kami ,silahkan klik link di bawah</p>

<a href="{{ $url }}">{{ $url }}</a><br>
<p>atau klik button di bawah</p>
@component('mail::button', ['url' => $url])
Verify Email
@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
