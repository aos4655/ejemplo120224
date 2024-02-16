<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Livewire\Forms\formUpdate;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class ShowProducts extends Component
{
    use WithPagination;
    use WithFileUploads;
    public string $orden = 'desc';
    public string $campo = 'id';

    public bool $abrirModalShow = false;
    public ?Product $producto=null;

    public string $buscar="";
    public bool $abrirModalUpdate = false;
    public formUpdate $form;

    #[On('productoCreado')]
    public function render()
    {
        $productos = Product::where('user_id', auth()->user()->id)
        ->where(function($q){ //Esto es funcion anonima para que solo sean los disponibles del usuario
            $q->where('nombre','like', '%'.$this->buscar.'%')
            ->orwhere('disponible','like', '%'.$this->buscar.'%');
        })
        ->orderby($this->campo, $this->orden)
        ->paginate(5);
        $misTags = Tag::select('id', 'nombre', 'color')->orderby('id')->get();
        return view('livewire.show-products', compact('productos', 'misTags'));
    }
    public function subirStock(Product $producto)
    {
        $nuevoStock = $producto->stock + 1;
        $producto->update([
            'stock' => $nuevoStock,
            'disponible'=> ($nuevoStock>0)? 'SI' : 'NO'
        ]);
    }
    public function updatingBuscar(){
        $this->resetPage();
    }
    public function bajarStock(Product $producto)
    {
        if ($producto->stock > 0) {
            $nuevoStock = $producto->stock - 1;
            $producto->update([
                'stock' => $nuevoStock,
                'disponible'=> ($nuevoStock>0)? 'SI' : 'NO'
            ]);
        }
        else{

        }
    }
    public function ordenar(string $campo){
        $this->orden = ($this->orden=='desc')? 'asc' : 'desc';
        $this->campo = $campo;
    }
    //BORRAR
    public function confirmarBorrar(Product $producto){
        $this->authorize('delete', $producto);
        $this->dispatch('confirmarBorrar', $producto->id);
    }
    #[On('borrarOk')]
    public function borrar(Product $product){
        if (basename($product->imagen) != 'default.jpg') {
            Storage::delete($product->imagen);
        }
        $product->delete();
        $this->dispatch('mensaje', 'Pelicula Borrada');
    }
    public function edit(Product $producto){
        $this->authorize('update', $producto);
        $this->form->setProducto($producto);
        $this->abrirModalUpdate = true;
    }
    public function cancelarUpdate(){
        $this->form->cancelarActualizar();
        $this->abrirModalUpdate = false;
    }
    public function actualizar(){
        $this->form->actualizar();
        $this->cancelarUpdate();
        $this->dispatch('mensaje', 'Pelicula actualizada');
    }
    /* FUNCION PARA DETALLE */
    public function detalle(Product $producto){
        $this->producto = $producto;
        $this->abrirModalShow=true;
    }
    public function cerrarDetalle(){
        $this->reset(['producto', 'abrirModalShow']);
    }
}
