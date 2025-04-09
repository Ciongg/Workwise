<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeIdentificationInfo extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeIdentificationInfoFactory> */
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'sss_number',
        'pag_ibig_number',
        'philhealth_number',
        'tin_number',
       
    ];
}
