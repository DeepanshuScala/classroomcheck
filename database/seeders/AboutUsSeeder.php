<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutUs;

class AboutUsSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        AboutUs::truncate();
        $json = [
            "about_us" => "Test About Us",
            "about_us_image" => "",
            "our_vision" => "Our Vision",
            "our_mission" => "Our Mission",
            "founding_story_description" => "Founding Story Description",
            "founding_story_image" => ""
        ];
        AboutUs::create($json);
    }

}
