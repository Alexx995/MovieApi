@include('header')



<a href="{{ route('movie.search') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Filmovizija</a>

@if(isset($movies))
    <h1>{{ $movies->title }}</h1>
    <img src="https://image.tmdb.org/t/p/w300{{ $movies->poster_path }}">
    <p>{{ $movies->release_date }}</p>
@endif


<form action="{{route('comments.store', $movies->id)}}" method="post">
    @csrf
    <input type="hidden" name="movie_id" value="{{ $movies->id }}">
    <textarea name="comment" rows="5" cols="50" placeholder="Write comment" > </textarea>
    <input type="submit" value="Add comment">
</form>

@if($comments)
    <h2>Comments:</h2>

        @foreach($comments as $comment)

                {{ $comment->comment }}

                <div style="font-size: 0.8em; color: grey;">
                    Posted by {{ $comment->user->name }} on {{ $comment->created_at->format('M d, Y h:i A') }}
                </div>
                @if ($comment->user->id == Auth::user()->id)
                    <a href="{{ route('comments.edit', $comment->id)}}">
                        @csrf
                        <button type="button" class="btn btn-warning">Edit</button>
                    </a>
                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="Delete">
                    </form>
                @endif
                    <hr>

        @endforeach

@else
    <p>No comments yet.</p>
@endif





