<?php
namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        // Insert ke tabel 'role'
        \DB::table('role')->insert([
            ['nama' => 'admin'],
            ['nama' => 'guru'],
            ['nama' => 'kepala sekolah'],
            ['nama' => 'siswa'],
        ]);

// Insert ke tabel 'users'
        \DB::table('users')->insert([
            [
                'username'      => 'admin',
                'name'          => 'Admin',
                'password'      => bcrypt('admin'),
                'email'         => 'admin@admin.com',
                'jenis_kelamin' => '*',
                'role_id'       => 1,
            ],
            [
                'username'      => 'admin2',
                'name'          => 'Admin2',
                'password'      => bcrypt('admin'),
                'email'         => 'admin2@admin.com',
                'jenis_kelamin' => 'Laki-Laki',
                'role_id'       => 1, // tambahkan jika kolom ini wajib
            ],
        ]);

        \DB::table('tahun_pelajaran')->insert([
            [
                'kode' => '20251',
                'nama' => '2025/2026',
                'semester' => 'Ganjil',
                'status' => 'aktif',
            ],
        ]);

        \DB::table('kelas')->insert([
            [
                'romawi' => 'X',
                'angka' => '10',
                'keterangan' => 'Kelas 10',
            ],
        ]);
        \DB::table('kelas')->insert([
            [
                'romawi' => 'XI',
                'angka' => '11',
                'keterangan' => 'Kelas 11',
            ],
        ]);
        \DB::table('kelas')->insert([
            [
                'romawi' => 'XII',
                'angka' => '12',
                'keterangan' => 'Kelas 12',
            ],
        ]);
        \DB::table('kelas_sub')->insert([
            [
                'kelas_id' => 1,
                'sub' => 'A',
                'keterangan' => 'Kelas 10 A',
            ],
        ]);

        Guru::factory()->count(20)->create(); // otomatis buat 20 guru dan user

        // $batchSize = 500; // jumlah data per batch insert
        // $data      = [];

        // for ($i = 3; $i < 10000; $i++) {
        //     $data[] = [
        //         'username'      => 'siswa' . $i,
        //         'name'          => 'Siswa' . $i,
        //         'password'      => bcrypt('siswa'),
        //         'email'         => 'siswa' . $i . '@siswa.com',
        //         'jenis_kelamin' => ['Laki-Laki', 'Perempuan'][rand(0, 1)],
        //         'role_id'       => 4,
        //     ];

        //     // Jika sudah mencapai batas batch, insert lalu reset
        //     if (count($data) >= $batchSize) {
        //         \DB::table('users')->insert($data);
        //         $data = []; // kosongkan untuk batch berikutnya
        //     }
        // }
    }
}
