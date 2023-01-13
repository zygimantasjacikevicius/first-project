<x-mail::message>
    # Introduction

    Your password reset token is: {{ $token }}

    <x-mail::button :url="''">
        Button Text
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
