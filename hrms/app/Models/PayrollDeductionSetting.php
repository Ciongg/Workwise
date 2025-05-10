<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollDeductionSetting extends Model
{
    protected $fillable = [
        'sss_rate',
        'philhealth_rate',
        'pagibig_rate',
        'withholding_tax_rate',
    ];

}
