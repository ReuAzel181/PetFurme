<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class OwnerApiController extends Controller
{
    public function show(User $user): JsonResponse
    {
        try {
            Log::info('Processing user data', ['user_id' => $user->id]);
            
            // First, let's get the raw data and ensure it's properly encoded
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ];

            // JSON encode and then decode to ensure valid UTF-8
            $sanitizedData = json_decode(json_encode($userData, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE), true);
            
            // Now add the avatar URL separately since it's not a string from DB
            $sanitizedData['avatar_url'] = $this->getAvatarUrl($user);

            return new JsonResponse([
                'success' => true,
                'data' => $sanitizedData
            ], 200, ['Content-Type' => 'application/json']);

        } catch (\Exception $e) {
            Log::error('Error in OwnerApiController@show: ' . $e->getMessage(), [
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return new JsonResponse([
                'success' => false,
                'message' => 'Failed to fetch owner data',
                'error' => 'Internal server error'
            ], 500);
        }
    }

    public function pets(User $owner): JsonResponse
    {
        try {
            Log::info('Fetching pets for user', ['user_id' => $owner->id]);
            
            $pets = $owner->pets()->get()->map(function ($pet) {
                return [
                    'id' => $pet->id,
                    'name' => $this->sanitizeString($pet->name),
                    'category' => $this->sanitizeString($pet->category),
                    'breed' => $this->sanitizeString($pet->breed),
                    'age' => $pet->age,
                    'weight' => $pet->weight,
                    'gender' => $this->sanitizeString($pet->gender),
                    'photo_url' => $this->getPetPhotoUrl($pet)
                ];
            });

            Log::info('Found pets', [
                'count' => $pets->count(),
                'pets' => $pets->toArray()
            ]);

            return response()->json([
                'success' => true,
                'pets' => $pets->toArray()
            ], 200, [
                'Content-Type' => 'application/json; charset=utf-8'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in OwnerApiController@pets: ' . $e->getMessage(), [
                'owner_id' => $owner->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch pets',
                'error' => 'Internal server error'
            ], 500);
        }
    }

    /**
     * Sanitize and encode string data
     */
    private function sanitizeString(?string $value): string
    {
        if (empty($value)) {
            return '';
        }

        // Remove invalid UTF-8 characters
        $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value);
        
        // Convert encoding
        $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        
        // Strip any remaining invalid characters
        return preg_replace('/[^\p{L}\p{N}\p{P}\p{Z}]/u', '', $value);
    }

    /**
     * Get avatar URL with proper error handling
     */
    private function getAvatarUrl(User $user): string
    {
        try {
            if (empty($user->photo)) {
                return asset('storage/defaults/avatar.png');
            }

            $photoIsPath = is_string($user->photo) && !preg_match('/^\0/', $user->photo);
            
            if ($photoIsPath) {
                return asset('storage/' . $user->photo);
            }

            // Handle binary data
            $mime = $this->detectMimeType($user->photo);
            if ($mime) {
                return 'data:' . $mime . ';base64,' . base64_encode($user->photo);
            }

            return asset('storage/defaults/avatar.png');
        } catch (\Exception $e) {
            Log::error('Error processing avatar: ' . $e->getMessage());
            return asset('storage/defaults/avatar.png');
        }
    }

    /**
     * Get pet photo URL with proper error handling
     */
    private function getPetPhotoUrl($pet): string
    {
        try {
            if (empty($pet->photo)) {
                return asset('storage/defaults/paw.png');
            }

            $photoIsPath = is_string($pet->photo) && !preg_match('/^\0/', $pet->photo);
            
            if ($photoIsPath) {
                return asset('storage/' . $pet->photo);
            }

            // Handle binary data
            $mime = $this->detectMimeType($pet->photo);
            if ($mime) {
                return 'data:' . $mime . ';base64,' . base64_encode($pet->photo);
            }

            return asset('storage/defaults/paw.png');
        } catch (\Exception $e) {
            Log::error('Error processing pet photo: ' . $e->getMessage());
            return asset('storage/defaults/paw.png');
        }
    }

    /**
     * Detect MIME type from binary data
     */
    private function detectMimeType($data): ?string
    {
        try {
            if (substr($data, 0, 2) === "\xFF\xD8") {
                return 'image/jpeg';
            } 
            if (substr($data, 0, 8) === "\x89\x50\x4E\x47\x0D\x0A\x1A\x0A") {
                return 'image/png';
            }
            if (substr($data, 0, 6) === "GIF87a" || substr($data, 0, 6) === "GIF89a") {
                return 'image/gif';
            }
        } catch (\Exception $e) {
            Log::error('Error detecting MIME type: ' . $e->getMessage());
        }
        
        return null;
    }
} 