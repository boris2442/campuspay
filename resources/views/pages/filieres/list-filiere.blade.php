@extends('layouts.admin.layout-admin')
@section('title', 'Liste des filieres')
@section('content')
<section class="bg-gray-50 dark:bg-gray-900 text-blue-500 dark:text-gray-200 min-h-screen flex  justify-center p-4 ">
    <div class="w-full  bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 overflow-x-auto relative">
        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-100 text-red-800 p-4 rounded-md mb-4">
            {{ session('error') }}
        </div>
        @endif


        <h2 class="text-3xl font-extrabold mb-6 text-center">Liste des filières</h2>

        <form method="GET" action="{{ route('filieres.index') }}"
            class="mb-6 flex flex-wrap items-center justify-between gap-4">

            <!-- Recherche -->
            <input type="text" name="name" placeholder="Rechercher une filière par nom..." value="{{ request('name') }}"
                class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 flex-grow max-w-md" />

            <!-- Boutons -->
            <div class="flex gap-3 flex-wrap">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
                    Recherche
                </button>

                <a href="{{ route('filieres.index') }}"
                    class="bg-gray-200 text-gray-700 px-5 py-2 rounded-md hover:bg-gray-300 transition">
                    Réinitialiser
                </a>

                <a href="{{ route('filieres.exportPdf') }}"
                    class="bg-red-600 text-white px-5 py-2 rounded-md hover:bg-red-700 transition">
                    📄 Exporter en PDF
                </a>

                <div class="bg-green-600 text-white px-5 py-2 rounded-md flex items-center select-none"
                    aria-label="Nombre total de filières">
                    Total : {{ $filieres->total() }}
                </div>
            </div>
        </form>

        <form action="{{ route('filieres.import') }}" method="POST" enctype="multipart/form-data" class="mb-6 max-w-md">
            @csrf
            <label for="file" class="block mb-2 font-semibold">Sélectionnez un fichier Excel :</label>
            <input type="file" name="file" id="file"
                class="mb-3 w-full border border-gray-300 rounded-md p-2 bg-green-500 text-white" />
            @error('file')
            <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @enderror
            <button type="submit"
                class="bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition w-full">
                Importer un document Excel
            </button>
        </form>

        <!-- Bouton Ajouter -->
        <div class="flex justify-end mb-6">
            <a href="{{ url('admin/filieres/create') }}"
                class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
                Ajouter une filière
            </a>
        </div>

        <!-- Message succès -->
        @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4 max-w-md mx-auto text-center">
            {{ session('success') }}
        </div>
        @endif




        <div class="
         grid
          {{-- grid-cols-1 md:grid-cols-2 lg:grid-cols-3 --}}
           gap-6">
            @foreach ($filieres as $filiere)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-bold mb-2 text-blue-600">{{ $filiere->name }}</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">

                        voir
                        plus...

                        {{ $filiere->description }}

                    </p>
                </div>
                <div class="flex space-x-2 mt-2">
                    <a href="{{ route('filieres.edit', $filiere->id) }}" class="text-blue-600 hover:text-blue-900"><i
                            class="fa fa-pen"></i>
                    </a>
                    <form method="post" action="{{ route('filieres.delete', $filiere->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class=" text-white px-1 py-1 rounded-md shadow  transition"
                            onclick="return confirm('Are you sure to delete this speciality?')"><i
                                class="fa fa-trash text-red-500 hover-text-red-600"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $filieres->links() }}
        </div>
    </div>
</section>
@endsection