@extends('layouts.admin.layout-admin')
@section('title', 'Liste des Étudiants')
@section('content')
<section class="p-4 bg-gray-50 dark:bg-gray-900 min-h-screen">
    <div class="w-full max-w-7xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 md:p-8">
        <h1
            class="text-2xl md:text-3xl font-bold mb-8 text-center text-blue-600 flex items-center justify-center gap-2">
            <i class="fa fa-users"></i> Liste des utilisateurs
        </h1>

        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4 flex items-center gap-2">
            <i class="fa fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif

        {{-- BLOC TOTAL + ACTIONS --}}
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center mb-6 gap-4">

            {{-- <div class="bg-green-500 text-white px-5 py-2 rounded-md flex items-center gap-2">
                <i class="fa fa-list"></i>
                @if($filtre === 'nom')
                Total pour ce nom : {{ $users->total() }}
                @elseif($filtre === 'sexe')
                Total pour ce sexe : {{ $users->total() }}
                @elseif($filtre === 'email')
                Total pour cet email : {{ $users->total() }}
                @elseif($filtre === 'annee_naissance')
                Total pour cette année : {{ $users->total() }}
                @else
                Total étudiants : {{ $totalEtudiants }}
                @endif
            </div> --}}
            {{-- <form method="GET" action="{{ route('users.index') }}" class="mb-4">
                <select name="role" onchange="this.form.submit()" class="form-select">
                    <option value="">-- Filtrer par rôle --</option>
                    <option value="user" {{ request('role')=='user' ? 'selected' : '' }}>Utilisateur</option>
                    <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Administrateur</option>
                    <option value="superadmin" {{ request('role')=='superadmin' ? 'selected' : '' }}>Super Admin
                    </option>
                </select>
            </form>
            --}}


            <form method="GET" action="{{ route('users.index') }}" class="flex items-center gap-3 mb-6">
                <label for="role" class="text-sm font-semibold">Filtrer par rôle :</label>
                <select name="role" id="role" onchange="this.form.submit()"
                    class="px-3 py-2 rounded-lg border border-gray-300 text-sm">
                    <option value="">Tous</option>
                    <option value="user" {{ request('role')=='user' ? 'selected' : '' }}>Utilisateur</option>
                    <option value="admin" {{ request('role')=='admin' ? 'selected' : '' }}>Administrateur</option>
                    <option value="comptable" {{ request('role')=='comptable' ? 'selected' : '' }}>Comptable
                    </option>
                </select>
            </form>


            {{-- <div class="flex flex-wrap gap-4">
                <a href="{{ route('users.create') }}"
                    class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition shadow">
                    <i class="fa fa-user-plus"></i> Ajouter un étudiant
                </a>
                <a href="{{ route('frais.exportPdfUser') }}"
                    class="flex items-center gap-2 bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition shadow">
                    <i class="fa fa-file-pdf"></i> Exporter PDF
                </a>
            </div> --}}
        </div>

        {{-- FORMULAIRE DE RECHERCHE --}}
        {{-- <form method="get" action="{{ route('users.index') }}"
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
                <a href="{{ route('users.index') }}"
                    class="flex items-center gap-2 bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                    <i class="fa fa-undo"></i> Réinitialiser
                </a>
            </div>
        </form> --}}

        {{-- IMPORT EXCEL --}}
        {{-- <form action="{{ route('etudiants.import') }}" method="POST" enctype="multipart/form-data"
            class="mb-6 bg-white dark:bg-gray-800 p-4 rounded-md shadow-sm flex flex-col sm:flex-row gap-4 items-center">
            @csrf
            <input type="file" name="file" required class="border px-3 py-2 rounded-md w-full max-w-sm" />
            <button type="submit"
                class="flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                <i class="fa fa-upload"></i> Importer
            </button>
        </form> --}}

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
                        <th class="px-4 py-3">Roles</th>
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
                    @foreach($users as $user)
                    <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-4 py-3">{{ $user->id }}</td>
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->role }}</td>
                        <td class="px-4 py-3">{{ $user->prenom }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->filiere->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $user->specialite->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $user->niveau->name ?? 'N/A' }}</td>
                        <td class="px-4 py-3">{{ $user->date_naissance }}</td>
                        <td class="px-4 py-3">{{ $user->lieu_de_naissance }}</td>
                        <td class="px-4 py-3">
                            <img src="{{ $user->photo ? asset('images/users/' . $user->photo) : asset('images/default.jpg') }}"
                                alt="Photo de {{ $user->name }}" class="w-10 h-10 rounded-full object-cover border">
                        </td>
                        <td class="px-4 py-3">{{ $user->adresse }}</td>
                        <td class="px-4 py-3">
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $user->sexe === 'Masculin' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                {{ $user->sexe }}
                            </span>
                        </td>
                        <td class="px-4 py-3">{{ $user->telephone }}</td>
                        {{-- <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800"
                                data-tippy-content="Éditer un apprenant" data-tippy-placement="top"
                                data-tippy-theme="light-border">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('users.delete', $user->id) }}" class="inline-block"
                                onsubmit="return confirm('Confirmer la suppression de cet étudiant ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-tippy-content="Supprimer l'étudiant"
                                    data-tippy-placement="top" data-tippy-theme="light-border">
                                    <i class="fa fa-trash text-red-600 hover:text-red-800"></i>
                                </button>
                            </form>
                        </td> --}}
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="px-4 py-3 border-t dark:border-gray-700">
                {{ $users->links() }}
            </div>
        </div>
    </div>
</section>
@endsection