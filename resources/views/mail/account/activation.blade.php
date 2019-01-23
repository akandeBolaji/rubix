@component('mail::message')
Welcome to Rubix

Thank you for registering an account with us.

@component('mail::button', ['url' => $url, 'color' =>'blue'])
We would love you to click on the button below to verify your account and start communicating
Verify Account
@endcomponent

@component('mail::panel')
If you're having trouble clicking the "Verify Account" button directly, copy and paste the URL below into your web browser.
@endcomponent

@component('mail::panel')
{{ $url }}
@endcomponent


Regards,<br>
{{ config('app.name') }}
@endcomponent
