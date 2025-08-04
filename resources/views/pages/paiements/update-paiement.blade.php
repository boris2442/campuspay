@extends('layouts.admin.layout-admin')
@section('title', 'Modifier un paiement')
@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg relative">
    <a href="{{ route('paiements.index') }}"
        class="absolute right-0 top-0 bg-red-400 text-white px-3 py-2 rounded hover:text-red-200">Back</a>
    <h2 class="text-2xl font-bold text-blue-700 mb-6">Modifier un paiement</h2>

    @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <form action="{{ route('paiements.update', $paiement) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700">Étudiant</label>
            <select name="user_id" id="user_id" class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
                <option value="">-- Choisir un étudiant --</option>
                @foreach ($students as $student)
                <option value="{{ $student->id }}" {{ $paiement->user_id == $student->id ? 'selected' : '' }}>
                    {{ $student->name }}
                </option>
                @endforeach
            </select>
            @error('user_id')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Hidden frais_id -->
        <input type="hidden" name="frais_id" value="{{ $frais ? $frais->id : '' }}">

        <!-- Tranche payée -->
        <div class="mb-4">
            <label for="tranche_paye" class="block text-sm font-medium text-gray-700">Tranche</label>
            <select name="tranche_paye" id="tranche_paye"
                class="mt-1 block w-fullалеко w-full border-gray-300 rounded shadow-sm" required>
                <option value="">-- Choisir une tranche --</option>
                @php
                $colonnesTranches = ['tranche1' => 1, 'tranche2' => 2, 'tranche3' => 3];
                @endphp
                @foreach ($colonnesTranches as $tranche => $value)
                @if ($frais && $frais->$tranche && $frais->$tranche > 0)
                <option value="{{ $value }}" {{ $paiement->tranche_paye == $value ? 'selected' : '' }}>
                    {{ ucfirst($tranche) }} - {{ $frais->$tranche }} FCFA
                </option>
                @endif
                @endforeach
            </select>
            @error('tranche_paye')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="montant_paye" class="block text-sm font-medium text-gray-700">Montant payé</label>
            <input type="number" name="montant_paye" id="montant_paye" value="{{ $paiement->montant_paye }}"
                class="mt-1 block w-full rounded border-gray-300 shadow-sm" required>
            @error('montant_paye')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="mode_paiement" class="block text-sm font-medium text-gray-700">Mode de paiement</label>
            <select name="mode_paiement" id="mode_paiement" class="mt-1 block w-full rounded border-gray-300 shadow-sm"
                required>
                <option value="espèce" {{ $paiement->mode_paiement == 'espèce' ? 'selected' : '' }}>Espèce</option>
                <option value="mobile_money" {{ $paiement->mode_paiement == 'mobile_money' ? 'selected' : '' }}>Mobile
                    Money</option>
                <option value="virement" {{ $paiement->mode_paiement == 'virement' ? 'selected' : '' }}>Virement
                </option>
            </select>
            @error('mode_paiement')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
            Mettre à jour le paiement
        </button>
    </form>
</div>
@endsection