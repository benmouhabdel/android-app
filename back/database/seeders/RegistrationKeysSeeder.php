<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegistrationKeysSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('registration_keys')->updateOrInsert([
            'key' => 'Shifters@Heec143',
        ]);
    }
}
