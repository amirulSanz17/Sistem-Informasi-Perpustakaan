<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Fiksi Ilmiah',
                'description' => 'Cerita fiksi bertema teknologi masa depan, luar angkasa, dan sains.',
            ],
            [
                'name' => 'Sejarah Dunia',
                'description' => 'Buku mengenai peristiwa sejarah peradaban dan tokoh dunia.',
            ],
            [
                'name' => 'Psikologi',
                'description' => 'Pembahasan mengenai perilaku manusia, mental, dan pikiran.',
            ],
            [
                'name' => 'Bisnis & Manajemen',
                'description' => 'Panduan kewirausahaan, strategi bisnis, dan kepemimpinan.',
            ],
            [
                'name' => 'Pengembangan Diri',
                'description' => 'Buku motivasi, produktivitas, dan peningkatan kualitas hidup.',
            ],
            [
                'name' => 'Sains Populer',
                'description' => 'Penjelasan fenomena alam, fisika, dan biologi untuk pembaca umum.',
            ],
            [
                'name' => 'Filsafat',
                'description' => 'Pemikiran kritis mengenai eksistensi, etika, dan pengetahuan.',
            ],
            [
                'name' => 'Biografi',
                'description' => 'Kisah nyata perjalanan hidup tokoh-tokoh inspiratif.',
            ],
            [
                'name' => 'Kuliner & Resep',
                'description' => 'Buku panduan memasak, kuliner nusantara, dan mancanegara.',
            ],
            [
                'name' => 'Seni & Fotografi',
                'description' => 'Buku mengenai teknik fotografi, seni rupa, dan estetika visual.',
            ],
            [
                'name' => 'Ekonomi & Investasi',
                'description' => 'Pembahasan literasi keuangan, pasar modal, dan ekonomi makro.',
            ],
            [
                'name' => 'Sastra & Puisi',
                'description' => 'Kumpulan antologi puisi, prosa, dan karya sastra klasik.',
            ],
            [
                'name' => 'Arsitektur & Interior',
                'description' => 'Konsep rancang bangun, tata ruang, dan desain interior.',
            ],
            [
                'name' => 'Kesehatan & Kebugaran',
                'description' => 'Panduan gaya hidup sehat, nutrisi, dan olahraga.',
            ],
            [
                'name' => 'Misteri & Thriller',
                'description' => 'Novel fiksi bertema detektif, teka-teki, dan ketegangan.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
