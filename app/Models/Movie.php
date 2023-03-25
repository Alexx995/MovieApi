<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'release_date', 'poster_path'];

    public function watchlists()
    {
        return $this->belongsToMany(Watchlist::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public static function getIdByApiId($id)
    {
        $movie = static::where('api_id', $id)->firstOrFail();

        return $movie->id;
    }




}
