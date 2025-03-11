<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class PetApiController extends Controller
{
    public function show(Pet $pet): JsonResponse
    {
        // Check if photo is binary data
        $photoIsPath = is_string($pet->photo) && !preg_match('/^\0/', $pet->photo);
        $photoUrl = null;
        
        if ($photoIsPath) {
            // It's a path, use it directly
            $photoUrl = $pet->photo ? asset('storage/' . $pet->photo) : asset('storage/defaults/paw.png');
        } else if ($pet->photo) {
            // It's binary data, create a data URL or temporary file
            $photoUrl = $this->getBinaryImageUrl($pet->photo, $pet->id);
        } else {
            // No photo
            $photoUrl = asset('storage/defaults/paw.png');
        }
        
        return response()->json([
            'id' => $pet->id,
            'name' => $pet->name,
            'category' => $pet->category,
            'breed' => $pet->breed,
            'age' => $pet->age,
            'age_unit' => $pet->age_unit,
            'weight' => $pet->weight,
            'gender' => $pet->gender,
            'photo' => $photoIsPath ? $pet->photo : null,
            'photo_url' => $photoUrl,
        ]);
    }
    
    /**
     * Convert binary image data to a usable URL
     * 
     * @param mixed $binaryData
     * @param int $petId
     * @return string
     */
    private function getBinaryImageUrl($binaryData, $petId): string
    {
        // Option 1: Create a data URL (works for smaller images)
        $mime = $this->detectMimeType($binaryData);
        if ($mime) {
            return 'data:' . $mime . ';base64,' . base64_encode($binaryData);
        }
        
        // Option 2: Store as temporary file (for larger images)
        $tempPath = 'temp/pet_' . $petId . '_' . time() . '.jpg';
        Storage::disk('public')->put($tempPath, $binaryData);
        return asset('storage/' . $tempPath);
    }
    
    /**
     * Detect MIME type from binary data
     * 
     * @param string $data
     * @return string|null
     */
    private function detectMimeType($data): ?string
    {
        // Check for common image signatures
        if (substr($data, 0, 2) === "\xFF\xD8") {
            return 'image/jpeg';
        } elseif (substr($data, 0, 8) === "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A") {
            return 'image/png';
        } elseif (substr($data, 0, 6) === "GIF87a" || substr($data, 0, 6) === "GIF89a") {
            return 'image/gif';
        }
        
        return null;
    }
} 