{{-- @auth --}}
{{-- @if(auth()->user()->role!='user') --}}
@extends('layouts.admin.layout-admin')
@section('title', 'dashboard')
@section('content')

<!-- Sidebar -->
<div class="flex  bg-gray-100 dark:bg-gray-900">

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
        <!-- Top bar -->

        <!-- Page content -->
        <div class="flex-1 p-6">


            <!-- Statistiques rapides -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8 ">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center max-w-[400px]">
                    <h3 class="font-medium text-gray-600 dark:text-gray-300"> <i
                            class="fas fa-wallet mr-2 text-green-500"></i>Total 1ʳᵉ Tranche en caisse</h3>
                    <p class="mt-2 text-2xl font-bold text-green-600">
                        {{ number_format($montantsParTranche['tranche1'], 0, ',', ' ') }} FCFA
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center max-w-[400px]">
                    <h3 class="font-medium text-gray-600 dark:text-gray-300"> <i
                            class="fas fa-wallet mr-2 text-green-500"></i>Total 2ᵉ Tranche en caisse</h3>
                    <p class="mt-2 text-2xl font-bold text-indigo-600">
                        {{ number_format($montantsParTranche['tranche2'], 0, ',', ' ') }} FCFA
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center max-w-[400px]">
                    <h3 class="font-medium text-gray-600 dark:text-gray-300"> <i
                            class="fas fa-wallet mr-2 text-green-500"></i>Total 3ᵉ Tranche en caisse</h3>
                    <p class="mt-2 text-2xl font-bold text-purple-600">
                        {{ number_format($montantsParTranche['tranche3'], 0, ',', ' ') }} FCFA
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center max-w-[400px]">
                    <h3 class="font-medium text-gray-600 dark:text-gray-300">💰 Budget annuel attendu</h3>
                    <p class="mt-2 text-2xl font-bold text-yellow-600">
                        {{ number_format($statsFinancieres['totalAttendu'], 0, ',', ' ') }} FCFA
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center max-w-[400px]">
                    <h3 class="font-medium text-gray-600 dark:text-gray-300">✔️ Déjà versé (validé)</h3>
                    <p class="mt-2 text-2xl font-bold text-green-600">
                        {{ number_format($statsFinancieres['totalVerse'], 0, ',', ' ') }} FCFA
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center max-w-[400px]">
                    <h3 class="font-medium text-gray-600 dark:text-gray-300">⏳ Reste à verser</h3>
                    <p class="mt-2 text-2xl font-bold text-red-600">
                        {{ number_format($statsFinancieres['resteAVerser'], 0, ',', ' ') }} FCFA
                    </p>
                </div>
                {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8"> --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center max-w-[400px]">
                        <h3 class="font-medium text-gray-600 dark:text-gray-300"><i
                                class="fas fa-exclamation-circle text-red-500 mr-2"></i> Reste à verser - 1ʳᵉ Tranche
                        </h3>
                        <p class="mt-2 text-2xl font-bold text-red-600">
                            {{ number_format($montantsRestantsParTranche['tranche1'], 0, ',', ' ') }} FCFA
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center max-w-[400px]">
                        <h3 class="font-medium text-gray-600 dark:text-gray-300"><i
                                class="fas fa-exclamation-circle text-red-500 mr-2"></i> Reste à verser - 2ᵉ Tranche
                        </h3>
                        <p class="mt-2 text-2xl font-bold text-red-600">
                            {{ number_format($montantsRestantsParTranche['tranche2'], 0, ',', ' ') }} FCFA
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center max-w-[400px]">
                        <h3 class="font-medium text-gray-600 dark:text-gray-300"><i
                                class="fas fa-exclamation-circle text-red-500 mr-2"></i> Reste à verser - 3ᵉ Tranche
                        </h3>
                        <p class="mt-2 text-2xl font-bold text-red-600">
                            {{ number_format($montantsRestantsParTranche['tranche3'], 0, ',', ' ') }} FCFA
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center">
                        <h3 class="font-medium text-gray-600 dark:text-gray-300">
                            <i class="fas fa-percent text-green-500 mr-2"></i> % payé Tranche 1
                        </h3>
                        <p class="mt-2 text-2xl font-bold text-green-600">
                            {{ $pourcentagesParTranche['tranche1'] }}%
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center">
                        <h3 class="font-medium text-gray-600 dark:text-gray-300">
                            <i class="fas fa-percent text-indigo-500 mr-2"></i> % payé Tranche 2
                        </h3>
                        <p class="mt-2 text-2xl font-bold text-indigo-600">
                            {{ $pourcentagesParTranche['tranche2'] }}%
                        </p>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center">
                        <h3 class="font-medium text-gray-600 dark:text-gray-300">
                            <i class="fas fa-percent text-purple-500 mr-2"></i> % payé Tranche 3
                        </h3>
                        <p class="mt-2 text-2xl font-bold text-purple-600">
                            {{ $pourcentagesParTranche['tranche3'] }}%
                        </p>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center">
                        <h3 class="font-medium text-gray-600 dark:text-gray-300">
                            <i class="fas fa-chart-line text-blue-500 mr-2"></i> Progression globale des paiements
                        </h3>
                        <p class="mt-2 text-3xl font-bold text-blue-600">
                            {{ $pourcentageTotal }}%
                        </p>
                    </div>


                    {{--
                </div> --}}
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center">
                    <h3 class="font-medium text-gray-600 dark:text-gray-300"> <i
                            class="fas fa-user-graduate text-blue-500 mr-2"></i>
                        Étudiants</h3>
                    <p class="mt-2 text-2xl font-bold text-blue-600">
                        {{ $students->count() }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center">
                    <h3 class="font-medium text-gray-600 dark:text-gray-300"> <i
                            class="fas fa-book text-indigo-500 mr-2"></i>
                        Filières
                    </h3>
                    <p class="mt-2 text-2xl font-bold text-blue-600">{{$filieres->count()}}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center">
                    <h3 class="font-medium text-gray-600 dark:text-gray-300"><i
                            class="fas fa-certificate text-purple-500 mr-2"></i> Spécialités</h3>
                    <p class="mt-2 text-2xl font-bold text-blue-600"> {{ $specialites->count()}}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 text-center">
                    <h3 class="font-medium text-gray-600 dark:text-gray-300"> <i
                            class="fas fa-layer-group text-pink-500 mr-2"></i>
                        Niveaux</h3>
                    <p class="mt-2 text-2xl font-bold text-blue-600">{{$niveaux->count()}} </p>
                </div>


            </div>
            {{-- Mes differents graphiques du projet --}}
            <!-- Graphique : répartition par niveau -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- <div class="overflow-x-auto"> --}}
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 ">

                        <canvas id="niveauChart" width="100" height="100"></canvas>
                    </div>

                    <!-- Graphique : Montant payé par spécialité -->
                    <div class="overflow-x-auto">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 h-[370px]">
                            <canvas id="specialitePaiementChart"></canvas>
                        </div>
                    </div>
                    <!-- Graphique : répartition par statut -->
                    {{-- <div class="overflow-x-auto"> --}}
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 ">
                            <canvas id="paiementChart" height="100"></canvas>
                        </div>
                        {{--
                    </div> --}}

                    <!-- Graphique : répartition par mode de paiement -->
                    <div class="overflow-x-auto">
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 h-[370px]">
                            <canvas id="modePaiementChart"></canvas>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <canvas id="etudiantsFiliereChart" height="300"></canvas>
                    </div>
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                        <canvas id="evolutionPaiementChart" height="300"></canvas>
                    </div>

                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 h-[370px] ">
                        <canvas id="resteTrancheChart"></canvas>
                    </div>


                </div>
            </div>
        </div>

        <!-- Scripts spécifiques -->
    </div>
    <!-- Canvas pour le graphique -->

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        window.statutsLabels = @json($statusPaiement->pluck('statut'));
    window.statutsCounts = @json($statusPaiement->pluck('total'));
    const modeLabels = @json($paiementsParMode->pluck('mode_paiement'));
    const modeCounts = @json($paiementsParMode->pluck('total'));
 const specialiteLabels = @json($montantsParSpecialite->pluck('name'));
    const specialiteMontants = @json($montantsParSpecialite->pluck('total'));
    const filieresLabels = @json($etudiantsParFiliere['labels']);
