<?php

namespace App\Http\Controllers\Legal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TratamientoDatosController extends Controller
{
    public function index()
    {
        return Inertia::render('Legal/Uso');
    }
}
