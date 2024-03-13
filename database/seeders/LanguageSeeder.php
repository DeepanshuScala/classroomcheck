<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Languages;

class LanguageSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        Languages::truncate();
        $languagesArr = [
            ['language' => 'English - All'],
            ['language' => 'English - Australia'],
            ['language' => 'English - UK'],
            ['language' => 'English - US'],
            ['language' => 'Arabic'],
            ['language' => 'Armenian'],
            ['language' => 'Auslan (Sign Language)'],
            ['language' => 'Bengali'],
            ['language' => 'Bosnian'],
            ['language' => 'Bulgarian'],
            ['language' => 'Burmese'],
            ['language' => 'Cantonese'],
            ['language' => 'Chinese'],
            ['language' => 'Cook Island Maori'],
            ['language' => 'Croatian'],
            ['language' => 'Czech'],
            ['language' => 'Danish'],
            ['language' => 'Dutch'],
            ['language' => 'Fijian'],
            ['language' => 'Filipino'],
            ['language' => 'Finnish'],
            ['language' => 'French'],
            ['language' => 'German'],
            ['language' => 'Greek'],
            ['language' => 'Hawaiian'],
            ['language' => 'Hebrew'],
            ['language' => 'Hindi'],
            ['language' => 'Hungarian'],
            ['language' => 'Indonesian'],
            ['language' => 'Irish'],
            ['language' => 'Italian'],
            ['language' => 'Japanese'],
            ['language' => 'Javanese'],
            ['language' => 'Korean'],
            ['language' => 'Latin'],
            ['language' => 'Lithuanian'],
            ['language' => 'Macedonian'],
            ['language' => 'Malay'],
            ['language' => 'Maltese'],
            ['language' => 'Mandarin'],
            ['language' => 'Māori'],
            ['language' => 'Mongolian'],
            ['language' => 'Nepali'],
            ['language' => 'New Zealand Sign Language'],
            ['language' => 'Norwegian'],
            ['language' => 'Pashto'],
            ['language' => 'Persian'],
            ['language' => 'Polish'],
            ['language' => 'Portuguese'],
            ['language' => 'Punjabi'],
            ['language' => 'Romanian'],
            ['language' => 'Romansh'],
            ['language' => 'Russian'],
            ['language' => 'Samoan'],
            ['language' => 'Sign Language  (Auslan)'],
            ['language' => 'Sign Language (NZ)'],
            ['language' => 'Sinhala'],
            ['language' => 'Slovak'],
            ['language' => 'Spanish'],
            ['language' => 'Sudanese'],
            ['language' => 'Swahili'],
            ['language' => 'Swedish'],
            ['language' => 'Tahitian'],
            ['language' => 'Tamil'],
            ['language' => 'Thai'],
            ['language' => 'Tibetan'],
            ['language' => 'Tongan'],
            ['language' => 'Turkish'],
            ['language' => 'Ukranian'],
            ['language' => 'Vietnamses'],
            ['language' => 'Xiang']
        ];

        foreach ($languagesArr as $key => $value) {
            Languages::create([
                'language' => $value['language']
            ]);
        }
    }

}
