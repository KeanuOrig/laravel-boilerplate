<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use \Illuminate\Http\UploadedFile;
use \Illuminate\Http\File;

trait FileUpload
{   
    /**
     * Handle file upload and returns the file path
     * 
     * @return bool|string The path to the file on success, or false on failure.
     */
    public function uploadFile(UploadedFile | File $file, string $directory, string | null $disk = 'public'): bool | string
    {
        $storage = Storage::disk($disk);

        $filename = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();

        return $storage->putFileAs("/{$directory}", new File($file), $filename);
    }

    /**
     * Delete a file from storage.
     */
    public function deleteFile(string $filePath, string|null $disk = 'public') : bool
    {
        return Storage::disk($disk)->exists($filePath) 
            ? Storage::disk($disk)->delete($filePath) 
            : false;
    }
}
