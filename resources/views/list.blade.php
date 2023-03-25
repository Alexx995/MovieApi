<!DOCTYPE html>
<html>
<head>
    <title>Your Watchlist</title>
</head>
<body>


@include('header')

<a href="{{ route('movie.search') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Filmovizija</a>

<h3>This is your watchlist</h3>


@if(isset($movies))
    {{--    <p>{{ $movie['overview'][0] }}</p>--}}
    @foreach($movies as $movie)
        <h1>{{ $movie['title'] }}</h1>
        <img src="https://image.tmdb.org/t/p/w300{{ $movie['poster_path'] }}">
        <p>{{ $movie['release_date'] }}</p>

        <a href="{{ route('movies.show', $movie['api_id']) }}" class="btn btn-primary">View Details</a>

        <form action="{{ route('watchlist.delete', $movie) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Remove from Watchlist</button>
        </form>


@endforeach
@endif

