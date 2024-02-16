<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Product;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;

class formUpdate extends Form
{
    public $imagen;

    public string $titulo = "";
    public string $descripcion = "";
    public int $stock = 0;
    public float $pvp= 0;
    public array $tags=[];

    public ?Product $product = null;

    public function rules():array{
        return[
            'titulo' => ['required', 'string', 'min:3', 'unique:products,nombre,'.$this->product->id],
            'descripcion' => ['required', 'string', 'min:10'],
            'stock'=> ['required', 'integer', 'min:0'],
            'pvp'=> ['required', 'decimal:0,2', 'min:0', 'max:9999.99'],
            'tags'=>['required', 'array', 'min:1', 'exists:tags,id'],
            'imagen' =>['image', 'nullable', 'max:2048']
        ];
    }
    public function setProducto(Product $producto){
        $this->product = $producto;
        $this->titulo = $producto->nombre;
        $this->descripcion = $producto->descripcion;
        $this->stock = $producto->stock;
        $this->pvp = $producto->pvp;
        $this->tags = $producto->obtenerTagsId();
    }
    public function actualizar(){
        $ruta =  $this->product->imagen;
        if ($this->imagen) {
            if (basename($this->product->imagen) != 'default.jpg') {
                Storage::delete($this->product->imagen);
            }
            $ruta = $this->imagen->store('productos');
        }
        $this->product->update([
            'nombre'=>$this->titulo,
            'descripcion'=>$this->descripcion,
            'stock'=>$this->stock,
            'pvp'=>$this->pvp,
            'imagen'=> $ruta,
            'disponible' => ($this->stock==0)?'NO':'SI',
            'user_id' => auth()->user()->id
        ]);
        $this->product->tags()->sync($this->tags);
    }
    public function cancelarActualizar(){
        $this->reset(['titulo', 'descripcion', 'imagen', 'pvp', 'stock']);
    }
}
