Hi {{ $instructor->user->name }},

Your instructor account has been approved by the administrator{{ $approvedByName ? ' (' . $approvedByName . ')' : '' }}.

You can now log in to your instructor dashboard: {{ route('login.form', ['redirect' => route('dashboard')]) }}

Next steps:
- Update your profile and add courses, skills, and certifications.
- Visit your dashboard at: {{ route('dashboard') }}

If you have any questions, reply to this message or contact support.

Thanks,
Kidicode Team
