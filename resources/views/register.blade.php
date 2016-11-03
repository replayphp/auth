@extends("replay-auth::layout")

@section("content")
    <form role="form" method="POST" action="{{ route("replay.auth.register") }}">
        {{ csrf_field() }}

        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old("name") }}" autofocus>
            @if ($errors->has("name"))
                {{ $errors->first("name") }}
            @endif
        </div>

        <div>
            <label for="email">E-Mail Address</label>
            <input id="email" type="email" name="email" value="{{ old("email") }}">
            @if ($errors->has("email"))
                {{ $errors->first("email") }}
            @endif
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password">
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
            <button type="submit">Register</button>
        </div>
    </form>
@endsection
