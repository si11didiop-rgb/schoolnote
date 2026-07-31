<?php

use App\Http\Controllers\Admin\AffectationController;
use App\Http\Controllers\Admin\BulletinController;
use App\Http\Controllers\Admin\ClasseController as AdminClasseController;
use App\Http\Controllers\Admin\CompteController;
use App\Http\Controllers\Admin\MatiereController as AdminMatiereController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Eleve\EleveController;
use App\Http\Controllers\Enseignant\ClasseController as EnseignantClasseController;
use App\Http\Controllers\Enseignant\EvaluationController;
use App\Http\Controllers\Enseignant\MatiereController as EnseignantMatiereController;
use App\Http\Controllers\Enseignant\NoteController;
use App\Http\Controllers\Parent\ParentController;
use App\Http\Controllers\ProfileController;
use App\Models\Classe;
use App\Models\Matiere;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// ===================================================
// Pages publiques (accessibles à tous)
// ===================================================
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/mentions-legales', function () {
    return view('legal.mentions');
})->name('mentions.legales');

Route::get('/confidentialite', function () {
    return view('legal.confidentialite');
})->name('confidentialite');

Route::get('/accessibilite', function () {
    return view('legal.accessibilite');
})->name('accessibilite');

// Le dashboard redirige automatiquement vers la bonne page selon le rôle
Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    return match ($role) {
        'administrateur' => redirect()->route('admin.dashboard'),
        'enseignant'     => redirect()->route('enseignant.dashboard'),
        'eleve'          => redirect()->route('eleve.dashboard'),
        'parent'         => redirect()->route('parent.dashboard'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Changement de mot de passe obligatoire au premier login
    Route::get('/change-password', [ChangePasswordController::class, 'index'])->name('password.change');
    Route::post('/change-password', [ChangePasswordController::class, 'store'])->name('password.change.store');
});

// ===================================================
// Espace ADMINISTRATEUR
// ===================================================
Route::middleware(['auth', 'role:administrateur'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'stats' => [
                'classes'     => Classe::count(),
                'eleves'      => User::where('role', 'eleve')->count(),
                'enseignants' => User::where('role', 'enseignant')->count(),
                'matieres'    => Matiere::count(),
            ],
            'classes' => Classe::orderBy('nom')->get(),
        ]);
    })->name('dashboard');

    Route::resource('classes', AdminClasseController::class)->parameters(['classes' => 'classe']);
    Route::resource('matieres', AdminMatiereController::class);
    Route::resource('comptes', CompteController::class);
    Route::resource('affectations', AffectationController::class);

    Route::post('/classes/{classe}/bulletin/toggle', [BulletinController::class, 'toggle'])
        ->name('classes.bulletin.toggle');
});

// ===================================================
// Espace ENSEIGNANT
// ===================================================
Route::middleware(['auth', 'role:enseignant'])->prefix('enseignant')->name('enseignant.')->group(function () {
    Route::get('/dashboard', function () {
        return view('enseignant.dashboard');
    })->name('dashboard');

    Route::resource('evaluations', EvaluationController::class);

    Route::get('/evaluations/{evaluation}/notes', [NoteController::class, 'edit'])->name('notes.edit');
    Route::put('/evaluations/{evaluation}/notes', [NoteController::class, 'update'])->name('notes.update');

    Route::resource('classes', EnseignantClasseController::class)
        ->parameters(['classes' => 'classe'])
        ->only(['index', 'show']);

    Route::get('/matieres', [EnseignantMatiereController::class, 'index'])->name('matieres.index');
});

// ===================================================
// Espace ELEVE
// ===================================================
Route::middleware(['auth', 'role:eleve'])->prefix('eleve')->name('eleve.')->group(function () {
    Route::get('/dashboard', function () {
        return view('eleve.dashboard');
    })->name('dashboard');

    Route::get('/notes', [EleveController::class, 'notes'])->name('notes');
    Route::get('/evaluations', [EleveController::class, 'evaluations'])->name('evaluations');
    Route::get('/bulletin', [EleveController::class, 'bulletin'])->name('bulletin');
    Route::get('/bulletin/pdf', [EleveController::class, 'bulletinPdf'])->name('bulletin.pdf');
});

// ===================================================
// Espace PARENT
// ===================================================
Route::middleware(['auth', 'role:parent'])->prefix('parent')->name('parent.')->group(function () {
    Route::get('/dashboard', [ParentController::class, 'dashboard'])->name('dashboard');

    Route::get('/enfants/{enfant}/notes', [ParentController::class, 'notes'])->name('notes');
    Route::get('/enfants/{enfant}/bulletin', [ParentController::class, 'bulletin'])->name('bulletin');
});

require __DIR__.'/auth.php';