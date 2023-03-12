<!DOCTYPE html>
<html>
<head>
    <title>Movie Search</title>
</head>
<body>
<form action="{{ route('movie.search') }}" method="GET">
    <label for="movie">Enter a movie name:</label>
    <input type="text" id="movie" name="movie">
    <button type="submit">Search</button>
</form>


@if(isset($movies))
{{--    <p>{{ $movie['overview'][0] }}</p>--}}
    @foreach($movies['results'] as $movie)
        <h1>{{ $movie['original_title'] }}</h1>
        <img src="https://image.tmdb.org/t/p/w300{{ $movie['backdrop_path'] }}" alt="{{ $movie['title'] }} poster">
        <p>{{ $movie['overview'] }}</p>
        <p>{{ $movie['popularity'] }}</p>


    @endforeach
@endif
</body>
</html>
