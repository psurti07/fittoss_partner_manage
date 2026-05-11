<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;

trait HandlesImageUpload
{
    protected function uploadImage($file, string $folder): string
    {
        $destinationPath = public_path("assets/uploads/{$folder}");

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $fileName = uniqid() . "_" . $folder . "_" . time() . '.' . $file->getClientOriginalExtension();

        $file->move($destinationPath, $fileName);

        return $fileName;
    }

    protected function deleteImage(?string $fileName, string $folder): void
    {
        if (!$fileName) return;

        $path = public_path("assets/uploads/{$folder}/{$fileName}");

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
