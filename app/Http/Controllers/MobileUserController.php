<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class MobileUserController extends Controller
{
    //
  

public function index()
{
    // Fetch mobile users and paginate (5 users per page)
    $mobileUsers = User::paginate(5);

    return view('mobile-users.index', compact('mobileUsers'));
}


}
