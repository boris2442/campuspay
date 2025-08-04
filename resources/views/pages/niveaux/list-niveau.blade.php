{{-- filepath: c:\laragon\www\campuspay\resources\views\pages\niveaux\list-niveau.blade.php --}}
@extends('layouts.admin.layout-admin')
@section('title', 'Liste des niveaux')
@section('content')

<section class="py-8 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="w-full max-w-5xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 relative">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <h2 class="text-2xl font-bold flex items-center gap-2 text-blue-700">
                <i class="fa fa-layer-group"></i>
                Liste des niveaux
            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('niveaux.create') }}"
                    class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition shadow">
                    <i class="fa fa-plus"></i> Ajouter un niveau
                </a>
                <a href="{{ route('niveaux.exportPdf') }}"
                    class="flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition shadow">
                    <i class="fa fa-file-pdf"></i> Exporter PDF
                </a>
            </div>
        </div>

        <form action="{{ route('niveaux.import') }}" method="POST" enctype="multipart/form-data" class="mb-6 flex flex-col sm:flex-row gap-4 items-center">
            @csrf
            <input type="file" name="file" required class="border p-2 rounded-md flex-1 bg-green-50 text-green-700" />
            <button type="submit" class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                <i class="fa fa-upload"></i> Importer
            </button>
        </form>

        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4 flex items-center gap-2">
            <i class="fa fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-200 dark:bg-gray-700 text-blue-600 dark:text-gray-300">
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3 text-left">Nom</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($niveaux as $niveau)
                    <tr class="border-b dark:border-gray-600 odd:bg-gray-100 even:bg-white dark:odd:bg-gray-700 dark:even:bg-gray-800 hover:bg-blue-50 dark:hover:bg-gray-600 transition-colors">
                        <td class="px-6 py-4">{{ $niveau->id }}</td>
                        <td class="px-6 py-4">{{ $niveau->name }}</td>
                        <td class="px-6 py-4 flex gap-2">
                            <a href="{{ route('niveaux.edit', $niveau->id) }}"
                                class="flex items-center gap-1 text-blue-600 hover:text-blue-900 px-2 py-1 rounded transition">
                                <i class="fa fa-pen"></i>
                            </a>
                            <form action="{{ route('niveaux.delete', $niveau->id) }}" method="POST"
                                onsubmit="return confirm('Supprimer ce niveau ?')">
                                @csrf
                                @method('DELETE')
                                <button class="flex items-center gap-1 text-red-600 hover:text-red-800 px-2 py-1 rounded transition">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-6 text-gray-500">Aucun niveau enregistré.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $niveaux->links() }}
        </div>
    </div>
</section>
@endsection