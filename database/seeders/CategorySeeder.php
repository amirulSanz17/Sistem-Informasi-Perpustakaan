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
                'name' => 'Pemrograman',
                'description' => 'Buku mengenai bahasa pemrograman dan pengembangan software.',
            ],
            [
                'name' => 'Teknologi Informasi',
                'description' => 'Buku mengenai teknologi informasi dan komputer.',
            ],
            [
                'name' => 'Basis Data',
                'description' => 'Buku mengenai database dan pengelolaan data.',
            ],
            [
                'name' => 'Jaringan Komputer',
                'description' => 'Buku mengenai jaringan komputer dan infrastruktur jaringan.',
            ],
            [
                'name' => 'Sistem Informasi',
                'description' => 'Buku mengenai analisis dan pengembangan sistem informasi.',
            ],
            [
                'name' => 'Kecerdasan Buatan',
                'description' => 'Buku mengenai artificial intelligence dan machine learning.',
            ],
            [
                'name' => 'Desain Grafis',
                'description' => 'Buku mengenai desain visual, ilustrasi, dan multimedia.',
            ],
            [
                'name' => 'Keamanan Siber',
                'description' => 'Buku mengenai keamanan jaringan, data, dan sistem komputer.',
            ],
            [
                'name' => 'Novel',
                'description' => 'Kumpulan buku cerita dan karya fiksi.',
            ],
            [
                'name' => 'Pendidikan',
                'description' => 'Buku mengenai pembelajaran, pendidikan, dan pengembangan ilmu pengetahuan.',
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
