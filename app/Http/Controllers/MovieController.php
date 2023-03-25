<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Review;
use App\Models\User;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $client = new Client();
        $url = 'https://api.themoviedb.org/3/search/movie?api_key=8efdea82bca20668e72d56828e367937&language=en-US&query=' . urlencode($request->input('movie')) . '&page=1&include_adult=false';

        $response = $client->request('GET', $url);
        $movies = json_decode($response->getBody(), true);


        foreach ($movies['results'] as $movieData) {

            $existingMovie = Movie::where('title', $movieData['original_title'])->first();

            if ($existingMovie) {
                continue;
            }
            try {
                $movie = new Movie();
                $movie->title = $movieData['original_title'];
                $movie->release_date = $movieData['release_date'];
                $movie->poster_path = $movieData['backdrop_path'];
                $movie->api_id = $movieData['id'];
                $movie->save();
            } catch (\Exception $e) {
                continue;
            }
        }
        return view('movie', compact('movies'));
    }




    public function store(Request $request)
    {

        $movie = Movie::where('api_id', $request->movie_id)->first();


        if (!$movie) {
            return redirect()->back()->with('error', 'Movie not found');
        }

        $user = Auth::user();
        $existingWatchlistItem = $user->watchlist()->where('movie_id', $movie->id)->first();

        if ($existingWatchlistItem) {
            return redirect()->back()->with('error', 'Movie is already in your watchlist');
        }


        $watchlistItem = new Watchlist();
        $watchlistItem->user_id = Auth::id();
        $watchlistItem->movie_id = $movie->id;
        $watchlistItem->save();

        return redirect()->back()->with('success', 'Movie added to watchlist');
    }


    public function watchlist()
    {
        /** @var User $user */
        $user = auth()->user();

        $movies = $user->watchlist->map(function ($item) {
            return $item->movie;
        });

        return view('list', compact('movies'));
    }

    public function delete(Movie $movie)
    {
        auth()->user()->watchlist()->where('movie_id', $movie->id)->delete();

        return redirect()->back()->with('success', 'Movie removed from watchlist');
    }

    public function show($id)
    {

        $movies = Movie::where('api_id', $id)->firstOrFail();
        $comments = $movies->reviews;


        return view('onemovie', compact('movies', 'comments'));
    }

    public function storeComment(Request $request, $id)
    {
        $validatedData = $request->validate([
            'comment' => 'required|max:255',
        ]);


        $comment = new Review;
        $comment->user_id = auth()->user()->id;
        $comment->movie_id = $id;
        $comment->comment = $validatedData['comment'];
        $comment->save();

        return redirect()->back();
    }

    public function edit($id)
    {
        $comment = Review::findOrFail($id);

        return view('editc', compact('comment'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'comment' => 'required|max:255',
        ]);

        $comment = Review::findOrFail($id);


        $comment->comment = $validatedData['comment'];
        $comment->save();

        $movie=$comment->movie;

       // return redirect()->route('movies.show', ['id' => $comment->movie_id])->with('success', 'Comment updated successfully!');
        return redirect()->action(
            [MovieController::class, 'show'],
            ['id' => $movie->api_id]
        )->with('success', 'Comment updated successfully!');
    }

    public function destroyComment($id)
    {
        $comment = Review::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }








}
