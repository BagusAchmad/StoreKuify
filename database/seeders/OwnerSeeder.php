<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'owner@storekuify.com'],
            [
                'name' => 'Owner StoreKuify',
                'password' => Hash::make('pahlawan123'),
                'role' => 'Owner',
                'is_active' => true,
            ]
        );
    }
}
