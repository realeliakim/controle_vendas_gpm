<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Section::count() === 0) {
            $sections = json_decode(file_get_contents(__DIR__ . '/data/sections.json'), true);

            $bar = $this->command->getOutput()->createProgressBar(count($sections));

            foreach ($sections as $section) {
                Section::create([
                    'name'        => $section['name'],
                ]);
                $bar->advance();
            }

            $bar->finish();
            echo "\n";
        }
    }
}
