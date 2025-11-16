<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileManagementController extends Controller
{
      public function index()
    {
        return view('app.profilemanagement');
    }

}
