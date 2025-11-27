<?php

namespace App\Traits;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

trait UploadImage
{
    public function uploadImage(FormRequest $request, string $path, ?int $width = null): string
    {
        $file = $request->file('image');
        $name = $file->hashName();

        $manager = new ImageManager(new Driver);

        $encodedImage = $manager->read($file)->scale($width)->toWebp();

        $path = 'images/'.$path.'/'.$name;

        Storage::disk('public')->put($path, $encodedImage);

        return asset('/storage/'.$path);
    }

    // MARK: dropZoneUpload
    public function dropZoneUpload(FormRequest $request, string $path): array
    {
        $path           = $this->uploadImage($request, $path, 100);
        $originalName   = $request->file('image')->getClientOriginalName();

        return ['path' => $path, 'originalName' => $originalName];
    }
}
