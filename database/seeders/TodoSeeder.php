<?php

namespace Database\Seeders;

use App\Models\Todo;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TodoSeeder extends Seeder
{
    public function run(): void
    {
        $todos = [
            [
                'judul'            => 'Selesaikan laporan keuangan Q4',
                'deskripsi'        => 'Rekap semua transaksi bulan Oktober-Desember dan buat ringkasan untuk disampaikan ke manajemen.',
                'kategori'         => 'pekerjaan',
                'prioritas'        => 'kritis',
                'tags'             => ['kantor', 'segera'],
                'is_penting'       => true,
                'tanggal_deadline' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'status'           => 'proses',
            ],
            [
                'judul'            => 'Beli bahan makanan mingguan',
                'deskripsi'        => 'Sayuran, buah, protein, dan kebutuhan dapur lainnya.',
                'kategori'         => 'belanja',
                'prioritas'        => 'rendah',
                'tags'             => ['rumah'],
                'is_penting'       => false,
                'tanggal_deadline' => Carbon::now()->addDays(2)->format('Y-m-d'),
                'status'           => 'belum',
            ],
            [
                'judul'            => 'Olahraga pagi — lari 5km',
                'deskripsi'        => 'Lari di taman kota, target 5km dalam 30 menit.',
                'kategori'         => 'kesehatan',
                'prioritas'        => 'sedang',
                'tags'             => [],
                'is_penting'       => true,
                'tanggal_deadline' => Carbon::now()->addDay()->format('Y-m-d'),
                'status'           => 'belum',
            ],
            [
                'judul'            => 'Review PR GitHub tim backend',
                'deskripsi'        => 'Ada 3 pull request yang perlu direview sebelum merge ke main branch.',
                'kategori'         => 'pekerjaan',
                'prioritas'        => 'tinggi',
                'tags'             => ['kantor', 'review'],
                'is_penting'       => false,
                'tanggal_deadline' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'status'           => 'belum',
            ],
            [
                'judul'            => 'Belajar Laravel 11 — Fitur baru',
                'deskripsi'        => 'Pelajari fitur-fitur baru di Laravel 11 terutama tentang Pest dan Volt.',
                'kategori'         => 'pendidikan',
                'prioritas'        => 'sedang',
                'tags'             => ['review'],
                'is_penting'       => false,
                'tanggal_deadline' => Carbon::now()->addWeek()->format('Y-m-d'),
                'status'           => 'proses',
            ],
            [
                'judul'            => 'Bayar tagihan listrik dan internet',
                'deskripsi'        => null,
                'kategori'         => 'pribadi',
                'prioritas'        => 'tinggi',
                'tags'             => ['rumah', 'segera'],
                'is_penting'       => true,
                'tanggal_deadline' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'status'           => 'selesai',
            ],
            [
                'judul'            => 'Siapkan materi presentasi klien',
                'deskripsi'        => 'Presentasi untuk demo produk baru kepada klien potensial dari Jakarta.',
                'kategori'         => 'pekerjaan',
                'prioritas'        => 'kritis',
                'tags'             => ['kantor', 'segera', 'delegasi'],
                'is_penting'       => true,
                'tanggal_deadline' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'status'           => 'belum',
            ],
        ];

        foreach ($todos as $todo) {
            Todo::create($todo);
        }
    }
}
