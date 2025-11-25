<?php

namespace App\Repositories\Admins;

use App\Exceptions\GeneralNotFoundException;
use App\Interfaces\Admins\FileRepositoryInterface;
use App\Traits\{ UploadImage};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Storage};
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileRepository implements FileRepositoryInterface
{
    use UploadImage;

    // MARK: download_image
    public function download_file(string $image, string $dir): StreamedResponse
    {
        $path = 'public/'.$dir.'/';

        if (! Storage::has($path.$image)) {
            // throw new GeneralNotFoundException('image');
        }

        return Storage::download($path.$image);
    }

    // MARK: insertAnyFile
    public function insert_files(Request $request, string $table_name, string $column_name, int $column_value): array
    {
        if ($request->has('images')) {
            $images  = $request->safe()->__get('images');

            $images_arr = [];
            if ($images != []) {
                foreach ($images as $image) {
                    $path = $image['path'];

                    $images_arr[] = [
                        'path'       => $path,
                        $column_name => $column_value,
                        'created_at' => now(),
                    ];
                }

                DB::table($table_name)->insert($images_arr);
            }

            return $images;
        }

        return [];
    }

    // MARK: upload_image
    public function upload_file(FormRequest $request): array
    {
        $image_path = $this->dropZoneUpload($request, 'items');

        return $image_path;
    }

    // MARK: destroy_image
    public function destroy_file(Request $request, string $tableName): void
    {
        $images  = $request->images;

        $locationArr = [];
        foreach ($images as $image) {
            $location      = str_replace(url('storage'), '', $image);
            $locationArr[] = $location;
        }

        $isFileDeleted    = Storage::disk('public')->delete($locationArr);
        $isDbImageDeleted = DB::table($tableName)->whereIn('path', $images)->delete();

        if (! $isFileDeleted || ! $isDbImageDeleted) {
            // throw new GeneralNotFoundException('image');
        }
    }
}
