<?php

use App\Http\Controllers\Auth\TenantRegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamInvitationController;
use App\Http\Middleware\EnsureTenantScope;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Create New Tenant (Authenticated)
    Route::get('/tenant/create', [TenantRegistrationController::class, 'create'])->name('tenant.create');
    Route::post('/tenant/store', [TenantRegistrationController::class, 'store'])->name('tenant.store');
});

use App\Livewire\Cases\CaseList;
use App\Livewire\Cases\CreateCaseForm;

Route::middleware(['auth', 'verified', EnsureTenantScope::class])->group(function () {
    Route::view('/team', 'team.index')->name('team.index');
    Route::get('/team/invite', [TeamInvitationController::class, 'create'])->name('team.invite');
    Route::post('/team/invite', [TeamInvitationController::class, 'store'])->name('team.invite.store');

    // Case Management
    Route::get('/cases', CaseList::class)->name('cases.index');
    Route::get('/cases/create', CreateCaseForm::class)->name('cases.create');
});

// Public route for joining (middleware handling inside controller for auth redirect)
Route::get('/team/join/{token}', [TeamInvitationController::class, 'accept'])->name('team.join');

require __DIR__.'/auth.php';