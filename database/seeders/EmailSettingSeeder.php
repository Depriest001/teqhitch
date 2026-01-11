<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EmailSetting;

class EmailSettingSeeder extends Seeder
{
    public function run(): void
    {
        EmailSetting::firstOrCreate([], [
            'mail_driver'   => 'smtp',
            'host'          => 'smtp.gmail.com',
            'port'          => 587,
            'username'      => 'support@teqhitch.com',
            'password'      => 'password_here',
            'encryption'    => 'tls',
            'from_address'  => 'support@teqhitch.com',
            'from_name'     => 'Teqhitch ICT Academy',
            'is_active'     => true,
        ]);
    }
}
