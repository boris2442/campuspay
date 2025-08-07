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
            <div class="flex items-center gap-4">
                <span class="text-lg font-semibold text-gray-800 dark:text-gray-200">Total Utilisateurs :
                    <span class="text-blue-600">{{ $users->total() }}</span>
                </span>
            </div>

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
        </div>
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
                        <th class="px-4 py-3">Prénom</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Roles</th>



                        <th class="px-4 py-3">Téléphone</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($users as $user)
                    <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <td class="px-4 py-3">{{ $user->id }}</td>
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->prenom }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->role }}</td>
                        <td class="px-4 py-3">{{ $user->telephone }}</td>
                        <td class="px-4 py-3 space-x-2">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:text-blue-800"
                                data-tippy-content="Éditer un apprenant" data-tippy-placement="top"
                                data-tippy-theme="light-border">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="inline-block"
                                onsubmit="return confirm('Confirmer la suppression de cet étudiant ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" data-tippy-content="Supprimer l'étudiant"
                                    data-tippy-placement="top" data-tippy-theme="light-border">
                                    <i class="fa fa-trash text-red-600 hover:text-red-800"></i>
                                </button>
                            </form>
                        </td>
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