<?php
namespace Database\Factories;

use App\Models\Guru;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuruFactory extends Factory
{
    protected $model = Guru::class;

    public function definition()
    {
        return [
            'user_id'              => User::factory(),
            'nip'                  => $this->faker->unique()->numerify('1970##########'),
            'nama'                 => $this->faker->name,
            'nuptk'                => $this->faker->optional()->numerify('12345678####'),
            'npwp'                 => $this->faker->optional()->numerify('###########'),
            'jenis_kelamin'        => $this->faker->randomElement(['Laki-Laki', 'Perempuan']),
            'tempat_lahir'         => $this->faker->city,
            'tanggal_lahir'        => $this->faker->date('Y-m-d', '-25 years'),
            'nik'                  => $this->faker->unique()->numerify('3################'),
            'no_kk'                => $this->faker->optional()->numerify('3################'),
            'agama'                => $this->faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu']),
            'kewarganegaraan'      => 'Indonesia',
            'status_kepegawaian'   => $this->faker->randomElement(['PNS', 'PPPK', 'GTY', 'GTT', 'Honorer']),
            'jenis_ptk'            => $this->faker->randomElement([
                'Kepala Sekolah', 'Wakil Kepala Sekolah', 'Guru Kelas',
                'Guru Mata Pelajaran', 'Guru Bimbingan Konseling', 'Guru TIK',
                'Guru Pendamping Khusus', 'Tenaga Administrasi Sekolah',
                'Pustakawan', 'Laboran', 'Teknisi', 'Penjaga Sekolah', 'Lainnya',
            ]),
            'tugas_tambahan'       => $this->faker->optional()->jobTitle,
            'no_sk_cpns'           => $this->faker->optional()->bothify('SKCPNS-####/XX'),
            'sk_cpns'              => $this->faker->optional()->url,
            'tanggal_cpns'         => $this->faker->optional()->date(),
            'no_sk_pengangkatan'   => $this->faker->bothify('SKANG-####/YY'),
            'sk_pengangkatan'      => $this->faker->optional()->url,
            'tmt_pengangkatan'     => $this->faker->date(),
            'lembaga_pengangkatan' => $this->faker->company,
            'pangkat_golongan'     => $this->faker->optional()->regexify('^[IV]{1,3}/[a-d]{1}$'),
            'alamat_jalan'         => $this->faker->streetAddress,
            'rt'                   => $this->faker->optional()->numerify('0#'),
            'rw'                   => $this->faker->optional()->numerify('0#'),
            'nama_dusun'           => $this->faker->optional()->streetName,
            'desa_kelurahan'       => $this->faker->citySuffix,
            'kecamatan'            => $this->faker->city,
            'kabupaten'            => $this->faker->city,
            'provinsi'             => $this->faker->state,
            'kodepos'              => $this->faker->postcode,
            'no_hp'                => $this->faker->phoneNumber,
            'email'                => $this->faker->unique()->email, // ✅ Ganti safeEmail -> email
            'foto'                 => null,
            'status'               => $this->faker->randomElement(['Aktif', 'Tidak Aktif']),
        ];
    }
}
