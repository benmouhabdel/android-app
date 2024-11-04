<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'), // vous pouvez personnaliser le mot de passe ici
            'phone' => $this->faker->phoneNumber(),
            'role' => $this->faker->randomElement(['user', 'admin']),
            'registration_key' => Str::random(10),
            'annee' => $this->faker->randomElement([1, 2, 3, 4, 5]), // Génération aléatoire de 'annee'
            'classe' => $this->faker->word(), // Vous pouvez personnaliser la génération de 'classe'
            'filiere' => $this->faker->randomElement(['IAM', 'Ingénierie', 'RH', 'Management', 'Finance', 'Marketing']), // Génération aléatoire de 'filiere'
            'image_url' => $this->faker->imageUrl(),
            'remember_token' => Str::random(10),
                ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
