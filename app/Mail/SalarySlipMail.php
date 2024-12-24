<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SalarySlipMail extends Mailable
{
    use Queueable, SerializesModels;

    public $salary_slip;
    public $pdf;
    public $payroll_period;
    public $employee;

    /**
     * Create a new message instance.
     *
     * @param mixed $salary_slip
     * @param string $pdf
     * @param string $payroll_period
     * @param string $employee
     * @return void
     */
    public function __construct($salary_slip, $pdf, $payroll_period, $employee)
    {

        $this->salary_slip = $salary_slip;
        $this->pdf = $pdf;
        $this->payroll_period = $payroll_period;
        $this->employee = $employee;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.salary_slip') // Use a dedicated email view
                    ->with([
                        'salary_slip' => $this->salary_slip,
                        'payroll_period' => $this->payroll_period,
                        'employee' => $this->employee,
                    ])
                    ->attachData($this->pdf, 'Aethon Salary - ' . $this->salary_slip->payrollperiod->month .' '. $this->salary_slip->payrollperiod->year .'.pdf', [
                        'mime' => 'application/pdf',
                    ])
                    ->subject('Aethon Salary - ' . $this->payroll_period->month . ' ' . $this->payroll_period->year); // Use payroll_period dynamically in the subject
    }
}
