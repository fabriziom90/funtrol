<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class AdministrationController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Index');
    }
}
