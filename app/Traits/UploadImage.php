<?php

namespace App\Traits;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait UploadImage
{
    public function uploadImage(FormRequest $request, string $path, ?int $width = null, ?int $height = null): string
    {
        $file = $request->file('image');
        $name = $file->hashName();

        $manager = new ImageManager(new Driver);

        $image = $manager->read($file)->scale($width);

        $encodedImage = $image->toWebp();

        Storage::put('images/'.$path.'/'.$name, $encodedImage);

        return $name;
    }
}
