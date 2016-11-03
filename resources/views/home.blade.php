@extends("replay-auth::layout")

@section("content")
    @if (auth("replay")->guest())
        You are not logged in.
    @else
        You are logged in.
    @endif
@endsection
