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
        'middle_name',
        'suffix',
        'gender',
        'birthdate',
        'email',
        'phone_number',
        'role',
        'password',
        'address',
        'marital_status',
        'emergency_contact_number',

    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


   

    public function workInfo(){
        return $this->hasOne(EmployeeWorkInfo::class);
    }

    public function bankInfo(){
        return $this->hasOne(EmployeeBankInfo::class);
    }

    public function identificationInfo()    {
        return $this->hasOne(EmployeeIdentificationInfo::class);
    }

    public function loanInfo()    {
        return $this->hasMany(EmployeeLoanInfo::class);
    }
}
