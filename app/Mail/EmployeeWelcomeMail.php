<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Employee;

class EmployeeWelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $employee;
    public $token;
    public function __construct(Employee $employee, String $token)
    {
        $this->employee = $employee;
        $this->token = $token;
    }

    public function build()
    {
        return $this->markdown('email.employee.welcome');
    }
}
