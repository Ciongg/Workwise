<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLoanInfo extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeLoanInfoFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'loan_type',
        'loan_amount',
        'monthly_amortization',

   
    ];

    public function employee()
{
    return $this->belongsTo(Employee::class);
}
}
