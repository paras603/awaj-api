<?php

namespace Database\Seeders;


use App\Models\ProfilePicture;
use Illuminate\Database\Seeder;

class ProfilePictureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfilePicture::factory(10)->create();
    }
}
