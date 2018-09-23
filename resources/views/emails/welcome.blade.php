
@component('mail::message')
Helo {{ $user->name }}
Thank you for creating account. Please verify you email using this link:


@component('mail::button', ['url' =>route('verify',$user->verification_token)])
Verify email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent