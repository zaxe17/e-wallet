@component('mail::message')
# Hello {{ $mailData['name'] }}!

Welcome to BanKO! Your account has been successfully created.

Here are your login credentials:

- **Username:** {{ $mailData['username'] }}
- **Password:** {{ $mailData['password'] }}

@component('mail::button', ['url' => url('/login')])
Login Now
@endcomponent

If you did not create this account, please contact our support team immediately.

Thanks,<br>
BanKO
@endcomponent
