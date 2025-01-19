<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /** @use HasFactory<\Database\Factories\GenreFactory> */
    use HasFactory;

    protected $fillable = ['title'];

    public function games()
    {
        return $this->morphedByMany(Game::class, 'genreable');
    }

    public function franchises()
    {
        return $this->morphedByMany(Franchise::class, 'genreable');
    }
}
