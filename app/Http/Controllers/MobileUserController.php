<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MobileUserController extends Controller
{
    //
  

   public function index()
{
    // Exclude the user with the email 'yekhapmandindi@gmail.com'
    $mobileUsers = User::where('email', '!=', 'yekhapmandindi@gmail.com')->get();
    return view('mobile-users.index', compact('mobileUsers'));
}

}
