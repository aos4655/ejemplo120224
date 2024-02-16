<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Database\Factories\ProductFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = Product::factory(50)->create();
        foreach ($productos as $item) {
            $item->tags()->attach(self::obtenerEtiquetasRandom());
        }
    }

    //Lo suyo es llevarlo al modelo si lo usasemos mas
    private static function obtenerEtiquetasRandom() : array{
        $etiquetasDev = [];
        $etiquetasTodas = Tag::pluck('id')->toarray();
        $indices = array_rand($etiquetasTodas, random_int(2, count($etiquetasTodas)));
        foreach ($indices as $indice) {
            $etiquetasDev[] = $etiquetasTodas[$indice];
        }
        return $etiquetasDev;
    }
    
}
