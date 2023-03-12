{{ __('Thank you for your inquiry') }}

- {{ __('Name') }}: {!! $contact->name !!}
- {{ __('Email') }}: {!! $contact->email !!}
- {{ __('Message') }}
{!! $contact->message !!}

───────────────────────────
{{ config('app.name') }}
{{ config('app.url') }}