const filieresCounts = @json($etudiantsParFiliere['counts']);

    </script>

    <script>
        window.onload = function () {
        const niveauCtx = document.getElementById('niveauChart').getContext('2d');
    const paiementCtx = document.getElementById('paiementChart').getContext('2d');
   const modePaiementCtx = document.getElementById('modePaiementChart').getContext('2d');
   const specialiteCtx = document.getElementById('specialitePaiementChart').getContext('2d');
    const etudiantsFiliereCtx = document.getElementById('etudiantsFiliereChart').getContext('2d');
    const evolutionCtx = document.getElementById('evolutionPaiementChart').getContext('2d');

    new Chart(niveauCtx, {
    type: 'pie',
    data: {
        labels: @json($niveauLabels),
        datasets: [{
            label: "Nombre d'étudiants",
            data: @json($niveauCounts),
            backgroundColor: [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#00C49F', '#FF9F40'
            ],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Répartition des étudiants par niveau',
                font: {
                    size: 18
                },
                color: '#222',
                padding: {
                    top: 10,
                    bottom: 20
                }
            },
            legend: {
                position: 'bottom',
                labels: {
                    font: {
                        size: 14
                    },
                    color: '#333'
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw || 0;
                        return `${label} : ${value} étudiant(s)`;
                    }
                }
            },
            datalabels: {
                color: '#fff',
                formatter: (value, ctx) => {
                    const total = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    const percent = (value / total * 100).toFixed(1);
                    return `${percent}%`;
                },
                font: {
                    weight: 'bold'
                }
            }
        },
        animation: {
            animateRotate: true,
            duration: 1000,
            easing: 'easeOutBounce'
        }
    },
    plugins: [ChartDataLabels] 
});

