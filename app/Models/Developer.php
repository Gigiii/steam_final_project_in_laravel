<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    /** @use HasFactory<\Database\Factories\DeveloperFactory> */
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function franchises() {
        return $this->hasMany(Franchise::class);
    }

    public function games() {
        return $this->hasManyThrough(Game::class, Franchise::class);
    }
}
