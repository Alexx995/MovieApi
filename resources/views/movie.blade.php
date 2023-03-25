<!DOCTYPE html>
<html>
<head>
    <title>Movie Search</title>
</head>
<body>

@include('header')

<a href="{{ route('get.list') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> My watch list</a>
<form action="{{ route('movie.search') }}" method="GET">
    <label for="movie">Enter a movie name:</label>
    <input type="text" id="movie" name="movie">
    <button type="submit">Search</button>
</form>
@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if(isset($movies))
    @foreach($movies['results'] as $movie)
        @if(isset($movie['backdrop_path']))
            <h1>{{ $movie['original_title'] }}</h1>
            <img src="https://image.tmdb.org/t/p/w300{{ $movie['backdrop_path'] }}" alt="{{ $movie['title'] }} poster">
            <p>{{ $movie['overview'] }}</p>
            <p>{{ $movie['popularity'] }}</p>

            <a href="{{ route('movies.show', $movie['id']) }}" class="btn btn-primary">View Details</a>

            <form method="POST" action="{{ route('watchlist.store') }}">
                @csrf
                <input type="hidden" name="movie_id" value="{{ $movie['id'] }}">
                <button type="submit">Add to Watchlist</button>
            </form>

        @endif
    @endforeach

@endif
</body>
</html>
