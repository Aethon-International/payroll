<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\PayrollPeriod;
use App\Models\AdjustmentType;

class SalarySlip extends Model
{
    /** @use HasFactory<\Database\Factories\SalarySlipFactory> */
    use HasFactory;
    protected $fillable = ['employee_id', 'payroll_period_id', 'adjustment_type_id', 'base_salary', 'adjustment_amount', 'net_salary'];


    public function employee()
    {
        return $this->belongsTo(User::class,'employee_id');
    }


    public function payrollPeriod()
    {
        return $this->belongsTo(PayrollPeriod::class,'payroll_period_id');
    }


    public function adjustmentTypes()
    {
        return $this->hasMany(AdjustmentType::class,'employee_id');
    }


}
