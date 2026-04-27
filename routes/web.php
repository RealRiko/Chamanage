<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\WorkerController;
use App\Http\Controllers\LiveSearchController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\SetLocale;

Route::get('/locale/{locale}', function (string $locale) {
    abort_unless(in_array($locale, SetLocale::SUPPORTED, true), 404);
    session(['locale' => $locale]);

    return back();
})->name('locale.switch');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

// Registration routes live in routes/auth.php (guest middleware)

// Error page
Route::get('/company-required', function () {
    return view('errors.company_required');
})->name('company.required');

// Protected routes
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/personal-settings', [DashboardController::class, 'updatePersonalSettings'])
        ->name('dashboard.personal-settings');

    // Reports (filters + PDF export)
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export');

    // ADMIN SETTINGS (company, goal, documents) — only role "admin"
    Route::middleware('admin')->group(function () {
        Route::get('/admin/company-settings', [GoalController::class, 'companySettingsView'])
            ->name('admin.companySettings');

        Route::post('/admin/set-goal', [GoalController::class, 'setGoal'])
            ->name('admin.setGoal');

        Route::post('/admin/update-company-details', [GoalController::class, 'updateCompanyDetails'])
            ->name('admin.updateCompanyDetails');

        Route::post('/admin/update-document-settings', [GoalController::class, 'updateDocumentSettings'])
            ->name('admin.updateDocumentSettings');

        Route::post('/admin/update-low-stock-notifications', [GoalController::class, 'updateLowStockNotifications'])
            ->name('admin.updateLowStockNotifications');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Workers: list visible to all company users; create/edit/delete require admin (controller + admin middleware)
    Route::get('workers', [WorkerController::class, 'index'])->name('workers.index');
    Route::middleware('admin')->group(function () {
        Route::get('workers/create', [WorkerController::class, 'create'])->name('workers.create');
        Route::post('workers', [WorkerController::class, 'store'])->name('workers.store');
        Route::get('workers/{worker}/edit', [WorkerController::class, 'edit'])->name('workers.edit');
        Route::put('workers/{worker}', [WorkerController::class, 'update'])->name('workers.update');
        Route::patch('workers/{worker}', [WorkerController::class, 'update']);
        Route::delete('workers/{worker}', [WorkerController::class, 'destroy'])->name('workers.destroy');
    });

    // Products
    Route::resource('products', ProductController::class)->except(['show']);

    // Inventory / Storage Management
    Route::get('/storage', [InventoryController::class, 'index'])->name('inventory.index');
    Route::put('/storage', [InventoryController::class, 'bulkUpdateQuantities'])->name('inventory.bulkUpdate');

    // Clients
    Route::resource('clients', ClientController::class);

    // Documents
    Route::get('/documents/{document}/copy', [DocumentController::class, 'copy'])->name('documents.copy');
    Route::resource('documents', DocumentController::class)->except(['show']);
    Route::get('/documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
    Route::get('/documents/{document}/pdf', [DocumentController::class, 'generatePdf'])->name('documents.pdf');

    // Invoices
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    
    Route::get('/live-search', [LiveSearchController::class, 'search'])->name('live-search')->middleware('auth');
// Invoices - CREATE
Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');

});

require __DIR__ . '/auth.php';
