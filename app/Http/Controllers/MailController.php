<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SalarySlipMail;
use App\Models\SalarySlip;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;

class MailController extends Controller
{
    public function handleBulkAction(Request $request)
    {
        // Validate the request
        $request->validate([
            'salary_slip_ids' => 'required|array',
            'salary_slip_ids.*' => 'exists:salary_slips,id',
        ]);

        $salarySlipIds = $request->input('salary_slip_ids');

        try {
            // Eager load relationships for efficiency
            $salarySlips = SalarySlip::with(['employee', 'payrollPeriod'])
                ->whereIn('id', $salarySlipIds)
                ->get();

            foreach ($salarySlips as $salarySlip) {
                $receiverEmail = $salarySlip->employee->email;
                $employee = $salarySlip->employee;

                $data = [
                    'salary_slip' => $salarySlip,
                ];
                $pdf = Pdf::loadView('reports.salaryinvoice', $data);
                $payroll_period = $salarySlip->payrollPeriod;

                // Queue email to improve performance
                Mail::to($receiverEmail)->queue(new SalarySlipMail($salarySlip, $pdf->output(), $payroll_period, $employee));
            }

            return back()->with('success', 'Salary slips sent successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to send salary slips: ' . $e->getMessage());
            return back()->with('error', 'Failed to send some salary slips. Please try again.');
        }
    }
}

