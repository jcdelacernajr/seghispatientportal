<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

/**
 * Create
 * Run: php artisan make:seeder MedicalRecordsTableSeeder
 * 
 * Seed
 * Run: php artisan db:seed --class=MedicalRecordsTableSeeder
 */
class MedicalRecordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Example: assuming you have patient IDs from 1 to 5
        $patientIds = [4, 5, 6, 7, 8];

        $recordTypes = ['X-ray', 'Physical Exam', 'Lab Result', 'Vaccination', 'Ultrasound'];

        foreach ($patientIds as $patientId) {
            // Generate 2-3 records per patient
            $recordsCount = rand(2, 3);

            for ($i = 0; $i < $recordsCount; $i++) {
                DB::table('medical_records')->insert([
                    'patient_id'   => $patientId,
                    'record_type'  => $recordTypes[array_rand($recordTypes)],
                    'description'  => 'Sample description for patient ' . $patientId,
                    'record_date'  => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d'),
                    'created_at'   => now(),
                    'updated_at'   => now(),
                ]);
            }
        }
    }
}
