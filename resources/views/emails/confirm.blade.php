
@component('mail::message')
Helo {{ $user->name }}
You change email . Please verify your new  email using this link:


@component('mail::button', ['url' =>route('verify',$user->verification_token)])
Verify email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent