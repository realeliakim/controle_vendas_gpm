<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() === 0) {
            $users = json_decode(file_get_contents(__DIR__ . '/data/users.json'), true);

            $bar = $this->command->getOutput()->createProgressBar(count($users));

            foreach ($users as $user) {
                User::create([
                    'name'         => $user['name'],
                    'email'        => $user['email'],
                    'cpf'          => $user['cpf'],
                    'user_type_id' => $user['user_type_id'],
                    'password'     => $user['password'],
                ]);
                $bar->advance();
            }

            $bar->finish();
            echo "\n";
        }
    }
}
