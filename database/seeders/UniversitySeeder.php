<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schools = [
            'Roig academy',
            'Allison academy',
            'Carrolton School',
            'LASU',
            'Ransom Everglades High School',
            'Church School'
        ];

        for($i = 0; $i<count($schools); $i++) {
            University::create([
                'university' => $schools[$i]
            ]);
        }
    }
}
