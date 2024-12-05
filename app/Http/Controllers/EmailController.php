<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\TestEmail;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function sendEmail()
    {
        Mail::to('bece19-pmandindi@mubas.ac.mw')->send(new TestEmail());
         return redirect()->route('attendance')->with('success', 'Email has been sent.');
    }

     public function viewResults()
    {
        return view('view-results');
    }
}
