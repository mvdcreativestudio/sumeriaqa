<?php

namespace App\Http\Controllers\RecursosHumanos;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RecursosHumanosController extends Controller
{
    public function dashboard ()
    {
        return view ('admin.recursos-humanos.dashboard');
    }

    public function gestion ()
    {
        return view ('admin.recursos-humanos.gestion');
    }

    public function salarios ()
    {
        return view ('admin.recursos-humanos.salarios');
    }

    public function horarios ()
    {
        return view ('admin.recursos-humanos.horarios');
    }

    public function vacaciones ()
    {
        return view ('admin.recursos-humanos.vacaciones');
    }

    public function faltas ()
    {
        return view ('admin.recursos-humanos.faltas');
    }
}
