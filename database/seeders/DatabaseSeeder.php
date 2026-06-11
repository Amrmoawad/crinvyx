<?php

namespace Database\Seeders;

use App\Models\Attendee;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'username' => 'admin',
            'full_name' => 'Super Admin',
            'password' => 'password',
            'access_create_users' => true,
            'access_manage_events' => true,
            'access_record_attendees' => true,
        ]);



    }
}
