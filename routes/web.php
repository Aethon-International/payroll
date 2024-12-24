<?php
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\SalarySlipController;
use App\Http\Controllers\AdjustmentTypesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\BulkActionController;
use App\Http\Controllers\PayrollPeriodController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

// Protected routes for authenticated and active users
Route::middleware(['auth', 'useractive'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Resources for CRUD operations
    Route::resource('employees', EmployeeController::class);
    Route::resource('adjustment-types', AdjustmentTypesController::class);
    Route::resource('payroll-periods', PayrollPeriodController::class);
    Route::resource('salary-slips', SalarySlipController::class);

    // Bulk action route for salary slips
    Route::post('/salary-slips/bulk-action', [BulkActionController::class, 'handleBulkAction'])->name('salary-slips.send-bulk-action');

    // Admin user management
    Route::resource('admins', UserController::class);

    // Profile routes
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User status toggle
    Route::post('users/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

    // PDF generation route
    Route::get('generate-pdf/{salary_slip_id}', [PdfController::class, 'generatePdf'])->name('generate-pdf');

    // Routes for filtering salary slips by employee or payroll period
    Route::get('salary-slips/employee/{employee_id}', [SalarySlipController::class, 'selectedEmployeeSalarySlips'])->name('selected.employee.salary-slips');
    Route::get('salary-slips/payroll-period/{payroll_period_id}', [SalarySlipController::class, 'selectedPayrollPeriodSalarySlips'])->name('selected.payroll-period.salary-slips');
});

require __DIR__.'/auth.php';
