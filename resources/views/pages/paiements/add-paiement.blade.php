@extends('layouts.admin.layout-admin')
@section('title', 'enregistrer les paiements')


@section('content')
<div class="max-w-xl relative mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold text-blue-700 mb-6 ">Enregistrer un paiement</h2>
    <a href="{{ route('paiements.index') }}"
        class="absolute right-0 top-0 bg-red-400 text-white px-3 py-2 rounded hover:text-red-200">Back</a>
    @if(session('success'))
    <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <form action="{{ route('paiements.store') }}" method="POST">
        @csrf

        {{-- Étudiant --}}
        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700">Étudiant</label>
            <select name="user_id" id="user_id" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                <option value="">-- Choisir un étudiant --</option>
                @foreach ($students as $student)
                <option value="{{ $student->id }}" {{ old('user_id')==$student->id ? 'selected' : '' }}>
                    {{ $student->name }}
                </option>
                @endforeach
            </select>
            @error('user_id') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Tranche --}}
        <div class="mb-4">
            <label for="tranche_paye" class="block text-sm font-medium text-gray-700">Tranche</label>
            <select name="tranche_paye" id="tranche_paye" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                <option value="">-- Choisir une tranche --</option>
                @php
                $tranches = ['tranche1', 'tranche2', 'tranche3'];
                @endphp
                @foreach($tranches as $tranche)
                @if($frais->$tranche > 0)
                <option value="{{ $tranche }}" {{ old('tranche_paye')==$tranche ? 'selected' : '' }}>
                    {{ ucfirst($tranche) }} - {{ number_format($frais->$tranche, 0, ',', ' ') }} FCFA
                </option>
                @endif
                @endforeach
            </select>
            @error('tranche_paye') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Mode de paiement --}}
        <div class="mb-4">
            <label for="mode_paiement" class="block text-sm font-medium text-gray-700">Mode de paiement</label>
            <select name="mode_paiement" id="mode_paiement" required
                class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                <option value="">-- Choisir un mode --</option>
                <option value="espèce" {{ old('mode_paiement')=='espèce' ? 'selected' : '' }}>Espèce</option>
                <option value="mobile_money" {{ old('mode_paiement')=='mobile_money' ? 'selected' : '' }}>Mobile Money
                </option>
                <option value="virement" {{ old('mode_paiement')=='virement' ? 'selected' : '' }}>Virement</option>
            </select>
            @error('mode_paiement') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Bouton --}}
        <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">
            Enregistrer le paiement
        </button>
    </form>
</div>
@endsection