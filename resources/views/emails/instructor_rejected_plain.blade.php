Hi {{ $instructor->user->name }},

We’re sorry to let you know that your instructor request was not approved by the administrator{{ $adminName ? ' (' . $adminName . ')' : '' }}.

@if(!empty($reason))
Reason: {{ $reason }}
@endif

If you have questions or need help, reply to this message or contact support at {{ env('MAIL_FROM_ADDRESS') }}.

Thanks,
Kidicode Team
