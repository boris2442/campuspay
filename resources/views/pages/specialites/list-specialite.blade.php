@extends('layouts.admin.layout-admin')
@section('title', 'Liste des Spécialités')
@section('content')
<section
    class="bg-gray-50 dark:bg-gray-900 text-blue-500 dark:text-gray-200 min-h-screen flex items-center justify-center p-4">
    <div class="w-full  bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8 overflow-x-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">Liste des Spécialités</h2>

        <form method="get" class="mb-6 flex justify-between items-center" action="{{ route('specialites.index') }}">

            <div class="flex flex-wrap items-center gap-4 my-4">

                {{-- Filtrer par nom --}}
                <input type="text" name="name" placeholder="Rechercher une specialite par nom..."
                    value="{{ request('name') }}"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 w-full md:w-64" />
                {{-- Bouton recherche --}}
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                    Recherche
                </button>

                {{-- Bouton réinitialiser --}}
                <a href="{{ route('specialites.index') }}"
                    class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition ml-2">
                    Réinitialiser
                </a>
                <div class="bg-[#22c55e] text-white px-4 py-2 rounded-md hover:bg-green-600 transition">

                    Total Specialités :
                    {{$specialites->count()}}

                </div>
                <a href="{{ route('specialites.exportSpecialitePdf') }}"
                    class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition">
                    📄 Exporter en PDF
                </a>
                <div class="flex flex-col">
                    <form action="{{ route('specialites.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="file" required
                            class="block w-full mb-4 bg-green-500 p-1 rounded text-white" />
                        @error('file')
                        <p class="text-red-500 text-sm mb-2">{{ $message }}</p>
                        @enderror
                        <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Importer les specialites
                        </button>
                    </form>
                </div>


            </div>
        </form>

        <div class="mb-4">
            <a href="{{ route('specialites.create') }}"
                class="bg-[#22c55e] text-white px-4 py-2 rounded-md hover:bg-green-600 transition">Ajouter une
                specialite</a>
        </div>

        @if (session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4">
            {{ session('success') }}
        </div>
        @endif



        <div class="grid
         {{-- grid-cols-1 md:grid-cols-2 lg:grid-cols-3 --}}
          gap-6">
            @foreach ($specialites as $specialite)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 flex flex-col justify-between">
                <div>
                    <h3 class=" font-bold mb-2 text-blue-600 text-2xl">Filiere: {{ $specialite->filiere ?
                        $specialite->filiere->name : 'Non défini' }}</h3>
                    <h3 class="text-lg font-bold mb-2 text-blue-600">{{ $specialite->name }}</h3>
                    <p class="text-gray-700 dark:text-gray-300 mb-4">

                        {{ $specialite->description }}

                    </p>
                </div>
                <div class="flex space-x-2 mt-2">
                    <a href="{{ route('specialites.edit', $specialite->id) }}"
                        class="text-blue-600 hover:text-blue-900"><i class="fa fa-pen"></i></a>
                    <form method="post" action="{{ route('specialites.delete', $specialite->id) }}">
                        @csrf
                        @method('DELETE')
                        <button class=" text-white px-4 py-2 rounded-md shadow  transition"
                            onclick="return confirm('Are you sure to delete this speciality?')"><i
                                class="fa fa-trash text-red-600"></i>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{ $specialites->links() }}
        </div>
    </div>
</section>
@endsection