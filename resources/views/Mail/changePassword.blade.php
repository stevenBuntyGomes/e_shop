@component('mail::message')
# Change Password Confirmation -> {{ $user_name_for_mail }}


@component('mail::panel')
Your password has been changed!
@endcomponent

@component('mail::table')
| Laravel       | Table         | Example  |
| ------------- |:-------------:| --------:|
| Col 2 is      | Centered      | $10      |
| Col 3 is      | Right-Aligned | $20      |
@endcomponent

@component('mail::button', ['url' => 'shohan'])
Go to site
@endcomponent

Thanks,<br>
{{ config('app.name') }}
<br>
<br>

@component('mail::panel')
Visit this link to Go back -> <a href="{{ url('/profile/edit') }}">Go back to site</a>
@endcomponent

@endcomponent
