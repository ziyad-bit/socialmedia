@component('mail::message')
# Reset password

click on this button to reset password

@component('mail::button', ['url' => $url])
Reset password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent