<?php
namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
                'kode' => '20242',
                'nama' => '2024/2026',
                'semester' => 'Genap',
                'status' => 'tidak aktif',
            ],
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
        \DB::table('mata_pelajaran')->insert([
            [
                'nama' => 'Ilmu Pengetahuan Alam',
                'kode' => 'IPA',
                'status' => 'aktif',
                'kelas_id' => 1
            ],
            [
                'nama' => 'Bahasa Indonesia',
                'kode' => 'BINDO',
                'status' => 'aktif',
                'kelas_id' => 1
            ],
            [
                'nama' => 'Bahasa Inggris',
                'kode' => 'BINGGRIS',
                'status' => 'aktif',
                'kelas_id' => 1
            ],
        ]);
        \DB::table('kurikulum')->insert([
            [
                'nama' => 'Kurikulum Lama',
                'tahun_pelajaran_id' => 1,
            ],
        ]);
        \DB::table('kurikulum')->insert([
            [
                'nama' => 'Kurikulum Merdeka',
                'tahun_pelajaran_id' => 2,
            ],
        ]);
        \DB::table('kurikulum_detail')->insert([
            [
                'kurikulum_id' => 1,
                'mata_pelajaran_id' => 1,
            ],
            [
                'kurikulum_id' => 2,
                'mata_pelajaran_id' => 2,
            ],
            [
                'kurikulum_id' => 2,
                'mata_pelajaran_id' => 3,
            ],
        ]);

        Guru::factory()->count(20)->create(); // otomatis buat 20 guru dan user
        Siswa::factory()->count(20)->create(); // otomatis buat 20 guru dan user

        \DB::table('jadwal')->insert([
            [
                'tahun_pelajaran_id' => 1,
                'kurikulum_detail_id' => 1,
                'kelas_sub_id' => 1,
                'guru_id' => 1,
                'hari' => 'Senin',
                'jam_mulai' => '08:00',
                'jam_selesai' => '09:00',
            ],
        ]);


        $jadwalId = 1; // ID mapel yang akan diisi

        // Daftar komponen
        $komponenMap = [
            'pengetahuan' => ['Ulangan Harian', 'Tugas', 'UTS', 'UAS'],
            'keterampilan' => ['Praktik', 'Proyek'],
            'sikap' => ['Sikap Spiritual', 'Sikap Sosial'],
        ];

        $insertedKomponen = [];

        foreach ($komponenMap as $jenis => $komponens) {
            foreach ($komponens as $nama) {
                $insertedKomponen[] = [
                    'nama' => $nama,
                    'jenis' => $jenis,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert ke komponen_nilai
        DB::table('komponen_nilai')->insert($insertedKomponen);

        // Ambil kembali data komponen berdasarkan mapel dan jenis
        $komponenAll = DB::table('komponen_nilai')
            ->get()
            ->groupBy('jenis');

        $bobotData = [];

        foreach ($komponenAll as $jenis => $komponens) {
            $jumlah = $komponens->count();
            $bobot = round(1 / $jumlah, 2); // contoh: 1/4 = 0.25, 1/3 ≈ 0.33

            foreach ($komponens as $komponen) {
                $bobotData[] = [
                    'jadwal_id' => $jadwalId,
                    'komponen_nilai_id' => $komponen->id,
                    'bobot' => $bobot,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert ke bobot_nilai
        DB::table('bobot_nilai')->insert($bobotData);
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
