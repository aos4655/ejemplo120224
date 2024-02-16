<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $etiquetas = [
            'Infantil' => '#FFD1DC',          // Rosa pastel
            'Multimedia' => '#FFB6C1',         // Rosa claro
            'Digital' => '#FFA07A',           // Salmón claro
            'Mecanico' => '#ADD8E6', // Azul claro
            'Hardware' => '#B0E0E6',       // Azul cielo
            'Suspenso' => '#98FB98',        // Verde claro
            'Romance' => '#FFC0CB'          // Rosa pastel
        ];
        foreach ($etiquetas as $nombre => $color) {
            Tag::create(compact('nombre', 'color'));
        }
    }
}
