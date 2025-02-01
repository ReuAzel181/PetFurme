<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use App\Models\CheckupHistory;
use Illuminate\Http\Request;

class PetCheckupController extends Controller
{
    public function getHistory(Pet $pet, $category)
    {
        $history = CheckupHistory::where('pet_id', $pet->id)
            ->where('category', $category)
            ->orderBy('checkup_date', 'desc')
            ->get()
            ->map(function ($record) {
                return [
                    'checkup_date' => $record->checkup_date->format('M d, Y'),
                    'results' => $record->results,
                    'existing_symptoms' => $record->existing_symptoms,
                    'current_medication' => $record->current_medication,
                    'new_medication' => $record->new_medication,
                    'notes' => $record->notes,
                ];
            });

        return response()->json($history);
    }
}