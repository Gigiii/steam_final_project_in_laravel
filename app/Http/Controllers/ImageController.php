<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\GetImagesRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function store(StoreImageRequest $request)
    {
        $validated = $request->validated();

    $images = [];
    $errors = [];

    foreach ($validated['images'] as $imageData) {
        $modelClass = $imageData['imageable_type'];
        $imageableId = $imageData['imageable_id'];

        $exists = $modelClass::where('id', $imageData['imageable_id'])->exists();

        if ($exists) {

            if ($modelClass === \App\Models\User::class) {
                $user = $modelClass::find($imageableId);
                if ($user->image) {
                    $errors[] = "User ID {$imageableId}-ს აქვს ფოტო.";
                    continue;
                }
            }

            $images[] = Image::create([
                'url' => $imageData['url'],
                'imageable_type' => $imageData['imageable_type'],
                'imageable_id' => $imageData['imageable_id'],
            ]);
        } else {
            $errors[] = "Imageable ID {$imageData['imageable_id']} არ არსებობს {$modelClass}-ში.";
        }
    }

    if (!empty($errors)) {
        return response()->json([
            'message' => 'ზოგი ფოტო ვერ აიტვირთა.',
            'errors' => $errors,
        ], 400);
    }

    return ImageResource::collection(collect($images));

    }

    public function getImagesByType(GetImagesRequest $request)
    {
        $validated = $request->validated();

        $images = Image::where('imageable_type', $validated['imageable_type'])
            ->where('imageable_id', $validated['imageable_id'])
            ->get();
        if ($images->isNotEmpty()){
            return ImageResource::collection($images);
        }else{
            return response()->json(['message' => 'ვერ მოიძებნა ფოტო'], 404);
        }
    }
}
