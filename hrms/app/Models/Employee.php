<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory;
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'middle_name',
        'suffix',
        'gender',
        'birthdate',
        'phone_number',
        'role',
        'address',
        'marital_status',
        'emergency_contact_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relationship with Work Info
    public function workInfo()
    {
        return $this->hasOne(EmployeeWorkInfo::class, 'employee_id');
    }

    // Relationship with Bank Info
    public function bankInfo()
    {
        return $this->hasOne(EmployeeBankInfo::class, 'employee_id');
    }

    // Relationship with Identification Info
    public function identificationInfo()
    {
        return $this->hasOne(EmployeeIdentificationInfo::class, 'employee_id');
    }

    // Relationship with Payroll Info
    public function payrollInfo()
    {
        return $this->hasOne(Payroll::class);
    }

    // Relationship with Archived Payrolls
    public function archivedPayrolls()
    {
        return $this->hasMany(ArchivedPayroll::class, 'employee_id');
    }

    public function requests()
    {
        return $this->hasMany(EmployeeRequest::class);
    }

    public function overtimeLogs() {
        return $this->hasMany(OvertimeLog::class);
    }

    public function attendances() {
        return $this->hasMany(Attendance::class);
    }
    
}
