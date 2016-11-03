@if (auth("replay")->guest())
    <div>
        <a href="{{ route("replay.auth.showLoginForm") }}">Login</a>
        <a href="{{ route("replay.auth.showRegisterForm") }}">Register</a>
    </div>
@else
    <div>
        Logged in as: {{ auth("replay")->user()->name }}
        <form action="{{ route("replay.auth.logout") }}" method="POST">
            {{ csrf_field() }}
            <input type="submit" value="Logout">
        </form>
    </div>
@endif

@yield("content")
