<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (UserType::count() === 0) {
            $types = json_decode(file_get_contents(__DIR__ . '/data/user_types.json'), true);

            $bar = $this->command->getOutput()->createProgressBar(count($types));

            foreach ($types as $type) {
                UserType::create([
                    'type' => $type['type'],
                    'slug' => $type['slug'],
                ]);
                $bar->advance();
            }

            $bar->finish();
            echo "\n";
        }
    }
}
