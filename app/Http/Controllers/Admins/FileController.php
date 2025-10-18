<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\DropzoneRequest;
use App\Interfaces\Admins\FileRepositoryInterface;
use App\Traits\CanAccessAdminPanel;
use Illuminate\Http\{JsonResponse, Request};
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    use CanAccessAdminPanel;

    public function __construct(private FileRepositoryInterface $fileRepository)
    {
        $this->canAccessAdminPanel();
    }

    // MARK: upload
    public function upload(DropzoneRequest $request): JsonResponse
    {
        $file = $this->fileRepository->upload_file($request);

        return response()->json(['path' => $file['path'], 'originalName' => $file['originalName'], 'message' => 'you uploaded image successfully']);
    }

    // MARK: download
    public function download(string $file, string $type, string $dir): StreamedResponse
    {
        return $this->fileRepository->download_file($file, $type, $dir);
    }

    // MARK: destroy
    public function destroy(Request $request, string $tableName): JsonResponse
    {
        $this->fileRepository->destroy_file($request, $tableName);

        return response()->json(['message' => 'you deleted image successfully']);
    }
}
