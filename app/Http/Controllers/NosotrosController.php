<?php

namespace App\Http\Controllers;
use Inertia\Inertia;

use Illuminate\Http\Request;

class NosotrosController extends Controller
{
    public function index()
    {
        return Inertia::render('Nosotros', [
            // Aquí puedes pasar datos a la vista Vue si lo necesitas
            'title' => 'Nosotros - Acover',
            'description' => 'Conoce más sobre Acover, nuestra historia, misión y equipo.',
            // Puedes agregar más datos según necesites
        ]);
    }
}
