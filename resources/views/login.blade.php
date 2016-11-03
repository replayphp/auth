@extends("replay-auth::layout")

@section("content")
    <form role="form" method="POST" action="{{ route("replay.auth.login") }}">
        {{ csrf_field() }}

        <div>
            <label for="email">E-Mail Address</label>
            <input id="email" type="email" name="email" value="{{ old("email") }}" autofocus>
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
            <label><input type="checkbox" name="remember"> Remember Me</label>
        </div>

        <div>
            <button type="submit">Login</button>
            <a href="{{ route("replay.auth.showRequestForm") }}">Forgot Your Password?</a>
        </div>
    </form>
@endsection
