<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        fake()->addProvider(new \Mmo\Faker\PicsumProvider(fake()));
        $stock = random_int(0,50);
        //Esto es para que ponga alguno en no ya que en la bd salen todos si
        ($stock>0 && $stock<=10)? $stock = 0 : $stock;
        return [
            'nombre' => fake()->unique()->words(random_int(2,3), true),
            'descripcion' =>fake()->text(), 
            'imagen'=>'productos/'.fake()->picsum('public/storage/productos', 640, 480, false), 
            'pvp'=>fake()->randomFloat(2,1,9999.99), 
            'disponible' => ($stock>0)? 'SI': 'NO', 
            'stock' => $stock, 
            'user_id'=>User::all()->random()->id
        ];
    }
}
