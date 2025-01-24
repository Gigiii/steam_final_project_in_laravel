<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'balance' => $this->balance,
            'role' => $this->role->title ?? null,
            'library' => $this->library, 
            'wishlist' => $this->wishlist,
            'orders' => $this->orders,
            'reviews' => $this->reviews,
            'image' => $this->image ? $this->image->url : null,
            'developer' => $this->when($this->isDeveloper(), function () {
                return [
                    'id' => $this->developer->id,
                    'name' => $this->developer->name,
                ];
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
