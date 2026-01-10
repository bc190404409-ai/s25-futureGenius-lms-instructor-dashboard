<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Instructor Approved</title>
    <style>
        .btn { 
            display:inline-block; 
            background:#2563eb; 
            color:#fff; 
            padding:10px 16px; 
            border-radius:6px; 
            text-decoration:none; 
        }
        .container { 
            font-family: Arial, Helvetica, sans-serif; 
            color:#111827; 
        }
        .footer { 
            color:#6b7280; 
            font-size:13px; 
            margin-top:20px; 
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Congratulations!</h1>
        <p>Hi {{ $instructor->user->name ?? 'Instructor' }},</p>

        <p>
            Your instructor account has been approved by the administrator
            {{ $approvedByName ? ' (' . e($approvedByName) . ')' : '' }}. 
            You can now log in and access your instructor dashboard.
        </p>

        <p>
            {{-- Login button using url() helper for proper APP_URL handling --}}
            <a class="btn" href="{{ url('/login') }}">Login to Kidicode</a>
        </p>

        <h4>Next steps</h4>
        <ul>
            <li>Complete or update your profile information</li>
            <li>Add skills, certifications, and a course (if applicable)</li>
            <li>Review your dashboard for student messages and enrollments</li>
        </ul>

        <p class="footer">
            If you didn’t expect this email or need help, reply to this message or contact 
            <a href="mailto:{{ env('MAIL_FROM_ADDRESS', 'support@example.com') }}">support</a>.
        </p>

        <p class="footer">
            Thanks,<br>Kidicode Team
        </p>
    </div>
</body>
</html>
