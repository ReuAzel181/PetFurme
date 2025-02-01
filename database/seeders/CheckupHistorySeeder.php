<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CheckupHistory;
use App\Models\Pet;

class CheckupHistorySeeder extends Seeder
{
    public function run()
    {
        // Get all pets
        $pets = Pet::all();

        foreach ($pets as $pet) {
            // Create sample records for each pet
            CheckupHistory::create([
                'pet_id' => $pet->id,
                'category' => 'Hematology',
                'checkup_date' => now()->subDays(30),
                'results' => 'Normal blood count',
                'existing_symptoms' => 'Lethargy, Loss of appetite',
                'current_medication' => 'Vitamin B Complex 1 tablet daily',
                'new_medication' => 'Iron supplements 5mg daily'
            ]);

            CheckupHistory::create([
                'pet_id' => $pet->id,
                'category' => 'Blood Chemistry',
                'checkup_date' => now()->subDays(15),
                'results' => 'Elevated liver enzymes',
                'existing_symptoms' => 'Vomiting',
                'current_medication' => 'Antiemetic 10mg twice daily',
                'new_medication' => 'Liver supplements 1 tablet daily'
            ]);
        }
    }
} 