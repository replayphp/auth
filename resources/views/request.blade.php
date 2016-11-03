@extends("replay-auth::layout")

@section("content")
    <form role="form" method="POST" action="{{ route("replay.auth.request") }}">
        {{ csrf_field() }}

        <div>
            <label for="email">E-Mail Address</label>
            <input id="email" type="email" name="email" value="{{ old("email") }}" autofocus>
            @if ($errors->has("email"))
                {{ $errors->first("email") }}
            @endif
        </div>

        <div>
            <button type="submit">Send Password Reset Link</button>
        </div>
    </form>
@endsection
