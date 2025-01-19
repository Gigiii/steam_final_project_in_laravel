<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Library extends Model
{
    /** @use HasFactory<\Database\Factories\LibraryFactory> */
    use HasFactory;

    protected $table = 'libraries';

    protected $fillable = ['user_id', 'game_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

}