new Chart(paiementCtx, {
        type: 'pie', // ou 'bar' selon ton choix
        data: {
            labels: window.statutsLabels.map(s => s.replace('_', ' ').toUpperCase()),
            datasets: [{
                label: 'Nombre de paiements',
                data: window.statutsCounts,
                backgroundColor: [
                    '#FFA500', // orange pour en attente
                    '#FF0000', // rouge pour rejeté
                    '#4CAF50'  // vert pour payé
                ],
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Statut des paiements',
                    font: {
                        size: 18
                    },
                    color: '#222',
                    padding: {
                        top: 10,
                        bottom: 20
                    }
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            size: 14
                        },
                        color: '#333'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            return `${label} : ${value} paiement(s)`;
                        }
                    }
                },
                datalabels: {
                    color: '#fff',
                    formatter: (value, ctx) => {
                        const total = ctx.chart.data.datasets[0].data.reduce((a,b) => a+b, 0);
                        const percent = (value / total * 100).toFixed(1);
                        return `${percent}%`;
                    },
                    font: {
                        weight: 'bold'
                    }
                }
            },
            animation: {
                animateRotate: true,
                duration: 1000,
                easing: 'easeOutBounce'
            }
        },
        plugins: [ChartDataLabels]
    });
  

    new Chart(modePaiementCtx, {
    type: 'bar',
    data: {
        labels: modeLabels.map(label => label.toUpperCase()),
        datasets: [{
            label: 'Nombre de paiements',
            data: modeCounts,
            backgroundColor: ['#4BC0C0', '#FFCE56', '#36A2EB'],
            borderColor: '#4B5563', // gris foncé
            borderWidth: 1,
            borderRadius: 6, // bords arrondis
            barThickness: 40 // épaisseur fixe
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false, // permet d’avoir une bonne taille dans un petit conteneur
        plugins: {
            title: {
                display: true,
                text: 'Répartition par mode de paiement',
                font: {
                    size: 18,
                    weight: 'bold'
                },
                color: '#222',
                padding: {
                    top: 10,
                    bottom: 20
                }
            },
            legend: {
                display: true,
                labels: {
                    color: '#333',
                    font: {
                        size: 13
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label} : ${context.raw} paiement(s)`;
                    }
                }
            },
            datalabels: {
                color: '#111',
                anchor: 'end',
                align: 'top',
                formatter: (value) => value,
                font: {
                    weight: 'bold'
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#444',
                    font: { size: 13 }
                },
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    color: '#444',
                    font: { size: 13 }
                },
                title: {
                    display: true,
                    text: 'Nombre de paiements',
                    color: '#333',
                    font: { size: 14 }
                },
                grid: {
                    color: '#E5E7EB'
                }
            }
        },
        animation: {
            duration: 1000,
            easing: 'easeOutBounce'
        }
    },
    plugins: [ChartDataLabels]
});

new Chart(specialiteCtx, {
    type: 'bar',
    data: {
        labels: specialiteLabels.map(label => label.toUpperCase()),
        datasets: [{
            label: 'Montant payé (FCFA)',
            data: specialiteMontants,
            backgroundColor: '#6366F1',
            borderRadius: 5
        }]
    },
    options: {
        indexAxis: 'y', // Barres horizontales
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Montant payé par spécialité',
                font: {
                    size: 18,
                    weight: 'bold'
                },
                color: '#222',
                padding: { top: 10, bottom: 20 }
            },
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        return `${context.label} : ${context.raw.toLocaleString()} FCFA`;
                    }
                }
            },
            datalabels: {
                color: '#111',
                align: 'end',
                anchor: 'end',
                formatter: (value) => value.toLocaleString() + ' FCFA',
                font: { weight: 'bold' }
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Montant payé (FCFA)',
                    color: '#333'
                },
                ticks: {
                    color: '#444',
                    font: { size: 13 }
                },
                grid: {
                    color: '#E5E7EB'
                }
            },
            y: {
                ticks: {
                    font: { size: 13 },
                    color: '#444'
                },
                grid: {
                    display: false
                }
            }
        },
        animation: {
            duration: 1000,
            easing: 'easeOutBounce'
        }
    },
    plugins: [ChartDataLabels]
});

new Chart(etudiantsFiliereCtx, {
      type: 'polarArea',
    data: {
        labels: @json($filieresLabels),
        datasets: [{
            label: 'Étudiants par filière',
            data: @json($filieresCounts),
            backgroundColor: [
                '#6366F1', '#F59E0B', '#10B981', '#EF4444', '#3B82F6',
                '#8B5CF6', '#14B8A6', '#EC4899'
            ],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Nombre d\'étudiants par filière',
                font: {
                    size: 18,
                    weight: 'bold'
                },
                color: '#222',
                padding: {
                    top: 10,
                    bottom: 20
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label} : ${context.raw} étudiant(s)`;
                    }
                }
            },
            legend: {
                position: 'right',
                labels: {
                    color: '#333',
                    font: {
                        size: 13
                    }
                }
            }
        }
    }
    });
new Chart(evolutionCtx, {
    type: 'line',
    data: {
        labels: @json($evolutionPaiements->pluck('date')),
        datasets: [{
            label: 'Montant payé (FCFA)',
            data: @json($evolutionPaiements->pluck('total')),
            fill: true,
            borderColor: '#6366F1',
            backgroundColor: 'rgba(99, 102, 241, 0.2)',
            tension: 0.4,
            pointBackgroundColor: '#4F46E5',
            pointBorderColor: '#fff',
            pointRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Évolution des paiements dans le temps',
                font: {
                    size: 18,
                    weight: 'bold'
                },
                color: '#222',
                padding: {
                    top: 10,
                    bottom: 20
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return `${context.label} : ${context.raw.toLocaleString()} FCFA`;
                    }
                }
            }
        },
        scales: {
            x: {
                title: {
                    display: true,
                    text: 'Date'
                },
                ticks: {
                    color: '#444'
                },
                grid: {
                    color: '#E5E7EB'
                }
            },
            y: {
                beginAtZero: true,
                title: {
                    display: true,
                    text: 'Montant payé (FCFA)'
                },
                ticks: {
                    color: '#444'
                },
                grid: {
                    color: '#E5E7EB'
                }
            }
        }
    }
});
const ctxResteTranche = document.getElementById('resteTrancheChart').getContext('2d');

