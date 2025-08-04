@extends('layouts.admin.layout-admin')
@section('title', 'Ajouter un niveau')
@section('content')
<section
    class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-3xl bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 relative">
        <h2 class="text-2xl font-bold mb-6 text-center text-blue-500">Formulaire de Gestion des Niveaux</h2>
        <a href="{{ route('niveaux.index') }}"
            class="absolute right-0 top-0 bg-red-400 text-white px-3 py-2 rounded hover:text-red-200">Back</a>
        <form action="{{ route('niveaux.store') }}" method="POST" class="space-y-6">
            @csrf
            <!-- Nom du niveau -->
            <div>
                <label for="name" class="block text-sm font-medium mb-1">Nom du niveau</label>
                <input type="text" id="name" name="name" placeholder="Ex : Licence 1" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                    value="{{ old('name') }}" />
                @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <!-- Sélection de la spécialité -->
            <div>
                <label for="specialite_id" class="block text-sm font-medium mb-1">Spécialité associée</label>
                <select id="specialite_id" name="specialite_id" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="">-- Choisir une spécialité --</option>
                    @foreach($specialites as $specialite)
                    <option value="{{ $specialite->id }}" {{ old('specialite_id')==$specialite->id ? 'selected' : '' }}>
                        {{ $specialite->name }}
                    </option>
                    @endforeach
                </select>
                @error('specialite_id')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>




            <!-- Bouton soumettre -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Enregistrer le niveau
                </button>
            </div>
        </form>
    </div>
</section>
@endsection