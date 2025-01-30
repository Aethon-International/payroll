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
Route::middleware(['auth','useractive'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Resources for CRUD operations
// Routes for employees
Route::get('employees', [EmployeeController::class, 'index'])->name('employees.index');
Route::get('employees/create', [EmployeeController::class, 'create'])->name('employees.create');
Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
Route::get('employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
Route::get('employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
Route::put('employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

// Routes for adjustment-types
Route::get('adjustment-types', [AdjustmentTypesController::class, 'index'])->name('adjustment-types.index');
Route::get('adjustment-types/create', [AdjustmentTypesController::class, 'create'])->name('adjustment-types.create');
Route::post('adjustment-types', [AdjustmentTypesController::class, 'store'])->name('adjustment-types.store');
Route::get('adjustment-types/{adjustment_type}', [AdjustmentTypesController::class, 'show'])->name('adjustment-types.show');
Route::get('adjustment-types/{adjustment_type}/edit', [AdjustmentTypesController::class, 'edit'])->name('adjustment-types.edit');
Route::put('adjustment-types/{adjustment_type}', [AdjustmentTypesController::class, 'update'])->name('adjustment-types.update');
Route::delete('adjustment-types/{adjustment_type}', [AdjustmentTypesController::class, 'destroy'])->name('adjustment-types.destroy');

// Routes for payroll-periods
Route::get('payroll-periods', [PayrollPeriodController::class, 'index'])->name('payroll-periods.index');
Route::get('payroll-periods/create', [PayrollPeriodController::class, 'create'])->name('payroll-periods.create');
Route::post('payroll-periods', [PayrollPeriodController::class, 'store'])->name('payroll-periods.store');
Route::get('payroll-periods/{payroll_period}', [PayrollPeriodController::class, 'show'])->name('payroll-periods.show');
Route::get('payroll-periods/{payroll_period}/edit', [PayrollPeriodController::class, 'edit'])->name('payroll-periods.edit');
Route::put('payroll-periods/{payroll_period}', [PayrollPeriodController::class, 'update'])->name('payroll-periods.update');
Route::delete('payroll-periods/{payroll_period}', [PayrollPeriodController::class, 'destroy'])->name('payroll-periods.destroy');

    Route::get('salary-slips', [SalarySlipController::class, 'index'])->name('admin.salary-slips.index');
    Route::get('salary-slips/create', [SalarySlipController::class, 'create'])->name('admin.salary-slips.create');
    Route::post('salary-slips', [SalarySlipController::class, 'store'])->name('admin.salary-slips.store');
    Route::get('salary-slips/{salary_slip}', [SalarySlipController::class, 'show'])->name('admin.salary-slips.show');
    Route::get('salary-slips/{salary_slip}/edit', [SalarySlipController::class, 'edit'])->name('admin.salary-slips.edit');
    Route::put('salary-slips/{salary_slip}', [SalarySlipController::class, 'update'])->name('admin.salary-slips.update');
    Route::get('delete/salary-slips/{salary_slip}', [SalarySlipController::class, 'destroy'])->name('admin.salary-slips.destroy');

    // Bulk action route for salary slips
    // Route::post('/salaryslips/bulk-action', [BulkActionController::class, 'handleBulkAction'])->name('salaryslips.send-bulk-action');

    // Admin user management
    Route::resource('admins', UserController::class);

    // Routes for filtering salary slips by employee or payroll period
    Route::get('salaryslips/employee/{employee_id}', [SalarySlipController::class, 'selectedEmployeeSalarySlips'])->name('selected.employee.salary-slips');
    Route::get('salaryslips/payroll-period/{payroll_period_id}', [SalarySlipController::class, 'selectedPayrollPeriodSalarySlips'])->name('selected.payroll-period.salary-slips');
});


Route::middleware(['auth', 'useractive'])->group(function () {
    Route::get('employee/salary-slips}', [SalarySlipController::class, 'showEmployeeSalarySlip'])->name('employee.salary-slips');
});


 // Profile routes
 Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
 Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
 Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


 // User status toggle
 Route::post('users/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');


 // PDF generation route
 Route::get('generate-pdf/{salary_slip_id}', [PdfController::class, 'generatePdf'])->name('generate-pdf');
 require __DIR__.'/auth.php';

 Route::get('deletess', [SalarySlipController::class, 'delete'])->name('deletess');
