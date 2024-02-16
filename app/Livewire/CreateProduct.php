<?php

namespace App\Livewire;

use App\Livewire\Forms\formUpdate;
use App\Models\Product;
use App\Models\Tag;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class CreateProduct extends Component
{
    use WithFileUploads;
    #[Validate(['image', 'nullable', 'max:2048'])]
    public $imagen;

    #[Validate(['required', 'string', 'min:3', 'unique:products,nombre'])]
    public string $titulo = "";
    #[Validate(['required', 'string', 'min:10'])]
    public string $descripcion = "";
    #[Validate(['required', 'integer', 'min:0'])]
    public int $stock;
    #[Validate(['required', 'decimal:0,2', 'min:0', 'max:9999.99'])]
    public float $pvp;
    #[Validate(['required', 'array', 'min:1', 'exists:tags,id'])]
    public array $tags=[];

    public bool $abrirModalCrear = false;

    

    public function render()
    {
        $misEtiquetas = Tag::select('id', 'nombre', 'color')->orderby('id')->get();
        return view('livewire.create-product', compact('misEtiquetas'));
    }

    public function store(){
        $this->validate();
        $product = Product::create([
            'nombre'=> $this->titulo,
            'descripcion'=> $this->descripcion,
            'stock'=> $this->stock,
            'pvp'=> $this->pvp,
            'imagen' => ($this->imagen) ? $this->imagen->store('productos') : 'default.jpg',
            'disponible'=> ($this->stock==0)? 'NO' : 'SI',
            'user_id'=> auth()->user()->id
        ]);
        $product->tags()->sync($this->tags);
        $this->dispatch('productoCreado')->to('show-products');
        $this->dispatch('mensaje', 'Producto creado con exito');
        $this->cancelarCrear();
    }
    public function cancelarCrear(){
        $this->reset(['abrirModalCrear', 'titulo', 'descripcion', 'imagen', 'pvp', 'stock', 'tags']);
    }
    
}
