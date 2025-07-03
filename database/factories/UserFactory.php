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
            'username' => $this->faker->unique()->userName,
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->email, // ✅ Ganti safeEmail -> email
            'role_id' => 2,
            'jenis_kelamin' => $this->faker->randomElement(['Laki-Laki', 'Perempuan']),
            'email_verified_at' => now(),
            'avatar' => null,
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }
}
