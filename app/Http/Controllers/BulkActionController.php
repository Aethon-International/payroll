<?php

namespace App\Http\Controllers;

use App\Models\SalarySlip;
use App\Models\Employee;
use App\Models\PayrollPeriod;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SalarySlipMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;


class BulkActionController extends Controller
{
    // Handle bulk action (send emails or generate PDFs)
    public function handleBulkAction(Request $request)
    {


        $salarySlipIds = $request->input('selected_salary_slips');
        $action = $request->input('action');

        try {
            // Eager load relationships for efficiency
            $salarySlips = SalarySlip::with(['employee', 'payrollPeriod'])
                ->whereIn('id', $salarySlipIds)
                ->get();

            // Perform the corresponding action (send emails or generate PDFs)
            if ($action === 'send_email') {
                $this->sendEmails($salarySlips);
                return back()->with('success', 'Salary slips sent successfully.');
            }
            elseif ($action === 'generate_pdf') {
                $this->generatePdfs($salarySlips);
                return redirect('public/Salary_Slips.zip' );
            }

        } catch (\Exception $e) {

            return back()->with('error', 'Failed to process the request. Please try again.');
        }
    }


    // Method to send emails for the selected salary slips
    private function sendEmails($salarySlips)
    {
        foreach ($salarySlips as $salarySlip) {

            $receiverEmail = $salarySlip->employee->email;
            $employee = $salarySlip->employee;
            $payrollPeriod = $salarySlip->payrollPeriod;

            $data = [
                'salary_slip' => $salarySlip,
            ];
            $pdf = Pdf::loadView('reports.salaryinvoice', $data);

            // Queue email to improve performance
            Mail::to($receiverEmail)->send(new SalarySlipMail($salarySlip, $pdf->output(), $payrollPeriod, $employee));
        }
    }

    // Method to generate PDFs for the selected salary slips
    private function generatePdfs($salarySlips)
    {
        $zipFileName = 'Salary_Slips.zip'; // Name of the ZIP file
        $zipFilePath = public_path($zipFileName); // Full path to save the ZIP file

        $zip = new ZipArchive;

        //forname change to avoid replace file
        $i=1;
        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($salarySlips as $salarySlip) {
                // Prepare data for the PDF
                $data = ['salary_slip' => $salarySlip];

                // Generate PDF content using the salary slip data
                $pdf = Pdf::loadView('reports.salaryinvoice', $data);

                // Create a unique filename for each PDF
                $fileName = 'Aethon_Salary_'
                            . $salarySlip->payrollPeriod->month . '_'
                            . $salarySlip->payrollPeriod->year . '_'.$i
                            . $salarySlip->employee->id . '.pdf';

                // Add PDF to the ZIP file
                $i =$i+1;
                $zip->addFromString($fileName, $pdf->output());
            }

            // Close the ZIP file after adding all PDFs
            $zip->close();

            // Serve the ZIP file for download and delete it after sending


        } else {
            return back()->with('error', 'Failed to create ZIP file.');
        }
    }
}
