{{-- filepath: c:\laragon\www\campuspay\resources\views\pages\specialites\list-specialite.blade.php --}}
@extends('layouts.admin.layout-admin')
@section('title', 'Liste des Spécialités')
@section('content')
<section class="bg-gray-50 dark:bg-gray-900 text-blue-500 dark:text-gray-200 min-h-screen flex items-center justify-center p-4">
    <div class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 overflow-x-auto">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            <h2 class="text-2xl font-bold flex items-center gap-2">
                <i class="fa fa-layer-group text-blue-600"></i>
                Specialities List
            </h2>
            <a href="{{ route('specialites.create') }}"
                class="flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition shadow">
                <i class="fa fa-plus"></i> Add Speciality
            </a>
        </div>

        <form method="get" class="mb-6 flex flex-col md:flex-row md:items-center gap-4" action="{{ route('specialites.index') }}">
            <input type="text" name="name" placeholder="Search by name..."
                value="{{ request('name') }}"
                class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 w-full md:w-64" />
            <button type="submit" class="flex items-center gap-2 bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                <i class="fa fa-search"></i> Search
            </button>
            <a href="{{ route('specialites.index') }}"
                class="flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                <i class="fa fa-undo"></i> Reset
            </a>
            <a href="{{ route('specialites.exportSpecialitePdf') }}"
                class="flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                <i class="fa fa-file-pdf"></i> Export PDF
            </a>
            <div class="flex items-center gap-2 bg-green-100 text-green-800 px-4 py-2 rounded-md">
                <i class="fa fa-list"></i>
                <span>Total: {{$specialites->count()}}</span>
            </div>
        </form>

        <div class="mb-6">
            <form action="{{ route('specialites.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-2 items-center">
                @csrf
                <input type="file" name="file" required class="block w-full bg-green-50 p-1 rounded text-green-700 border border-green-300" />
                @error('file')
                <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                @enderror
                <button type="submit" class="flex items-center gap-2 bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                    <i class="fa fa-upload"></i> Import
                </button>
            </form>
        </div>

        @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4 flex items-center gap-2">
            <i class="fa fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($specialites as $specialite)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col justify-between border border-blue-100 dark:border-gray-700 hover:shadow-xl transition">
                <div>
                    <h3 class="flex items-center gap-2 font-bold mb-2 text-blue-600 text-xl">
                        <i class="fa fa-graduation-cap"></i>
                        {{ $specialite->name }}
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fa fa-stream text-blue-400"></i>
                        <span class="font-semibold">Filière :</span>
                        {{ $specialite->filiere ? $specialite->filiere->name : 'Non défini' }}
                    </p>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        <i class="fa fa-info-circle text-blue-400"></i>
                        {{ $specialite->description }}
                    </p>
                </div>
                <div class="flex space-x-2 mt-2">
                    <a href="{{ route('specialites.edit', $specialite->id) }}"
                        class="flex items-center gap-1 text-blue-600 hover:text-blue-900 px-2 py-1 rounded transition">
                        <i class="fa fa-pen"></i> Edit
                    </a>
                    <form method="post" action="{{ route('specialites.delete', $specialite->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class="flex items-center gap-1 text-red-600 hover:text-red-800 px-2 py-1 rounded transition"
                            onclick="return confirm('Are you sure to delete this speciality?')">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $specialites->links() }}
        </div>
    </div>
</section>
@endsection