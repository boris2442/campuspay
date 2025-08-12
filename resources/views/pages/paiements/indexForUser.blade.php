{{-- @extends('layouts.admin.layout-admin')
@section('title', 'Historique d\'un utilisateur')
@section('content')
<div class="max-w-5xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg relative">
    <a href="{{ route('paiements.index') }}"
        class="absolute right-0 top-0 bg-red-400 text-white px-3 py-2 rounded hover:text-red-200">Back</a>
    <a href="{{ route('paiements.create') }}"
        class="absolute left-0 top-0 bg-green-400 text-white px-3 py-2 rounded hover:text-green-200">Ajouter un
        paiement</a>
    <h2 class="text-3xl font-bold text-blue-700 mb-6 pt-4">Historique des paiements</h2>


    <div class="mb-6 p-4 bg-blue-50 rounded-lg shadow-sm border border-blue-200">
        <p class="text-lg mb-2 font-semibold text-gray-700">
            Étudiant : <span class="text-blue-800">{{ $user->name }}</span>
        </p>

        <p class="text-lg font-semibold">
            Total payé :
            <span class="text-gray-800">{{ number_format($totalPaye, 0, ',', ' ') }} FCFA</span> /
            Total frais :
            <span class="text-gray-800">{{ number_format($totalFrais, 0, ',', ' ') }} FCFA</span>
        </p>
        <p class="text-lg font-semibold">Reste à payer: {{ number_format($fraisRestant, 0, ',', ' ') }} FCFA</p>
        <p class="text-lg font-semibold">
            Statut global :
            @if($statutGlobal === 'Complet')
            <span class="text-green-600">{{ $statutGlobal }}</span>
            @else
            <span class="text-red-600">{{ $statutGlobal }}</span>
            @endif
        </p>
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
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun paiement enregistré.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection --}}

@extends('layouts.admin.layout-admin')
@section('title', 'Historique d\'un utilisateur')

@section('content')
<div class="max-w-5xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg relative">
    <a href="{{ route('paiements.index') }}"
        class="absolute right-0 top-0 bg-red-400 text-white px-3 py-2 rounded hover:text-red-200">Retour</a>
    @auth
    @if(auth()->user()->role==='comptable')

    <a href="{{ route('paiements.create') }}"
        class="absolute left-0 top-0 bg-green-400 text-white px-3 py-2 rounded hover:text-green-200">Ajouter un
        paiement</a>
    @endif
    @endauth

    <h2 class="text-3xl font-bold text-blue-700 mb-6 pt-4">Historique des paiements</h2>

    <!-- Informations étudiant -->
    <div class="mb-6 p-4 bg-blue-50 rounded-lg shadow-sm border border-blue-200">
        <p class="text-lg mb-2 font-semibold text-gray-700">
            Étudiant : <span class="text-blue-800">{{ $user->name }}</span>
        </p>
        <p class="text-lg font-semibold">
            Total payé :
            <span class="text-gray-800">{{ number_format($user->total_paye, 0, ',', ' ') }} FCFA</span> /
            Total frais :
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

        <!-- Affichage des tranches couvertes -->
        <div class="mt-4">
            <p class="font-semibold text-gray-700">Progression des tranches :</p>
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

    <!-- Tableau des paiements -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-blue-600 text-white">
                <tr>
                    <th class="px-6 py-3 text-left">Type</th>
                    <th class="px-6 py-3 text-left">Montant</th>
                    <th class="px-6 py-3 text-left">Mode de paiement</th>
                    <th class="px-6 py-3 text-left">Statut</th>
                    <th class="px-6 py-3 text-left">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($paiements as $paiement)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-6 py-4">
                        @if($paiement->tranche_paye && in_array($paiement->tranche_paye, ['tranche1', 'tranche2',
                        'tranche3']))
                        {{ ucfirst($paiement->tranche_paye) }}
                        @else
                        <span class="text-orange-600 font-medium">Paiement partiel</span>
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
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Aucun paiement enregistré.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection