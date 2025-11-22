<?php

namespace App\Interfaces\Admins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

interface FileRepositoryInterface
{
    public function download_file(string $file, string $dir): StreamedResponse;

    public function insert_files(FormRequest $request, string $table_name, string $column_name, int $column_value): array;

    public function upload_file(FormRequest $request): array;

    public function destroy_file(Request $request, string $tableName): void;
}
