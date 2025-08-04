<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FraisController;
use App\Http\Controllers\Admin\NiveauController;
use App\Http\Controllers\Admin\FiliereController;
use App\Http\Controllers\Admin\PaiementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SpecialiteController;
use App\Http\Controllers\Admin\ImportNiveauController;
use App\Http\Controllers\Admin\NiveauExportController;
use App\Http\Controllers\Admin\ImportFiliereController;
use App\Http\Controllers\Admin\ImportEtudiantController;
use App\Http\Controllers\Admin\SpecialiteImportController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PresentationController;

use App\Http\Controllers\Admin\AdminUserController;

Route::get('/', function () {
    return view('welcome');
})->name('home.welcome');
// Route::middleware('auth')->group(function () {

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');
// Historique de paiements pour l'étudiant connecté
Route::get('/mes-paiements', [PaiementController::class, 'showUserPayments'])
    ->middleware('auth')
    ->name('paiements.user');

Route::get('/mes-paiements/pdf', [PaiementController::class, 'exportUserPdf'])
    ->middleware('auth')
    ->name('paiements.exportPdfUser');
Route::get('/mes-paiements/export', [PaiementController::class, 'exportUserPdf'])
    ->middleware('auth')
    ->name('paiements.exportUserPdf');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

Route::middleware(['auth', 'role:admin'])->group(function () {


    //Route destinee aux niveau

    Route::prefix('/admin/niveaux')->name('niveaux.')->group(function () {
        Route::get('/', [NiveauController::class, 'index'])->name('index');
        Route::get('/add-niveaux', [NiveauController::class, 'create'])->name('create');
        Route::post('/add-niveaux', [NiveauController::class, 'store'])->name('store');

        Route::delete('/niveaux/{id}', [NiveauController::class, 'delete'])->name('delete');
        Route::get('/niveaux/{id}', [NiveauController::class, 'edit'])->name('edit');
        Route::put('/niveaux/{id}', [NiveauController::class, 'update'])->name('update');
    });

    //Route destinee aux specialites
    Route::prefix('/admin/specialites')->name('specialites.')->group(function () {
        Route::get('/', [SpecialiteController::class, 'index'])->name('index');
        Route::get('/add-specialite', [SpecialiteController::class, 'create'])->name('create');
        Route::post('/add-specialite/store', [SpecialiteController::class, 'store'])->name('store');
        Route::delete('/delete-specialite/{id}', [SpecialiteController::class, 'delete'])->name('delete');
        Route::get('/edit-specialite/{id}', [SpecialiteController::class, 'edit'])->name('edit');
        Route::put('/update-specialite/{id}', [SpecialiteController::class, 'update'])->name('update');
        Route::get('/specialites/{id}', [SpecialiteController::class, 'show'])->name('show');
        Route::get('/get-specialites/{filiere_id}', [SpecialiteController::class, 'getByFiliere'])->name('byFiliere');
        Route::get('/export-specialite-pdf', [SpecialiteController::class, 'exportSpecialitePdf'])->name('exportSpecialitePdf');
    });
    //Route destinee aux filieres
    Route::prefix('/admin/filieres')->name('filieres.')->group(function () {
        Route::get('/', [FiliereController::class, 'index'])->name('index');
        Route::get('/create', [FiliereController::class, 'create'])->name('create');
        Route::post('/create', [FiliereController::class, 'store'])->name('store');
        Route::get('/{id}', [FiliereController::class, 'show'])->name('show');
        Route::get('/update-filieres/{id}', [FiliereController::class, 'edit'])->name('edit');
        Route::put('/update-filieres/{id}', [FiliereController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [FiliereController::class, 'delete'])->name('delete');
    });
    //Route destinee aux students
    Route::prefix('/admin/students')->name('students.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/create', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('delete');
    });

    //ROute destinee aux frais
    Route::prefix('/admin/frais')->name('frais.')->group(function () {
        Route::get('/', [FraisController::class, 'index'])->name('index');
        Route::get('/add-frais', [FraisController::class, 'create'])->name('create');
        Route::post('/add-frais', [FraisController::class, 'store'])->name('store');

        Route::get('/update-frais/{id}', [FraisController::class, 'edit'])->name('edit');
        Route::put('/update-frais/{id}', [FraisController::class, 'update'])->name('update');
        Route::delete('/frais/delete/{id}', [FraisController::class, 'delete'])->name('delete');
    });
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('users.index');
});


// Route::middleware(['auth', 'admin', 'comptable'])->group(function () {

//     Route::get('/admin/dashboard/project', [DashboardController::class, 'dashboard'])->name('dashboard.project');
// });
Route::middleware(['auth', 'role:admin,comptable'])->group(function () {
    Route::get('/admin/dashboard/project', [DashboardController::class, 'dashboard'])->name('dashboard.project');
});

// Route pour historique par utilisateur, on fera après
Route::middleware(['auth', 'comptable'])->group(function () {
    Route::prefix('/admin/paiements')->name('paiements.')->group(function () {
        Route::get('/', [PaiementController::class, 'index'])->name('index');
        Route::get('/create', [PaiementController::class, 'create'])->name('create');
        Route::post('/create', [PaiementController::class, 'store'])->name('store');

        Route::get('/{user}', [PaiementController::class, 'indexPaymentsForUser'])->name('indexByUser');
        Route::get('/{paiement}/edit', [PaiementController::class, 'edit'])->name('edit');
        Route::put('/{paiement}', [PaiementController::class, 'update'])->name('update');
        Route::delete('/{paiement}', [PaiementController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('/admin')->group(function () {


    Route::get('/export-paiements', [PaiementController::class, 'export'])->name('export.paiements');
    Route::get('/export-filieres-pdf', [FiliereController::class, 'exportPdf'])->name('filieres.exportPdf');
    Route::get('/export-pdf', [PaiementController::class, 'exportPdf'])->name('paiements.exportPdf');
    Route::get('/export-frais-pdf', [FraisController::class, 'exportPdfFrais'])->name('frais.exportPdfFrais');
    Route::get('/export-user-pdf', [UserController::class, 'exportPdfUser'])->name('frais.exportPdfUser');
    Route::get('/import-filieres', [ImportFiliereController::class, 'importForm'])->name('filieres.importForm');
    Route::post('/import-filieres', [ImportFiliereController::class, 'import'])->name('filieres.import');
    Route::get('/apecialites/import', [SpecialiteController::class, 'form'])->name('specialites.import.form');
    Route::post('specialites/import', [SpecialiteImportController::class, 'import'])->name('specialites.import');
    Route::get('/etudiants/import', [ImportEtudiantController::class, 'importForm'])->name('etudiants.import.form');
    Route::post('/etudiants/import', [ImportEtudiantController::class, 'import'])->name('etudiants.import');
    Route::get('/niveaux/export/pdf', [NiveauExportController::class, 'exportPdf'])->name('niveaux.exportPdf');
    Route::post('/niveaux/import', [ImportNiveauController::class, 'import'])->name('niveaux.import');
})->middleware(['auth', 'admin', 'comptable']);
// });
Route::get('/presentation', [PresentationController::class, 'index'])->name('presentation');
require __DIR__ . '/auth.php';
Route::get('/{any}', function () {
    return view('pages.notFound.pageNotFound');
});
