<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\User;
use Carbon\Carbon;

/**
 * Run: php artisan make:seeder AppointmentsTableSeeder
 * To Run the seeder: php artisan db:seed --class=AppointmentsTableSeeder
 */
class AppointmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all users with role "patient"
        $patients = User::whereHas('roles', function ($query) {
            $query->where('name', 'patient');
        })->get();

        foreach ($patients as $patient) {
            // Create random number of appointments per patient (1–3)
            $count = rand(1, 3);

            for ($i = 0; $i < $count; $i++) {
                Appointment::create([
                    'user_id' => $patient->id,
                    'title' => 'Checkup for ' . $patient->name,
                    'appointment_date' => Carbon::now()->addDays(rand(1, 30))->format('Y-m-d'),
                    'appointment_time' => Carbon::createFromTime(rand(8, 17), 0)->format('H:i'),
                    'notes' => 'Sample notes for appointment ' . ($i + 1),
                    'status' => ['Pending','Confirmed','Cancelled'][rand(0,2)],
                ]);
            }
        }
    }
}
