<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestimonyController extends Controller
{
    public function index()
    {
        return view("admin.testimonies.index");
    }

    public function show1()
    {
        return view("admin.testimonies.show");
    }
}
