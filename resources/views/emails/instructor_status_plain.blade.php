Hi {{ $instructor->user->name }},

@if($status === 'disabled')
Your instructor account has been disabled by the administrator{{ $adminName ? ' (' . $adminName . ')' : '' }}.

If you believe this is a mistake, reply to this email or contact support at {{ env('MAIL_FROM_ADDRESS') }}.
@else
Your instructor account has been enabled by the administrator{{ $adminName ? ' (' . $adminName . ')' : '' }}.

You can log in to your instructor dashboard here: {{ route('login.form', ['redirect' => route('dashboard')]) }}
@endif

Thanks,
Kidicode Team
