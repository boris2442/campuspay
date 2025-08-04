@extends('layouts.admin.layout-admin')
@section('title', 'Liste des Étudiants')
@section('content')
<section class="p-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="w-full max-w-7xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8">
        <h1
            class="text-2xl md:text-3xl font-bold mb-8 text-center text-blue-600 flex items-center justify-center gap-2">
            <i class="fa fa-students"></i> Liste des etudiants
        </h1>

        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4 flex items-center gap-2">
            <i class="fa fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        {{-- BLOC TOTAL + ACTIONS --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">

            <div class="bg-green-500 text-white px-5 py-2 rounded-md flex items-center gap-2">
                <i class="fa fa-list"></i>
                @if($filtre === 'nom')
                Total pour ce nom : {{ $students->total() }}
                @elseif($filtre === 'sexe')
                Total pour ce sexe : {{ $students->total() }}
                @elseif($filtre === 'email')
                Total pour cet email : {{ $students->total() }}
                @elseif($filtre === 'annee_naissance')
                Total pour cette année : {{ $students->total() }}
                @else
                Total étudiants : {{ $totalEtudiants }}
                @endif
            </div>


            {{-- <div class="flex flex-wrap gap-4"> --}}
                {{-- <a href="{{ route('students.create') }}"
                    class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition shadow">
                    <i class="fa fa-student-plus"></i> Ajouter un étudiant
                </a> --}}

                <a href="{{ route('frais.exportPdfUser') }}"
                    class="flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition shadow">
                    <i class="fa fa-file-pdf"></i> Exporter PDF
                </a>

                {{--
            </div> --}}
        </div>

        {{-- FORMULAIRE DE RECHERCHE --}}
        <form method="get" action="{{ route('students.index') }}"
            class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-sm mb-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <input type="text" name="name" placeholder="Rechercher par nom" value="{{ request('name') }}"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 w-full" />
                <input type="text" name="email" placeholder="Rechercher par Email" value="{{ request('email') }}"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 w-full" />
                <select name="sexe"
                    class="border border-gray-300 rounded-md px-3 py-2 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400 w-full">
                    <option value="">Filtrer les étudiants par sexe</option>
                    <option value="Masculin" {{ request('sexe')=='Masculin' ? 'selected' : '' }}>Masculin</option>
                    <option value="Feminin" {{ request('sexe')=='Feminin' ? 'selected' : '' }}>Feminin</option>
                </select>
                <input type="text" name="annee_naissance" placeholder="Année de naissance (ex: 2002)"
                    value="{{ request('annee_naissance') }}"
                    class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 w-full" />
            </div>
            <div class="flex flex-wrap items-center gap-4 mt-4">
                <button type="submit"
                    class="flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                    <i class="fa fa-search"></i> Recherche
                </button>
                <a href="{{ route('students.index') }}"
                    class="flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                    <i class="fa fa-undo"></i> Réinitialiser
                </a>
            </div>
        </form>

        {{-- IMPORT EXCEL --}}
        <form action="{{ route('etudiants.import') }}" method="POST" enctype="multipart/form-data"
            class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-md shadow-sm flex flex-col sm:flex-row gap-4 items-center">
            @csrf
            <input type="file" name="file" required class="border px-3 py-2 rounded-md w-full max-w-sm" />
            <button type="submit"
                class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                <i class="fa fa-upload"></i> Importer
            </button>
        </form>

        @error('file')
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4 shadow-sm">
            {{ $message }}
        </div>
        @enderror

        @if(session('failures'))
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4 shadow-sm">
            <strong>Erreurs lors de l'import :</strong>
            <ul class="mt-2 list-disc list-inside">
                @foreach (session('failures') as $failure)
                <li>Ligne {{ $failure->row() }} : {{ implode(', ', $failure->errors()) }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow mb-6">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-left">
                <thead
                    class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Nom</th>
                        {{-- <th class="px-4 py-3">Roles</th> --}}
                        <th class="px-4 py-3">Prénom</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Filière</th>
                        <th class="px-4 py-3">Spécialité</th>
                        <th class="px-4 py-3">Niveau</th>
                        <th class="px-4 py-3">Naissance</th>
                        <th class="px-4 py-3">Lieu</th>
                        <th class="px-4 py-3">Photo</th>
                        <th class="px-4 py-3">Adresse</th>
                        <th class="px-4 py-3">Sexe</th>
                        <th class="px-4 py-3">Téléphone</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($students as $student)
                    <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-4 py-3">{{ $student->id }}</td>
                        <td class="px-4 py-3">{{ $student->name }}</td>
                        {{-- <td class="px-4 py-3">{{ $student->role }}</td> --}}
                        <td class="px-4 py-3">{{ $student->prenom }}</td>
                        <td class="px-4 py-3">{{ $student->email }}</td>
                        <td class="px-4 py-3">{{ $student->filiere->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $student->specialite->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $student->niveau->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $student->date_naissance }}</td>
                        <td class="px-4 py-3">{{ $student->lieu_de_naissance }}</td>
                        <td class="px-4 py-3">
                            <img src="{{ $student->photo ? asset('images/students/' . $student->photo) : asset('images/default.jpg') }}"
                                {{--
                                src="{{ $student->photo ? asset('storage/' . $student->photo) : asset('images/default.jpg') }}"
                                --}} alt="Photo de {{ $student->name }}"
                                class="w-10 h-10 rounded-full object-cover border">
                        </td>
                        <td class="px-4 py-3">{{ $student->adresse }}</td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $student->sexe === 'Masculin' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                {{ $student->sexe }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $student->telephone }}</td>
                        @auth()
                        @if(auth()->user()->role==='admin' )
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('students.edit', $student->id) }}"
                                class="text-blue-600 hover:text-blue-800" data-tippy-content="Éditer un apprenant"
                                data-tippy-placement="top" data-tippy-theme="light-border">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('students.delete', $student->id) }}"
                                class="inline-block"
                                onsubmit="return confirm('Confirmer la suppression de cet étudiant ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-tippy-content="Supprimer l'étudiant"
                                    data-tippy-placement="top" data-tippy-theme="light-border">
                                    <i class="fa fa-trash text-red-600 hover:text-red-800"></i>
                                </button>
                            </form>
                        </td>
                        @endif
                        @endauth
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-4 py-3 border-t dark:border-gray-700">
                {{ $students->links() }}
            </div>
        </div>
    </div>
</section>
@endsection