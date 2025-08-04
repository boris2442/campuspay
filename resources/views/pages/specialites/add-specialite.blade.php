@extends('layouts.admin.layout-admin')
@section('title', 'Ajouter une Spécialité')

@section('content')
<section
    class="bg-gray-50 dark:bg-gray-900 text-blue-500 dark:text-gray-200 min-h-screen flex items-center justify-center p-4">


    <div class="w-full max-w-2xl bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 relative">
        <a href="{{ route('specialites.index') }}"
            class="absolute right-0 top-0 bg-red-400 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">Retour</a>
        <h2 class="text-2xl font-bold mb-6 text-center">Ajouter une spécialité</h2>

        <form action="{{ route('specialites.store') }}" method="POST" class="space-y-6 ">

            @csrf

            <!-- Message succès -->
            @if (session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-md">
                {{ session('success') }}
            </div>
            @endif

            <!-- Message erreur -->
            @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-- Filière -->
            <div>
                <label for="filiere_id" class="block text-sm font-medium mb-1">Filière</label>
                <select name="filiere_id" id="filiere_id" required
                    data-url="{{ route('specialites.byFiliere', ':id') }}"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                    <option value="">-- Sélectionnez une filière --</option>
                    @foreach($filieres as $filiere)
                    <option value="{{ $filiere->id }}" {{ old('filiere_id')==$filiere->id ? 'selected' : '' }}>
                        {{ $filiere->name }}
                    </option>
                    @endforeach
                </select>
                @error('filiere_id')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Nom -->
            <div>
                <label for="name" class="block text-sm font-medium mb-1">Nom de la spécialité</label>
                <input type="text" id="name" name="name" placeholder="Ex: Génie logiciel" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                    value="{{old('name') }}" />
                @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium mb-1">Description</label>
                <textarea id="description" name="description" rows="3" placeholder="Brève description" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">{{old('description')}}</textarea>
                @error('description')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

           
            <!-- Bouton -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</section>
<script>
    document.getElementById('filiere_id').addEventListener('change', function () {
        const filiereId = this.value;
        const urlTemplate = this.getAttribute('data-url');
        const url = urlTemplate.replace(':id', filiereId);
        const specialiteSelect = document.getElementById('specialite_id');

        // Vider les options actuelles
        specialiteSelect.innerHTML = '<option value="">-- Sélectionnez une spécialité --</option>';

        if (filiereId) {
            fetch(url)
                .then(response => response.json())
                .then(data => {
                    data.forEach(specialite => {
                        const option = document.createElement('option');
                        option.value = specialite.id;
                        option.text = specialite.name;
                        specialiteSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Erreur lors du chargement des spécialités:', error);
                });
        }
    });
</script>

@endsection