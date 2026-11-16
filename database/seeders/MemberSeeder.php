<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Member;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $members = [
            [
                'name' => 'Amirul Ichsandina',
                'email' => 'amirul@gmail.com',
                'phone' => '081234567890',
                'address' => 'Karawang, Jawa Barat',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@gmail.com',
                'phone' => '081234567891',
                'address' => 'Karawang, Jawa Barat',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@gmail.com',
                'phone' => '081234567892',
                'address' => 'Bekasi, Jawa Barat',
            ],
            [
                'name' => 'Andi Pratama',
                'email' => 'andi@gmail.com',
                'phone' => '081234567893',
                'address' => 'Subang, Jawa Barat',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@gmail.com',
                'phone' => '081234567894',
                'address' => 'Purwakarta, Jawa Barat',
            ],
            [
                'name' => 'Rizky Ramadhan',
                'email' => 'rizky@gmail.com',
                'phone' => '081234567895',
                'address' => 'Bandung, Jawa Barat',
            ],
            [
                'name' => 'Nadia Putri',
                'email' => 'nadia@gmail.com',
                'phone' => '081234567896',
                'address' => 'Cikarang, Jawa Barat',
            ],
            [
                'name' => 'Fajar Maulana',
                'email' => 'fajar@gmail.com',
                'phone' => '081234567897',
                'address' => 'Karawang, Jawa Barat',
            ],
            [
                'name' => 'Putri Amelia',
                'email' => 'putri@gmail.com',
                'phone' => '081234567898',
                'address' => 'Cikampek, Jawa Barat',
            ],
            [
                'name' => 'Dimas Saputra',
                'email' => 'dimas@gmail.com',
                'phone' => '081234567899',
                'address' => 'Bogor, Jawa Barat',
            ],
        ];

        foreach ($members as $member) {
            Member::updateOrCreate(
                ['email' => $member['email']],
                $member
            );
        }
    }
}
