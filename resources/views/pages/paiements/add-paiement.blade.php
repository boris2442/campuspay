
@extends('layouts.admin.layout-admin')
@section('title', 'Enregistrer un paiement')

@section('content')
<div class="max-w-xl relative mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold text-blue-700 mb-6">Enregistrer un paiement</h2>
    <a href="{{ route('paiements.index') }}" class="absolute right-0 top-0 bg-red-400 text-white px-3 py-2 rounded hover:text-red-200">Retour</a>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 mb-4 rounded">{{ session('success') }}</div>
    @endif

    <form action="{{ route('paiements.store') }}" method="POST">
        @csrf

        {{-- Étudiant --}}
        <div class="mb-4">
            <label for="user_id" class="block text-sm font-medium text-gray-700">Étudiant</label>
            <select name="user_id" id="user_id" required class="mt-1 block w-full rounded border-gray-300 shadow-sm" onchange="updateStudentInfo()">
                <option value="">-- Choisir un étudiant --</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}"
                            data-total-due="{{ $frais->total }}"
                            data-total-paid="{{ $student->paiements->sum('montant_paye') ?? 0 }}"
                            {{ old('user_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Informations sur le solde --}}
        <div id="student-info" class="mb-4 p-4 bg-gray-50 rounded hidden">
            <h3 class="font-semibold text-gray-700">Situation financière</h3>
            <ul class="text-sm mt-2 space-y-1">
                <li><strong>Total dû :</strong> <span id="total-due">0</span> FCFA</li>
                <li><strong>Déjà payé :</strong> <span id="total-paid">0</span> FCFA</li>
                <li><strong>Reste à payer :</strong> <span id="remaining">0</span> FCFA</li>
            </ul>
        </div>

        {{-- Montant à payer --}}
        <div class="mb-4">
            <label for="montant_paye" class="block text-sm font-medium text-gray-700">Montant payé (FCFA)</label>
            <input type="number" name="montant_paye" id="montant_paye" value="{{ old('montant_paye') }}"
                   class="mt-1 block w-full rounded border-gray-300 shadow-sm"
                   placeholder="Saisissez le montant versé"
                   oninput="validateAmount()" required>
            @error('montant_paye') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
            <p id="amount-error" class="text-red-500 text-sm mt-1 hidden">Le montant dépasse le solde dû.</p>
        </div>

        {{-- Mode de paiement --}}
        <div class="mb-4">
            <label for="mode_paiement" class="block text-sm font-medium text-gray-700">Mode de paiement</label>
            <select name="mode_paiement" id="mode_paiement" required class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                <option value="">-- Choisir un mode --</option>
                <option value="espèce" {{ old('mode_paiement') == 'espèce' ? 'selected' : '' }}>Espèce</option>
                <option value="mobile_money" {{ old('mode_paiement') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                <option value="virement" {{ old('mode_paiement') == 'virement' ? 'selected' : '' }}>Virement</option>
            </select>
            @error('mode_paiement') <div class="text-red-500 text-sm">{{ $message }}</div> @enderror
        </div>

        {{-- Bouton --}}
        <button type="submit" id="submit-btn" class="w-full bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed">
            Enregistrer le paiement
        </button>
    </form>
</div>

<script>
    function updateStudentInfo() {
        const select = document.getElementById('user_id');
        const infoDiv = document.getElementById('student-info');
        const totalDueSpan = document.getElementById('total-due');
        const totalPaidSpan = document.getElementById('total-paid');
        const remainingSpan = document.getElementById('remaining');
        const montantInput = document.getElementById('montant_paye');
        const amountError = document.getElementById('amount-error');
        const submitBtn = document.getElementById('submit-btn');

        const option = select.options[select.selectedIndex];
        if (!option.value) {
            infoDiv.classList.add('hidden');
            montantInput.value = '';
            return;
        }

        const totalDue = parseInt(option.dataset.totalDue);
        const totalPaid = parseInt(option.dataset.totalPaid);
        const remaining = totalDue - totalPaid;

        totalDueSpan.textContent = totalDue.toLocaleString();
        totalPaidSpan.textContent = totalPaid.toLocaleString();
        remainingSpan.textContent = remaining.toLocaleString();

        infoDiv.classList.remove('hidden');

        // Réinitialiser le champ montant
        montantInput.value = '';
        amountError.classList.add('hidden');
        submitBtn.disabled = false;
    }

    function validateAmount() {
        const select = document.getElementById('user_id');
        const option = select.options[select.selectedIndex];
        if (!option.value) return;

        const totalDue = parseInt(option.dataset.totalDue);
        const totalPaid = parseInt(option.dataset.totalPaid);
        const remaining = totalDue - totalPaid;
        const enteredAmount = parseInt(document.getElementById('montant_paye').value) || 0;
        const amountError = document.getElementById('amount-error');
        const submitBtn = document.getElementById('submit-btn');

        if (enteredAmount > remaining) {
            amountError.classList.remove('hidden');
            submitBtn.disabled = true;
        } else {
            amountError.classList.add('hidden');
            submitBtn.disabled = false;
        }
    }

    // Initialiser si un étudiant est déjà sélectionné
    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById('user_id').value) {
            updateStudentInfo();
            validateAmount();
        }
    });
</script>
@endsection