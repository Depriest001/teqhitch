<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index() {
        return view('user.certificate.index');
    }

    public function show() {
        return view('user.certificate.show');
    }
}
