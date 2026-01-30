<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class FileHelper
{
    /**
     * Upload a file to the specified disk & folder
     *
     * @param UploadedFile $file
     * @param string $folder
     * @param string|null $filename
     * @param string $disk
     * @return string|false   (path or false if failed)
     */
    public static function upload(UploadedFile $file, string $folder, string $filename = null, string $disk = 'public')
    {
        $name = $filename ?: time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        try {
            $path = $file->storeAs($folder, $name, $disk);
            return $path; // e.g., 'photos/abc.jpg'
        } catch (\Exception $e) {
            Log::error('File upload failed: '.$e->getMessage());
            return false;
        }
    }

    /**
     * Delete a file from the disk
     */
    public static function delete(string $path, string $disk = 'public')
    {
        try {
            if (Storage::disk($disk)->exists($path)) {
                Storage::disk($disk)->delete($path);
            }
        } catch (\Exception $e) {
            Log::error('File delete failed: '.$e->getMessage());
        }
    }
}