<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showAllUsers()
    {
		return view('backend.users.show');
    }
}
