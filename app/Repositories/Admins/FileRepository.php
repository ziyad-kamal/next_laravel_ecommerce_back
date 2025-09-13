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
        $image_path = $this->dropZoneUpload($request, 'images');

        return $image_path;
    }

    // MARK: destroy_image
    public function destroy_file(string $image, string $dir): void
    {
        $path = 'public/'.$dir.'/';

        $storage_image = Storage::has($path.$image);
        $image_query   = DB::table('project_images')->where('image', $image);
        $db_image      = $image_query->first();

        if (! $storage_image || ! $db_image) {
            // throw new GeneralNotFoundException('image');
        }

        Storage::delete($path.$image);

        $image_query->delete();
    }
}
