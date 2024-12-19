<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SalarySlipMail;
use App\Models\SalarySlip;
use Barryvdh\DomPDF\Facade\Pdf;

class MailController extends Controller
{
    public function sendSalarySlip($salaryslip_id)
{
    try {
        // Access receiver employee
        $salary_slip = SalarySlip::findOrFail($salaryslip_id);
        $receiveremail = $salary_slip->employee->email;
        $employee=$salary_slip->employee;

        // Prepare data for PDF
        $data = [
            'salary_slip' => $salary_slip
        ];
        $pdf = Pdf::loadView('reports.salaryinvoice', $data);

        //get payroll

        $payroll_period=$salary_slip->payrollPeriod;

        // Send email with the PDF attachment
        Mail::to($receiveremail)->send(new SalarySlipMail($salary_slip, $pdf->output(), $payroll_period, $employee ));

        // Add success message to session
        return back()->with('success', 'Salary slip sent successfully to ' . $receiveremail);
    } catch (\Exception $e) {
        // Add error message to session
        return back()->with('error', 'Failed to send salary slip. ' . $e->getMessage());
    }
}

}
