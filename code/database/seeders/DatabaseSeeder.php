<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\ClientRepository;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('passport:keys --force');

        $clientRepository = new ClientRepository();
        $clientRepository->createPasswordGrantClient(null, 'Admin Client', '', 'admins');
        $clientRepository->createPasswordGrantClient(null, 'User Client', '', 'users');

        $this->call([
            UserSeeder::class,
            CompanySeeder::class,
        ]);
    }
}
