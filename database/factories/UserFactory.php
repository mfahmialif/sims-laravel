<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition()
    {
        return [
            'username'          => $this->faker->unique()->userName,
            'name'              => $this->faker->name,
            'email'             => $this->faker->unique()->email,
            'role_id'           => 2, // default siswa
            'jenis_kelamin'     => $this->faker->randomElement(['Laki-Laki', 'Perempuan']),
            'email_verified_at' => now(),
            'avatar'            => null,
            'password'          => bcrypt('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    // State khusus untuk guru
    public function guru()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => 2,
            ];
        });
    }

    // State khusus untuk siswa
    public function siswa()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => 4,
            ];
        });
    }
}
