@extends('layouts.admin.layout-admin')
@section('title', 'hstorique global des paiements')
@section('content')
<div class="max-w-6xl mx-auto mt-10 p-6 bg-white relative shadow-lg rounded-lg">
    <h2 class="text-3xl font-bold text-blue-700 mb-6">Historique des paiements - Tous les apprenants</h2>
    <a href="{{ url('/admin/paiements/create') }}"
        class="absolute right-0 top-0 bg-green-400 text-white p-1 rounded hover:text-green-200">Add paiement</a>
    <!-- Formulaire de filtrage -->
    <form method="GET" action="{{ route('paiements.index') }}"
        class="mb-6 flex flex-wrap gap-4 items-center bg-white p-4 rounded shadow-sm border border-gray-200">
        {{-- <input type="date" name="date_debut" value="{{ request('date_debut') }}"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Date début" />

        <input type="date" name="date_fin" value="{{ request('date_fin') }}"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Date fin" />
        --}}
        <select name="specialite_id"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 min-w-[350px]">
            <option value="">Toutes les spécialités</option>
            @foreach($specialites as $specialite)
            <option value="{{ $specialite->id }}" {{ request('specialite_id')==$specialite->id ? 'selected' : '' }}>
                {{ $specialite->name }}
            </option>
            @endforeach
        </select>

        <input type="text" name="nom_etudiant" placeholder="Nom étudiant" value="{{ request('nom_etudiant') }}"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />

        <select name="statut"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Tous statuts</option>
            <option value="valide" {{ request('statut')=='valide' ? 'selected' : '' }}>Validé</option>
            <option value="en_attente" {{ request('statut')=='en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="rejete" {{ request('statut')=='rejete' ? 'selected' : '' }}>Rejeté</option>
        </select>

        {{-- <select name="tranche_paye"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">Toutes les tranches</option>
            <option value="premiere" {{ request('tranche_paye')=='tranche1' ? 'selected' : '' }}>1ère tranche</option>
            <option value="deuxieme" {{ request('tranche_paye')=='tranche2' ? 'selected' : '' }}>2ème tranche</option>
            <option value="deuxieme" {{ request('tranche_paye')=='tranche2' ? 'selected' : '' }}>3ème tranche</option>
        </select>
        --}}
        <a href="{{ route('paiements.index') }}"
            class="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 transition duration-300">
            Renitialiser
        </a>
        <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition duration-300">
            Filtrer
        </button>
        <div class="flex justify-end mb-4">
            <select onchange="handleExport(this.value)"
                class="border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option selected disabled>📤 Exporter</option>
                <option value="excel">📊 Exporter en Excel</option>
                <option value="pdf">📄 Exporter en PDF</option>
            </select>
        </div>

    </form>

    <script>
        function handleExport(type) {
        if (type === 'excel') {
            window.location.href = "{{ route('export.paiements') }}";
        } else if (type === 'pdf') {
            window.location.href = "{{ route('paiements.exportPdf') }}";
        }
    }
    </script>




    <div class="overflow-x-auto">

        {{-- <div class="flex justify-end mb-4">
            <a href="{{ route('export.paiements') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                📥 Exporter en Excel
            </a>
        </div>
        <div class="flex justify-end mb-4">
            <a href="{{ route('paiements.exportPdf') }}"
                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded shadow transition duration-300">
                📥 Exporter en Pdf
            </a>
        </div> --}}


        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left">Étudiant</th>
                    <th class="px-6 py-3 text-left">Tranche</th>
                    <th class="px-6 py-3 text-left">Montant</th>
                    <th class="px-6 py-3 text-left">Mode de paiement</th>
                    {{-- <th class="px-6 py-3 text-left">Statut</th> --}}
                    <th class="px-6 py-3 text-left">Date</th>
                    <th class="px-6 py-3 text-left">Actions</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($paiements as $paiement)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $paiement->user->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ ucfirst($paiement->tranche_paye) }}</td>
                    <td class="px-6 py-4">{{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</td>
                    <td class="px-6 py-4">{{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</td>

                    {{-- <td class="px-6 py-4">
                        @if($paiement->statut === 'valide')
                        <span class="text-green-600 font-semibold">Validé</span>
                        @elseif($paiement->statut === 'en_attente')
                        <span class="text-yellow-600 font-semibold">En attente</span>
                        @else
                        <span class="text-red-600 font-semibold">Rejeté</span>
                        @endif
                    </td> --}}

                    <td class="px-6 py-4">{{ $paiement->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('paiements.indexByUser', $paiement->user->id) }}"
                            class="text-blue-600 hover:underline text-sm font-semibold">
                            Voir l'historique
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucun paiement enregistré.</td>


                </tr>
                @endforelse
                @if($paiements->count() > 0)
                <tr class="bg-gray-100 font-bold">
                    <td colspan="2" class="px-6 py-4 text-right">Total :</td>
                    <td class="px-6 py-4">
                        {{ number_format($totalMontant, 0, ',', ' ') }} FCFA
                    </td>
                    <td colspan="4"></td>
                </tr>
                @endif


            </tbody>
        </table>
        <!-- 🔽 Ajoute ton bloc juste après la table -->
        @if($paiements->count() > 0)
        <div class="mt-6 bg-green-50 text-green-800 p-4 rounded shadow">
            🎓 <strong>Nombre total d'étudiants ayant effectué au moins un paiement :</strong>
            <span class="font-bold">{{ $nombreEtudiantsPayeurs }}</span>
        </div>
        @endif
    </div>
</div>
@endsection