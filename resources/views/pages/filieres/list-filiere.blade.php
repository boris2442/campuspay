
@extends('layouts.admin.layout-admin')
@section('title', 'Liste des filieres')
@section('content')
<section class="bg-gray-50 dark:bg-gray-900 text-blue-500 dark:text-gray-200 min-h-screen flex justify-center p-4">
    <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 overflow-x-auto relative">
        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4 flex items-center gap-2">
            <i class="fa fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="bg-red-100 text-red-800 p-4 rounded-md mb-4 flex items-center gap-2">
            <i class="fa fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold flex items-center gap-2">
                <i class="fa fa-stream text-blue-600"></i>
                Liste des filières
            </h2>
            <a href="{{ url('admin/filieres/create') }}"
                class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition shadow">
                <i class="fa fa-plus"></i> Ajouter une filière
            </a>
        </div>

        <form method="GET" action="{{ route('filieres.index') }}"
            class="mb-6 flex flex-wrap items-center justify-between gap-4">
            <input type="text" name="name" placeholder="Rechercher une filière par nom..." value="{{ request('name') }}"
                class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 flex-grow max-w-md" />
            <div class="flex gap-3 flex-wrap">
                <button type="submit" class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition">
                    <i class="fa fa-search"></i> Recherche
                </button>
                <a href="{{ route('filieres.index') }}"
                    class="flex items-center gap-2 bg-gray-200 text-gray-700 px-5 py-2 rounded-md hover:bg-gray-300 transition">
                    <i class="fa fa-undo"></i> Réinitialiser
                </a>
                <a href="{{ route('filieres.exportPdf') }}"
                    class="flex items-center gap-2 bg-red-600 text-white px-5 py-2 rounded-md hover:bg-red-700 transition">
                    <i class="fa fa-file-pdf"></i> Exporter en PDF
                </a>
                <div class="flex items-center gap-2 bg-green-600 text-white px-5 py-2 rounded-md select-none" aria-label="Nombre total de filières">
                    <i class="fa fa-list"></i>
                    Total : {{ $filieres->total() }}
                </div>
            </div>
        </form>

        <form action="{{ route('filieres.import') }}" method="POST" enctype="multipart/form-data" class="mb-6 max-w-md">
            @csrf
            <label for="file" class="block mb-2 font-semibold">Sélectionnez un fichier Excel :</label>
            <input type="file" name="file" id="file"
                class="mb-3 w-full border border-gray-300 rounded-md p-2 bg-green-50 text-green-700" />
            @error('file')
            <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
            @enderror
            <button type="submit"
                class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-md hover:bg-blue-700 transition w-full">
                <i class="fa fa-upload"></i> Importer un document Excel
            </button>
        </form>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($filieres as $filiere)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col justify-between border border-blue-100 dark:border-gray-700 hover:shadow-xl transition">
                <div>
                    <h3 class="flex items-center gap-2 text-lg font-bold mb-2 text-blue-600">
                        <i class="fa fa-building-columns"></i>
                        {{ $filiere->name }}
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">
                        <i class="fa fa-info-circle text-blue-400"></i>
                        {{ $filiere->description }}
                    </p>
                </div>
                <div class="flex space-x-2 mt-2">
                    <a href="{{ route('filieres.edit', $filiere->id) }}" class="flex items-center gap-1 text-blue-600 hover:text-blue-900 px-2 py-1 rounded transition">
                        <i class="fa fa-pen"></i>
                    </a>
                    <form method="post" action="{{ route('filieres.delete', $filiere->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-white px-1 py-1 rounded-md shadow transition"
                            onclick="return confirm('Are you sure to delete this speciality?')">
                            <i class="fa fa-trash text-red-500 hover:text-red-600"></i>
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