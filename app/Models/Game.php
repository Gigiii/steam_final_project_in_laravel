<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /** @use HasFactory<\Database\Factories\GameFactory> */
    use HasFactory;

    protected $fillable = [
        'franchise_id',
        'title',
        'price',
        'sale_price',
        'short_description',
        'description',
        'release_date',
        'age_rating',
    ];

    protected $casts = [
        'release_date' => 'date',
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function genres()
    {
        return $this->morphToMany(Genre::class, 'genreable');
    }

    public function reviews()
    {
        return  $this->hasMany(Review::class);
    }

    public function libraries()
    {
        return $this->hasMany(Library::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function franchise()
    {
        return $this->belongsTo(Franchise::class);
    }

    public function developer()
    {
        return $this->hasOneThrough(Developer::class, Franchise::class);
    }

}
