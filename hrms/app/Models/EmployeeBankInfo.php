<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBankInfo extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeBankInfoFactory> */
    use HasFactory;

    protected $fillable =[
        'employee_id',
        'bank_name',
        'account_number',
        'account_type',
        
    ];

    public function employee()
    {
    return $this->belongsTo(Employee::class);
    }
}
