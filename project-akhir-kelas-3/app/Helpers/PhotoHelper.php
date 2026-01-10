<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PhotoHelper
{
    const PHOTO_DIR = 'photos';
    const MAX_SIZE = 5242880; // 5MB in bytes

    /**
     * Store photo dari UploadedFile
     * @param UploadedFile $file
     * @param string $folder (subfolder: santris, obats, etc)
     * @return string|null path relatif ke public
     */
    public static function store(UploadedFile $file, string $folder = 'general'): ?string
    {
        try {
            // Validasi size
            if ($file->getSize() > self::MAX_SIZE) {
                return null;
            }

            $name = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $path = self::PHOTO_DIR . '/' . $folder;

            $file->storeAs($path, $name, 'public');

            return $path . '/' . $name;
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Delete photo dari storage
     * @param string|null $photoPath
     * @return bool
     */
    public static function delete(?string $photoPath): bool
    {
        if (!$photoPath) {
            return true;
        }

        try {
            if (Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Get URL untuk menampilkan foto
     * @param string|null $photoPath
     * @return string
     */
    public static function url(?string $photoPath): string
    {
        if (!$photoPath) {
            return asset('dummy.png');
        }

        return asset('storage/' . $photoPath);
    }
}
