@extends('layouts.admin.layout-admin')
@section('title', 'Ajouter les frais')
@section('content')

<section
  class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen flex items-center justify-center p-4">
  <div class="w-full max-w-3xl bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 relative">
     <a href="{{ route('frais.index') }}" class="absolute right-0 top-0 bg-red-400 text-white px-3 py-2 rounded hover:text-red-200">Back</a>
    <h2 class="text-2xl font-bold mb-6 text-center">Formulaire de Gestion des Frais</h2>

    <form action="{{ route('frais.store') }}" method="POST" class="space-y-6">
      @csrf

      <!-- Tranches et restes -->
      <div class="grid grid-cols-1  gap-6">
        <!-- Tranche 1 -->
        <div>
          <label for="tranche1" class="block text-sm font-medium mb-1">Tranche 1</label>
          <input type="number" step="0.01" id="tranche1" name="tranche1" placeholder="Montant de la tranche 1" required
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
            value="{{ old('tranche1') }}" />
          @error('tranche1')
          <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
          @enderror

        </div>
       
      </div>

      <div class="grid grid-cols-1  gap-6">
        <!-- Tranche 2 -->
        <div>
          <label for="tranche2" class="block text-sm font-medium mb-1">Tranche 2</label>
          <input type="number" step="0.01" id="tranche2" name="tranche2" placeholder="Montant de la tranche 2" required
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
            value="{{ old('tranche2') }}" />
          @error('tranche2')
          <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
          @enderror
        </div>
     
      </div>

      <div class="grid grid-cols-1  gap-6">

        <div>
          <label for="tranche3" class="block text-sm font-medium mb-1">Tranche 3</label>
          <input type="number" step="0.01" id="tranche3" name="tranche3" placeholder="Montant de la tranche 3" required
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
            value="{{ old('tranche3') }}" />
          @error('tranche3')
          <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
          @enderror
        </div>
   
      </div>

      <!-- Bouton soumettre -->
      <div class="pt-4">
        <button type="submit"
          class="w-full sm:w-auto px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-md shadow transition duration-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
          Enregistrer les frais
        </button>
      </div>
    </form>
  </div>
</section>
@endsection