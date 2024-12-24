<?php

namespace App\Http\Controllers;
use App\Models\SalarySlip;
use App\Models\Employee;
use App\Models\PayrollPeriod;
use App\Models\AdjustmentType;
use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generatePdf(string $salary_slip_id)
    {
        try {
            // Retrieve the salary slip or fail
            $salarySlip = SalarySlip::findOrFail($salary_slip_id);

            // Data for the view
            $data = [
                'salary_slip' => $salarySlip
            ];

            // Generate the PDF
            $pdf = Pdf::loadView('reports.salaryinvoice', $data);

            // Return the generated PDF for download
            return $pdf->download('Aethon Salary - ' . $salarySlip->payrollperiod->month .' '. $salarySlip->payrollperiod->year .'.pdf');

        } catch (\Exception $e) {
            // Add error message to session if something goes wrong
            return back()->with('error', 'Failed to generate salary slip PDF. ' . $e->getMessage());
        }
    }
}
