<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'app_name' => 'Perpustakaan',
            'logo' => 'img/logo_sma.png',
            'copyright' => 'Perpustakaan | 2026',
            'login_title' => 'Sistem Informasi Perpustakaan',
            'keywords' => 'perpustakaan, buku, sistem informasi',
            'description' => 'Aplikasi sistem informasi perpustakaan sekolah.',
        ]);
    }
}
