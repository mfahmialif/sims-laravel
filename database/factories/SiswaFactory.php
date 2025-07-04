<?php
namespace Database\Factories;

use App\Models\User;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Kurikulum;
use App\Models\TahunPelajaran;
use Illuminate\Database\Eloquent\Factories\Factory;

class SiswaFactory extends Factory
{
    protected $model = Siswa::class;

    public function definition(): array
    {
        return [
            'kelas_id'                 => Kelas::inRandomOrder()->value('id') ?? 1,
            'tahun_pelajaran_id'       => TahunPelajaran::inRandomOrder()->value('id') ?? 1,
            'user_id'                  => User::factory()->siswa(),
            'kurikulum_id'             => Kurikulum::inRandomOrder()->value('id') ?? 1,

            'nis'                      => $this->faker->unique()->numerify('##########'),
            'nisn'                     => $this->faker->unique()->numerify('##########'),
            'nama_siswa'               => $this->faker->name,
            'jenis_kelamin'            => $this->faker->randomElement(['Laki-Laki', 'Perempuan']),
            'tempat_lahir'             => $this->faker->city,
            'tanggal_lahir'            => $this->faker->date('Y-m-d', '2015-01-01'),
            'agama'                    => 'Islam',
            'nik_anak'                 => $this->faker->numerify('################'),
            'kk'                       => $this->faker->numerify('################'),
            'no_registrasi_akta_lahir' => $this->faker->numerify('##########'),
            'akta_lahir_path'          => null,
            'anak_ke'                  => $this->faker->numberBetween(1, 5),
            'jumlah_saudara_kandung'   => $this->faker->numberBetween(0, 6),
            'umur_anak'                => null,
            'masuk_sekolah_sebagai'    => 'Siswa Baru',
            'asal_sekolah_tk'          => $this->faker->company,
            'tinggi_badan'             => $this->faker->numberBetween(100, 140),
            'berat_badan'              => $this->faker->numberBetween(20, 50),
            'lingkar_kepala'           => $this->faker->numberBetween(40, 55),
            'jarak_tempuh_ke_sekolah'  => $this->faker->randomFloat(2, 0.1, 15),
            'gol_darah'                => $this->faker->randomElement(['A', 'B', 'AB', 'O']),
            'foto'                     => null,

            'alamat_anak_sesuai_kk'    => $this->faker->address,
            'desa_kelurahan_anak'      => $this->faker->streetName,
            'kecamatan_anak'           => $this->faker->city,
            'kabupaten_anak'           => $this->faker->city,
            'kode_pos_anak'            => $this->faker->postcode,
            'rt_anak'                  => $this->faker->numberBetween(1, 10),
            'rw_anak'                  => $this->faker->numberBetween(1, 10),
            'lintang'                  => $this->faker->latitude,
            'bujur'                    => $this->faker->longitude,

            'nama_ayah'                => $this->faker->name('male'),
            'nik_ayah'                 => $this->faker->numerify('################'),
            'tahun_lahir_ayah'         => $this->faker->year('1980'),
            'pendidikan_ayah'          => 'S1',
            'pekerjaan_ayah'           => 'PNS',
            'penghasilan_bulanan_ayah' => $this->faker->numberBetween(1000000, 10000000),

            'nama_ibu_sesuai_ktp'      => $this->faker->name('female'),
            'nik_ibu'                  => $this->faker->numerify('################'),
            'tahun_lahir_ibu'          => $this->faker->year('1985'),
            'pendidikan_ibu'           => 'SMA',
            'pekerjaan_ibu'            => 'Ibu Rumah Tangga',
            'penghasilan_bulanan_ibu'  => $this->faker->numberBetween(0, 5000000),

            'alamat_ortu_sesuai_kk'    => $this->faker->address,
            'kelurahan_ortu'           => $this->faker->streetName,
            'kecamatan_ortu'           => $this->faker->city,
            'kabupaten_ortu'           => $this->faker->city,
            'no_kartu_keluarga'        => $this->faker->numerify('################'),

            'tinggal_bersama'          => $this->faker->randomElement(['Orang Tua', 'Wali']),
            'transportasi_ke_sekolah'  => 'Jalan Kaki',
            'nomor_telepon_orang_tua'  => $this->faker->phoneNumber,

            'nama_wali'                => $this->faker->name,
            'nik_wali'                 => $this->faker->numerify('################'),
            'tahun_lahir_wali'         => $this->faker->year('1970'),
            'pendidikan_wali'          => 'SMA',
            'pekerjaan_wali'           => 'Wiraswasta',
            'penghasilan_bulanan_wali' => $this->faker->numberBetween(1000000, 5000000),
            'alamat_wali'              => $this->faker->address,
            'rt_wali'                  => '02',
            'rw_wali'                  => '01',
            'desa_kelurahan_wali'      => $this->faker->streetName,
            'kecamatan_wali'           => $this->faker->city,
            'kabupaten_wali'           => $this->faker->city,
            'kode_pos_wali'            => $this->faker->postcode,
            'nomor_telepon_wali'       => $this->faker->phoneNumber,

            'status_daftar'            => 'daftar',
            'status'                   => 'aktif',
        ];
    }
}
