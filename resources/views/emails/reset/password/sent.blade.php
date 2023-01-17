<x-mail::message>
    # Introduction

    Your password reset token is {{ $userReset->token }}

    Thanks,
    {{ config('app.name') }}
</x-mail::message>
