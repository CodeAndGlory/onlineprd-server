<?php

namespace App\Http\Controllers;

use App\Mail\AppointmentLetter;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendAppointmentLetter()
    {
        $to_address = 'cmmetivi@uncg.edu';

        Mail::to($to_address)->send(new AppointmentLetter);
    }
}
