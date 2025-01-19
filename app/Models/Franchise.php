<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Franchise extends Model
{
    /** @use HasFactory<\Database\Factories\FranchiseFactory> */
    use HasFactory;

    protected $fillable = ['title', 'description'];

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function genres()
    {
        return $this->morphToMany(Genre::class, 'genreable');
    }

}
