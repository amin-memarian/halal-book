<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileUploaderService
{
    private const STORAGE_PREFIX = '/storage/';

    public static function uploadFile(UploadedFile $file, ?string $oldFile = null, string $folder = 'avatars'): string
    {
        if (!is_null($oldFile)) {
            self::removeFile($oldFile);
        }

        $fileName = Str::random(10) . '.' . $file->getClientOriginalExtension();

        $path = $file->storeAs($folder, $fileName, 'public');

        return self::STORAGE_PREFIX . $path;
    }

    public static function removeFile(?string $filePath): bool
    {
        if (empty($filePath)) {
            return false;
        }

        $storagePath = str_replace(self::STORAGE_PREFIX, '', $filePath);

        if (Storage::disk('public')->exists($storagePath)) {
            return Storage::disk('public')->delete($storagePath);
        }

        return false;
    }
}
