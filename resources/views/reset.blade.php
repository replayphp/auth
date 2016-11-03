@extends("replay-auth::layout")

@section("content")
    <form role="form" method="POST" action="{{ route("replay.auth.reset") }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email">E-Mail Address</label>
            <input id="email" type="email" name="email" value="{{ old("email", $email) }}">
            @if ($errors->has("email"))
                {{ $errors->first("email") }}
            @endif
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" autofocus>
            @if ($errors->has("password"))
                {{ $errors->first("password") }}
            @endif
        </div>

        <div>
            <label for="password-confirm">Confirm Password</label>
            <input id="password-confirm" type="password" name="password_confirmation">
            @if ($errors->has("password_confirmation"))
                {{ $errors->first("password_confirmation") }}
            @endif
        </div>

        <div>
            <button type="submit">Reset Password</button>
        </div>
    </form>
@endsection
