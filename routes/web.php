<?php

use App\Http\Controllers\Auth\TenantRegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeamInvitationController;
use App\Http\Middleware\EnsureTenantScope;
use App\Http\Middleware\EnsureTenantIsSubscribed;
use App\Http\Middleware\IdentifyTenant;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard moved to tenant group

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
use App\Livewire\Evidence\EvidenceForm;
use App\Livewire\Evidence\CustodyMovementForm;
use App\Livewire\Evidence\EvidenceTable;
use App\Livewire\Billing\BillingPortal;

// Grupo Protegido por Tenant Scope y Suscripción
Route::middleware(['auth', 'verified', IdentifyTenant::class, EnsureTenantScope::class, EnsureTenantIsSubscribed::class])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    Route::view('/team', 'team.index')->name('team.index');
    Route::get('/team/invite', [TeamInvitationController::class, 'create'])->name('team.invite');
    Route::post('/team/invite', [TeamInvitationController::class, 'store'])->name('team.invite.store');

    // Case Management
    Route::get('/cases', CaseList::class)->name('cases.index');
    Route::get('/cases/create', CreateCaseForm::class)->name('cases.create');
    Route::get('/cases/{case}', App\Livewire\Cases\ShowCase::class)->name('cases.show');

    // Calendar
    Route::get('/calendar', App\Livewire\Hearings\HearingsCalendar::class)->name('calendar');

    // Evidence Management
    Route::view('/evidence', 'evidence.index')->name('evidence.index');
    Route::get('/evidence/create', EvidenceForm::class)->name('evidence.create');
    Route::get('/evidence/{evidence}/move', CustodyMovementForm::class)->name('evidence.move');

    // Stats & Reports
    Route::get('/alerts', [\App\Http\Controllers\AlertsController::class, 'index'])->name('alerts.index');
    Route::get('/reports', [\App\Http\Controllers\ReportsController::class, 'index'])->name('reports.index');

    // Billing (BillingPortal.php handles internally permissions for managing)
    // Note: Billing route is allowed by middleware exception, but we keep it inside group for tenant scope
    Route::get('/billing', BillingPortal::class)->name('billing.index');
});

// Public route for joining (middleware handling inside controller for auth redirect)
Route::get('/team/join/{token}', [TeamInvitationController::class, 'accept'])->name('team.join');

require __DIR__ . '/auth.php';