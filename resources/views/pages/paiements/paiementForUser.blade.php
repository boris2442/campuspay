
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

    <!-- Informations personnelles et financières -->
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

        <p class="text-lg font-semibold mt-3">
            Total payé :
            <span class="text-green-700">{{ number_format($user->total_paye, 0, ',', ' ') }} FCFA</span> /
            <span class="text-gray-800">{{ number_format($user->total_frais, 0, ',', ' ') }} FCFA</span>
        </p>
        <p class="text-lg font-semibold">
            Reste à payer :
            <span class="text-red-600">{{ number_format($user->frais_restant, 0, ',', ' ') }} FCFA</span>
        </p>
        <p class="text-lg font-semibold">
            Statut global :
            @if($user->statut_paiement === 'Complet')
                <span class="text-green-600 font-bold">✅ {{ $user->statut_paiement }}</span>
            @else
                <span class="text-orange-600 font-bold">⏳ {{ $user->statut_paiement }}</span>
            @endif
        </p>

        <!-- Progression des tranches -->
        <div class="mt-4">
            <p class="font-semibold text-gray-700">Suivi des tranches :</p>
            <div class="flex space-x-6 mt-2">
                @foreach(['tranche1', 'tranche2', 'tranche3'] as $index => $tranche)
                    @php
                        $estCouvert = $user->aPayeTranche($tranche);
                        $frais = \App\Models\Frai::first();
                        $montant = $frais ? $frais->{$tranche} : 0;
                    @endphp
                    <div class="text-center">
                        <div class="w-10 h-10 mx-auto rounded-full flex items-center justify-center
                            {{ $estCouvert ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600' }} font-bold">
                            {{ $index + 1 }}
                        </div>
                        <p class="text-xs mt-1 {{ $estCouvert ? 'text-green-600' : 'text-gray-500' }}">
                            {{ number_format($montant, 0, ',', ' ') }} FCFA
                        </p>
                        <p class="text-xs font-medium {{ $estCouvert ? 'text-green-700' : 'text-gray-500' }}">
                            {{ $estCouvert ? '✅ Payée' : 'En cours' }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <h3 class="text-2xl font-semibold mb-4 text-gray-700">Historique de mes paiements</h3>

    <!-- Bouton téléchargement PDF -->
    <div class="mb-4 flex justify-end">
        <a href="{{ route('paiements.exportUserPdf') }}"
           class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            📄 Télécharger mon reçu PDF
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left">Type</th>
                    <th class="px-6 py-3 text-left">Montant</th>
                    <th class="px-6 py-3 text-left">Mode</th>
                    <th class="px-6 py-3 text-left">Statut</th>
                    <th class="px-6 py-3 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($paiements as $paiement)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @if(in_array($paiement->tranche_paye, ['tranche1', 'tranche2', 'tranche3']))
                                {{ ucfirst($paiement->tranche_paye) }}
                            @else
                                <span class="text-orange-600 text-sm">Partiel</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ number_format($paiement->montant_paye, 0, ',', ' ') }} FCFA</td>
                        <td class="px-6 py-4">{{ ucfirst(str_replace('_', ' ', $paiement->mode_paiement)) }}</td>
                        <td class="px-6 py-4">
                            @if($paiement->statut === 'complet')
                                <span class="text-green-600 font-semibold">✅ Validé</span>
                            @elseif($paiement->statut === 'en_cours')
                                <span class="text-blue-600 font-semibold">🔵 En cours</span>
                            @else
                                <span class="text-red-600 font-semibold">❌ Rejeté</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">{{ $paiement->created_at->format('d/m/Y H:i') }}</td>
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