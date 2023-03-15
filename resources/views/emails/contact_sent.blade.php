{{ __('Thank you for your inquiry') }}

- {{ __('Your Name') }}: {!! $contact->name !!}
- {{ __('Email Address') }}: {!! $contact->email !!}
- {{ __('Message') }}
{!! $contact->message !!}

───────────────────────────
{{ config('app.name') }}
{{ config('app.url') }}
