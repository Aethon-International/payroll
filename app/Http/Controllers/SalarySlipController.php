<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\SalarySlip;
use App\Models\User;
use App\Models\PayrollPeriod;
use App\Models\AdjustmentType;
use Illuminate\Support\Facades\Auth;

class SalarySlipController extends Controller
{
    public function index()
    {
        $salaryslips = SalarySlip::all();
        $adjustmentTypes = AdjustmentType::all(); // Get all adjustment types
        return view('salaryslips.index', compact('salaryslips', 'adjustmentTypes'));
    }

    public function create()
    {
        $adjustmenttypes = AdjustmentType::all();
        $payrollperiods = PayrollPeriod::all();
        $employees = User::Role('employee')->get();
        return view('salaryslips.create', compact('employees', 'payrollperiods','adjustmenttypes'));
    }

    public function store(Request $request)
    {
    $salary_slip = new SalarySlip;

    // Fetch the employee and assign to the salary slip
    $employee = User::find($request->employee_id);
    $salary_slip->employee_id = $employee->id ?? " "; // Set the employee's foreign key in the salary slip

    // Fetch the payroll period and assign to the salary slip
    $payroll_period = PayrollPeriod::find($request->payroll_period_id);
    $salary_slip->payroll_period_id = $payroll_period->id ?? ""; // Set the payroll period's foreign key in the salary slip

    // Initialize the base salary
    $salary_slip->base_salary = $employee->salary ?? "";

    // Initialize net salary to base salary (default)
    $net_salary = $employee->salary;

    // Loop through the adjustment types and amounts to process multiple adjustments

    if ($request->has('adjustment_type_id') && $request->has('adjustment_amount')) {
        foreach ($request->adjustment_type_id as $key => $adjustment_type_id) {
            $adjustment_type = AdjustmentType::find($adjustment_type_id);

            // Calculate the adjustment amount based on the type's mode (+ or -)
            $adjustment_amount = $request->adjustment_amount[$key];
            $adjustment_type->amount=$adjustment_amount;

            if ($adjustment_type->id == '1') {
                $net_salary -= $adjustment_amount; // Add adjustment amount to net salary
                $salary_slip->days_off =$adjustment_amount;
            }
            elseif ($adjustment_type->id == '2') {
                $net_salary -= $adjustment_amount; // Subtract adjustment amount from net salary
                $salary_slip->fine =$adjustment_amount;
            }
            elseif ($adjustment_type->id == '3') {
                $net_salary += $adjustment_amount; // Subtract adjustment amount from net salary
                $salary_slip->bonus =$adjustment_amount;
            }

        }

    }

    // Set the final net salary in the salary slip
    $salary_slip->net_salary = $net_salary;
    $salary_slip->adjustment_amount  = $net_salary - $employee->salary;


    // Save the salary slip with all the relations
    $salary_slip->save();

    return redirect()->route('admin.salary-slips.index')->with('success', 'Salary Slip created successfully.');
}

    public function selectedEmployeeSalarySlips(string $employee_id)
    {
        $employee=User::find($employee_id);
        $salaryslips=$employee->salarySlips;

        return view('salaryslips.index', compact('salaryslips'));
    }


    public function edit(string $id)
    {
        $salaryslip = SalarySlip::find($id);
        $adjustmenttypes = AdjustmentType::all();
        $payrollperiods = PayrollPeriod::all();
        $employees = User::Role('employee')->get();
        return view('salaryslips.edit', compact('employees', 'payrollperiods', 'adjustmenttypes', 'salaryslip'));

    }


    public function update(Request $request, string $id)
    {

    $salary_slip = SalarySlip::find($id);
    // Fetch the employee and assign to the salary slip

    // Fetch the employee and assign to the salary slip
    $employee = User::find($request->employee_id);
    $salary_slip->employee_id = $employee->id; // Set the employee's foreign key in the salary slip

    // Fetch the payroll period and assign to the salary slip
    $payroll_period = PayrollPeriod::find($request->payroll_period_id);
    $salary_slip->payroll_period_id = $payroll_period->id; // Set the payroll period's foreign key in the salary slip

    // Initialize the base salary
    $salary_slip->base_salary = $employee->salary;

    // Initialize net salary to base salary (default)
    $net_salary = $employee->salary;

    //setting 0 value if user no t edit any field

    $salary_slip->days_off =0;
    $salary_slip->fine =0;
    $salary_slip->bonus =0;

    if ($request->has('adjustment_type_id') && $request->has('adjustment_amount')) {
        foreach ($request->adjustment_type_id as $key => $adjustment_type_id) {
            $adjustment_type = AdjustmentType::find($adjustment_type_id);

            //add relation with salaryslip

            // Calculate the adjustment amount based on the type's mode (+ or -)
            $adjustment_amount = $request->adjustment_amount[$key];
            $adjustment_type->amount=$adjustment_amount;

            if ($adjustment_type->id == '1') {
                $net_salary -= $adjustment_amount; // Add adjustment amount to net salary
                $salary_slip->days_off =$adjustment_amount;
            }
            elseif ($adjustment_type->id == '2') {
                $net_salary -= $adjustment_amount; // Subtract adjustment amount from net salary
                $salary_slip->fine =$adjustment_amount;
            }
            elseif ($adjustment_type->id == '3') {
                $net_salary += $adjustment_amount; // Subtract adjustment amount from net salary
                $salary_slip->bonus =$adjustment_amount;
            }

        }

    }

    // Set the final net salary in the salary slip
    $salary_slip->net_salary = $net_salary;
    $salary_slip->adjustment_amount  = $net_salary - $employee->salary;


    // Save the salary slip with all the relations
    $salary_slip->save();

        return redirect()->route('admin.salary-slips.index')->with('success', 'Salary Slip updated successfully!');
    }


    public function destroy($id)
    {
        SalarySlip::destroy($id);
        return redirect()->route('admin.salary-slips.index')->with('success', 'Salary Slip deleted successfully.');
    }


    public function selectedPayrollPeriodSalarySlips( $payroll_period_id)
    {
        $payroll_period=PayrollPeriod::find($payroll_period_id);
        $salaryslips=$payroll_period->salarySlips;

        return view('salaryslips.show', compact('salaryslips'));
    }


    public function showEmployeeSalarySlip( )
    {
        $user=Auth::user();
        $salaryslips=$user->salarySlips ?? "";

        return view('salaryslips.index', compact('salaryslips'));
    }


}
