<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AddUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => implode('', $this->faker->words(2)),
            'prenom' => implode("", $this->faker->words(2)),
            'photo' => 'images/default.jpg',
            'date_naissance' => $this->faker->date('Y-m-d'),
            'lieu_de_naissance' => $this->faker->words(5),
            'telephone' => $this->faker->phoneNumber(),
            'adresse' =>implode('',  $this->faker->sentences(4)),
            'filiere_id' => $this->faker->numberBetween(29, 32),
            'specialite_id' => $this->faker->numberBetween(7, 8),
            'niveau_id' => $this->faker->numberBetween(3, 5),
            'sexe' => $this->faker->randomElement(['Masculin', 'Feminin']),
            // 'password' => $this->faker->password_hash(),
        ];
    }
}
