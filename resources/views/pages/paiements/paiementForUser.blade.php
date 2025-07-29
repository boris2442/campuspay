@extends('layouts.users.layout-user')
@section('title', 'Mes paiements')

@section('content')
<div class="max-w-5xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg relative">

    <!-- Bouton de déconnexion -->
    <form method="POST" action="{{ route('logout') }}" class="absolute top-4 right-4">
        @csrf
        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-sm px-4 py-2 rounded shadow">
            Déconnexion
        </button>
    </form>

    <h2 class="text-3xl font-bold text-blue-700 mb-6">Bienvenue, {{ $user->prenom }} {{ $user->name }}</h2>

    <div class="mb-6 bg-blue-50 p-4 rounded-lg border border-blue-200">
        <p class="text-lg font-semibold text-gray-700">
            <span class="text-gray-800">Filière :</span>
            {{ $user->filiere->name ?? 'Non défini' }}
        </p>
        <p class="text-lg font-semibold text-gray-700">
            <span class="text-gray-800">Spécialité :</span>
            {{ $user->specialite->name ?? 'Non défini' }}
        </p>
        <p class="text-lg font-semibold text-gray-700">
            <span class="text-gray-800">Niveau :</span>
            {{ $user->niveau->name ?? 'Non défini' }}
        </p>
        <p class="text-lg font-semibold">
            Total payé :
            <span class="text-green-700">{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</span> /
            <span class="text-gray-800">{{ number_format($totalFrais, 0, ',', ' ') }} FCFA</span>
        </p>
        <p class="text-lg font-semibold">
            Reste à payer :
            <span class="text-red-600">{{ number_format($fraisRestant, 0, ',', ' ') }} FCFA</span>
        </p>
        <p class="text-lg font-semibold">
            Statut global :
            @if($statutGlobal === 'Complet')
                <span class="text-green-600">{{ $statutGlobal }}</span>
            @else
                <span class="text-yellow-600">{{ $statutGlobal }}</span>
            @endif
        </p>
    </div>

    <h3 class="text-2xl font-semibold mb-4 text-gray-700">Mes tranches de paiement</h3>

    <!-- Bouton téléchargement PDF -->
    <div class="mb-4 flex justify-end">
        <a href="{{ route('paiements.exportPdfUser') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            📄 Télécharger mon reçu PDF
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left">Tranche</th>
                    <th class="px-6 py-3 text-left">Montant</th>
                    <th class="px-6 py-3 text-left">Mode de paiement</th>
                    <th class="px-6 py-3 text-left">Statut</th>
                    <th class="px-6 py-3 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($paiements as $paiement)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ ucfirst($paiement->tranche_paye) }}</td>
                        <td class="px-6 py-4">{{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</td>
                        <td class="px-6 py-4">{{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</td>
                        <td class="px-6 py-4">
                            @if($paiement->statut === 'valide')
                                <span class="text-green-600 font-semibold">Validé</span>
                            @elseif($paiement->statut === 'en_attente')
                                <span class="text-yellow-600 font-semibold">En attente</span>
                            @else
                                <span class="text-red-600 font-semibold">Rejeté</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $paiement->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Aucun paiement effectué pour l’instant.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
