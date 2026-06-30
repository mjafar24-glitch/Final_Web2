<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Fiksi', 'Sains', 'Sejarah', 'Matematika', 'Bahasa Indonesia',
            'Bahasa Inggris', 'Agama', 'Seni & Budaya', 'Teknologi', 'Ensiklopedia',
        ];

        foreach ($categories as $name) {
            \App\Models\Category::firstOrCreate(['name' => $name]);
        }
    }
}
