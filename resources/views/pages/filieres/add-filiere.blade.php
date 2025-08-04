@extends('layouts.admin.layout-admin')
@section('title', 'Ajouter une filiere')
@section('content')
<section class="flex justify-center items-center h-[100vh]">
    <div class="w-full max-w-3xl bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 relative">
        <a href="{{ route('filieres.index') }}"
            class="absolute right-0 top-0 bg-red-400 text-white px-3 py-2 rounded hover:text-red-200">Back</a>
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-500">Formulaire de Gestion des Filières</h2>

        <form action="{{ route('filieres.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nom de la filière -->
            <div>
                <label for="name" class="block text-sm font-medium mb-1">Nom de la filière</label>
                <input type="text" id="nom" name="name" placeholder="Ex : Informatique" required
                    class="w-full px-4 py-2 border  border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                    value="{{ old('name') }}" />
                @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description de la filière -->
            <div>
                <label for="description" class="block text-sm font-medium mb-1">Description</label>
                <textarea id="description" name="description" rows="4" placeholder="Décrivez la filière ici..." required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white resize-none">{{ old('description') }}  </textarea>
                @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Matricule de la filière -->
            {{-- <div>
                <label for="matricule_filiere" class="block text-sm font-medium mb-1">Matricule de la filière</label>
                <input type="text" id="matricule_filiere" name="matricule_filiere" placeholder="Ex : INF-01" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" />
            </div> --}}




            <!-- Bouton soumettre -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Enregistrer la filière
                </button>
            </div>
        </form>
    </div>
</section>
@endsection