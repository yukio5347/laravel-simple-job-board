{{ __('Received a new inquiry') }}

- {{ __('Name') }}: {!! $contact->name !!}
- {{ __('Email Address') }}: {!! $contact->email !!}
- IP Address: {!! $contact->ip_address !!}
- User Agent: {!! $contact->user_agent !!}
- {{ __('Message') }}
{!! $contact->message !!}

───────────────────────────
{{ config('app.name') }}
{{ config('app.url') }}