new Chart(ctxResteTranche, {
    type: 'bar',
    data: {
        labels: ['Tranche 1', 'Tranche 2', 'Tranche 3'],
        datasets: [{
            label: 'Reste à verser (FCFA)',
            data: [
                {{ $montantsRestantsParTranche['tranche1'] }},
                {{ $montantsRestantsParTranche['tranche2'] }},
                {{ $montantsRestantsParTranche['tranche3'] }},
            ],
            backgroundColor: ['#EF4444', '#F87171', '#FCA5A5'], // nuances de rouge
            borderColor: '#B91C1C', // rouge foncé pour la bordure
            borderWidth: 1,
            borderRadius: 6,
            barThickness: 40
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            title: {
                display: true,
                text: 'Reste à verser par tranche',
                font: {
                    size: 18,
                    weight: 'bold'
                },
                color: '#222',
                padding: {
                    top: 10,
                    bottom: 20
                }
            },
            legend: {
                display: true,
                labels: {
                    color: '#333',
                    font: {
                        size: 13
                    }
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return context.dataset.label + ' : ' + context.formattedValue + ' FCFA';
                    }
                }
            },
            datalabels: {
                color: '#111',
                anchor: 'end',
                align: 'top',
                formatter: (value) => value.toLocaleString(),
                font: {
                    weight: 'bold'
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: '#444',
                    font: { size: 13 }
                },
                grid: {
                    display: false
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#444',
                    font: { size: 13 },
                    callback: function(value) {
                        return value.toLocaleString() + ' FCFA';
                    }
                },
                title: {
                    display: true,
                    text: 'Montant en FCFA',
                    color: '#333',
                    font: { size: 14 }
                },
                grid: {
                    color: '#E5E7EB'
                }
            }
        },
        animation: {
            duration: 1200,
            easing: 'easeOutBounce'
        }
    },
    plugins: [ChartDataLabels]
});



    };
    </script>



    @endsection
    {{-- @endif --}}
    {{-- @endauth --}}