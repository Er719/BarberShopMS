<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminPagesController extends Controller
{
    public function appointment(){
        return view('admin_pages.appointment');
    }

    public function barber(){
        return view('admin_pages.barber');
    }

    public function customer(){
        return view('admin_pages.customer');
    }

    public function services(){
        return view('admin_pages.services');
    }
}
