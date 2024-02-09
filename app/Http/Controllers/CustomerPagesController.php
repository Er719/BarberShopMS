<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerPagesController extends Controller
{
    public function index(){
        return view('customer_pages.index');
    }

    public function booking(){
        return view('customer_pages.booking');
    }

    public function confirm_booking(){
        return view('customer_pages.confirm');
    }

    public function appointments(){
        return view('customer_pages.booking');
    }
}
