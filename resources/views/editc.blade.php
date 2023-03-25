@include('header')
<a href="{{ route('movie.search') }}" class="btn btn-warning"><i class="fa fa-angle-left"></i> Filmovizija</a>

<form action="{{ route('comments.update', $comment->id) }}" method="post">
    @csrf
    @method('PUT')
    <textarea name="comment" rows="5" cols="50">{{ $comment->comment }}</textarea>
    <input type="submit" value="Update comment">
</form>
