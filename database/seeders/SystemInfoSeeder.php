<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemInfo;

class SystemInfoSeeder extends Seeder
{
    public function run(): void
    {
        SystemInfo::firstOrCreate([], [
            'site_name'         => 'Teqhitch ICT Academy LMS',
            'site_logo'         => null,
            'favicon'           => null,
            'support_email'     => 'support@teqhitch.com',
            'support_phone'     => '+234 800 000 0000',
            'timezone'          => 'Africa/Lagos',
            'address'           => 'Lagos, Nigeria',
            'about'             => 'Welcome to Teqhitch ICT Academy LMS.',
            'social_links'      => [
                'facebook' => 'https://facebook.com/teqhitch',
                'twitter'  => 'https://twitter.com/teqhitch',
                'youtube'  => null,
            ],
            'maintenance_mode'  => false,
            'registration_open' => true,
        ]);
    }
}
