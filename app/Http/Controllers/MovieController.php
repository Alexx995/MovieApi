<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class MovieController extends Controller
{
    public function index(Request $request)
    {
        $client = new Client();
        $url = 'https://api.themoviedb.org/3/search/movie?api_key=8efdea82bca20668e72d56828e367937&language=en-US&query=' . urlencode($request->input('movie')) . '&page=1&include_adult=false';

        $response = $client->request('GET', $url);
        $movies = json_decode($response->getBody(), true);

        return view('movie', compact('movies'));
    }

}
