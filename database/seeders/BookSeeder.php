<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Category;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua ID kategori yang sudah ada
        $categoryIds = Category::pluck('id')->toArray();

        // Pastikan kategori tidak kosong sebelum membuat data buku
        if (empty($categoryIds)) {
            $this->command->warn('Tabel categories kosong. Jalankan CategorySeeder terlebih dahulu.');
            return;
        }

        $books = [
            [
                'title' => 'Jejak Langkah di Nebula',
                'author' => 'Rendra Pratama',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2022,
                'stock' => 15,
            ],
            [
                'title' => 'Filosofi Kopi Pagi',
                'author' => 'Dewi Lestari',
                'publisher' => 'Bentang Pustaka',
                'year' => 2018,
                'stock' => 24,
            ],
            [
                'title' => 'Memahami Pikiran Bawah Sadar',
                'author' => 'Dr. Hendra Wijaya',
                'publisher' => 'Elex Media Komputindo',
                'year' => 2021,
                'stock' => 10,
            ],
            [
                'title' => 'Strategi Bisnis Era Digital',
                'author' => 'Budi Santoso',
                'publisher' => 'Andi Publisher',
                'year' => 2023,
                'stock' => 18,
            ],
            [
                'title' => 'Seni Hidup Minimalis',
                'author' => 'Nadia Putri',
                'publisher' => 'Kepustakaan Populer Gramedia',
                'year' => 2020,
                'stock' => 30,
            ],
            [
                'title' => 'Kosmos dan Waktu',
                'author' => 'Prof. Arman Hakim',
                'publisher' => 'Mizan Publishing',
                'year' => 2019,
                'stock' => 12,
            ],
            [
                'title' => 'Jejak Pemikir Timur',
                'author' => 'Surya Saputra',
                'publisher' => 'Narasi',
                'year' => 2017,
                'stock' => 8,
            ],
            [
                'title' => 'Catatan Sang Perintis',
                'author' => 'Fajar Nugroho',
                'publisher' => 'Republika Penerbit',
                'year' => 2024,
                'stock' => 20,
            ],
            [
                'title' => 'Rahasia Dapur Nusantara',
                'author' => 'Chef Rina Marlina',
                'publisher' => 'AgroMedia Pustaka',
                'year' => 2021,
                'stock' => 25,
            ],
            [
                'title' => 'Cahaya di Balik Lensa',
                'author' => 'Dimas Anggara',
                'publisher' => 'Elex Media Komputindo',
                'year' => 2022,
                'stock' => 14,
            ],
            [
                'title' => 'Cerdas Mengelola Aset',
                'author' => 'Kevin Tanuwijaya',
                'publisher' => 'Gramedia Pustaka Utama',
                'year' => 2023,
                'stock' => 19,
            ],
            [
                'title' => 'Senja di Pelabuhan Kecil',
                'author' => 'Chairil Anwar',
                'publisher' => 'Balai Pustaka',
                'year' => 2015,
                'stock' => 11,
            ],
            [
                'title' => 'Arsitektur Tropis Modern',
                'author' => 'Ir. Kartika Sari',
                'publisher' => 'Erlangga',
                'year' => 2020,
                'stock' => 9,
            ],
            [
                'title' => 'Panduan Nutrisi Harian',
                'author' => 'dr. Anisa Rahma',
                'publisher' => 'Kompas Penerbit Buku',
                'year' => 2024,
                'stock' => 22,
            ],
            [
                'title' => 'Misteri Ruang Terkunci',
                'author' => 'Agatha Kusuma',
                'publisher' => 'GagasMedia',
                'year' => 2023,
                'stock' => 16,
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(
                ['title' => $book['title']],
                array_merge($book, [
                    // Memilih category_id secara acak dari tabel categories
                    'category_id' => $categoryIds[array_rand($categoryIds)],
                ])
            );
        }
    }
}
