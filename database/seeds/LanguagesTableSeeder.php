<?php

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Language::count()) {
            return;
        }

        $languages = [
            ['name' => 'Arabic'],
            ['name' => 'French'],
            ['name' => 'Spanish'],
            ['name' => 'German'],
            ['name' => 'English'],
            ['name' => 'Portuguese'],
            ['name' => 'Italian'],
            ['name' => 'Swedish'],
            ['name' => 'Norwegian'],
            ['name' => 'Dutch']
        ];

        Language::insert($languages);
    }
}
