<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GradeLevels;

class GradeLevelsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $resArr = [
            'Pre Prep / Pre K',
            'Prep / K',
            '1st', '2nd', '3rd', '4th', '7th', '8th',
            '9th', '10th', '11th', '12th', 'Not Grade Specific',
            'Higher Education', 'Adult Education', 'Homeschool', 'Staff'
        ];
        for ($i = 0; $i <= count($resArr)-1; $i++) {
            GradeLevels::create([
                'grade' => $resArr[$i],
                'status' => 1
            ]);
        }
    }

}
