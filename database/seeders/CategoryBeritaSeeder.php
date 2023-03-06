<?php

namespace Database\Seeders;

use App\Models\CategoryBerita;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryBeritaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoryBerita::create([
            'title' => 'postingan',
            'slug' => 'postingan'
        ]);

        CategoryBerita::create([
            'title' => 'pelatihan',
            'slug' => 'pelatihan'
        ]);

        CategoryBerita::create([
            'title' => 'bimtek',
            'slug' => 'bimtek'
        ]);
    }
}
