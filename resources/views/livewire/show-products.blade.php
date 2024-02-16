<x-principal>
    <div class="flex w-full mb-1 items-center justify-center">
        <div class="w-3/4 flex-1">
            <x-input type="search" placeholder="Buscar..." wire:model.live="buscar" class="w-3/4"></x-input><i
                class="mr-1 fas fa-search"></i>
        </div>
        <div class="">
            @livewire('create-product')
        </div>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    INFO
                </th>
                <th scope="col" class="px-6 py-3 ">
                    IMAGEN
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('nombre')">
                    NOMBRE <i class="ml-1 fas fa-sort"></i>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('stock')">
                    STOCK <i class="ml-1 fas fa-sort"></i>
                </th>
                <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('disponible')">
                    DISPONIBLE <i class="ml-1 fas fa-sort"></i>
                </th>
                <th scope="col" class="px-6 py-3">
                    ACCIONES
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($productos as $item)
                <tr
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row"
                        class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <button wire:click="detalle({{ $item->id }})"><i
                                class="fas fa-info text-lg hover:text-2xl"></i></button>
                    </th>
                    <td class="px-6 py-4">
                        <img class="w-24 h-24 bg-center bg-cover" src="{{ Storage::url($item->imagen) }}"
                            alt="{{ $item->nombre }}">
                    </td>
                    <td class="px-6 py-4">
                        {{ $item->nombre }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <button wire:click= "bajarStock({{ $item->id }})"
                                class="inline-flex items-center justify-center p-1 me-3 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                type="button">
                                <span class="sr-only">Quantity button</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 18 2">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M1 1h16" />
                                </svg>
                            </button>
                            <div>
                                <p @class([
                                    'bg-gray-50 w-14 border border-gray-300
                                                                                                                                                                                                    text-sm rounded-lg focus:ring-blue-500
                                                                                                                                                                                                     focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700
                                                                                                                                                                dark:border-gray-600 dark:placeholder-gray-400',
                                    'text-red-500' => $item->stock < 10,
                                    'line-through font-bold' => $item->stock == 0,
                                    'text-green-500' => $item->stock >= 10,
                                ])>
                                    {{ $item->stock }}</p>
                            </div>
                            <button wire:click = 'subirStock({{ $item->id }})'
                                class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                type="button">
                                <span class="sr-only">Quantity button</span>
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 18 18">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M9 1v16M1 9h16" />
                                </svg>
                            </button>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div @class([
                                'h-2.5 w-2.5 rounded-full me-2',
                                'bg-green-500' => $item->disponible == 'SI',
                                'bg-red-500' => $item->disponible == 'NO',
                            ])></div> {{ $item->disponible }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <button>
                            <i class="fas fa-edit mr-3 hover:text-4xl" wire:click="edit({{ $item->id }})"></i>
                        </button>
                        <button>
                            <i class="fas fa-trash text-red-500 hover:text-4xl"
                                wire:click="confirmarBorrar({{ $item->id }})"></i>
                        </button>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>
    <div class="mt-1">
        {{ $productos->links() }}
    </div>
    <!-- MODAL PARA EL UPDATE -->
    @isset($form->product)
        <x-dialog-modal wire:model="abrirModalUpdate">
            <x-slot name="title">
                Editar Producto
            </x-slot>
            <x-slot name="content">
                <x-label for="nombre">Nombre</x-label>
                <x-input id="nombre" placeholder="Nombre..." class="w-full" wire:model="form.titulo"></x-input>
                <x-input-error for="form.titulo"></x-input-error>

                <x-label for="descripcion">Descripcion</x-label>
                <textarea id="descripcion" placeholder="Descripcion..." class="w-full" wire:model="form.descripcion"></textarea>
                <x-input-error for="form.descripcion"></x-input-error>

                <x-label for="stock" class="mt-4">Stock</x-label>
                <x-input id="stock" type="number" placeholder="Stock..." class="w-full" step="1" min="0"
                    wire:model="form.stock"></x-input>
                <x-input-error for="form.stock"></x-input-error>


                <x-label for="pvp" class="mt-4">PVP</x-label>
                <x-input id="pvp" type="number" placeholder="Pvp..." class="w-full" step="0.01"
                    min="0" max="9999.99" wire:model="form.pvp"></x-input>
                <x-input-error for="form.pvp"></x-input-error>

                <x-label for="etiquetas" class="mt-4">Etiquetas</x-label>
                <div class="flex">
                    @foreach ($misTags as $item)
                        <div class="flex items-center me-4 flex-wrap">
                            <!-- El wrap es para quie salte de linea y no se desborde  -->
                            <input id="{{ $item->id }}" wire:model="form.tags" type="checkbox"
                                value="{{ $item->id }}"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="{{ $item->id }}"
                                class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 p-2 rounded-xl"
                                style="background-color: {{ $item->color }}">{{ $item->nombre }}</label>
                        </div>
                    @endforeach
                </div>
                <x-input-error for="form.tags"></x-input-error>


                <x-label for="imagenU" class="mt-4">Imagen</x-label>
                <div class="relative w-full h-72 bg-gray-200">
                    @if ($form->imagen)
                        <img src="{{ $form->imagen->temporaryUrl() }}"
                            class="p-1 rounded w-full h-full bg-no-repeat bg-cover bg-center" alt="Imagen subida">
                    @else
                        <img src="{{ Storage::url($form->product->imagen) }}"
                            class="p-1 rounded w-full h-full bg-no-repeat bg-cover bg-center" alt="Imagen subida">
                    @endif
                    <input type="file" wire:model="form.imagen" accept="image/*" hidden id="imagenU">
                    <label for="imagenU"
                        class="absolute bottom-2 end-2 bg-gray-700 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded">
                        <i class="fa-solid fa-upload"></i>Subir</label>
                </div>
                <x-input-error for="form.imagen"></x-input-error>


            </x-slot>
            <x-slot name="footer">
                <div class="flex flex-row-reverse">
                    <button wire:click="actualizar()" wire:loading.attr="disabled"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-edit"></i> EDITAR
                    </button>

                    <button wire:click="cancelarUpdate"
                        class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-xmark"></i> CANCELAR
                    </button>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endisset
    <!-- MODAL PARA EL DETALLE -->
    @isset($producto)
        <x-dialog-modal wire:model="abrirModalShow">
            <x-slot name="title">
                Detalle Producto
            </x-slot>
            <x-slot name="content">
                <div
                    class="w-full mx-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                    <img class="rounded-lg bg-cover bg-no-repeat bg-center w-full"
                        src="{{ Storage::url($producto->imagen) }}" alt="{{ $producto->nombre }}" />
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            {{ $producto->nombre }}</h5>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ $producto->descripcion }}</p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            <span>STOCK: </span>{{ $producto->stock }}
                        </p>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                            <span>DISPONIBLE: </span><span @class([
                                'text-green-500' => $producto->disponible == 'SI',
                                'text-red-500 line-through' => $producto->disponible == 'NO',
                            ])>{{ $producto->disponible }} </span>
                        </p>
                        <div class="flex flex-wrap mt-4">
                            @foreach ($producto->tags as $item)
                                <div class="p-1 rounded-lg mr-1" style="background-color: {{ $item->color }}">
                                    {{ $item->nombre }}</div>
                            @endforeach
                        </div>

                    </div>
                </div>

            </x-slot>
            <x-slot name="footer">
                <button wire:click="cerrarDetalle"
                    class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-xmark"></i> CANCELAR
                </button>
            </x-slot>
        </x-dialog-modal>
    @endisset
</x-principal>
