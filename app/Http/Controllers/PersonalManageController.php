<?php

namespace App\Http\Controllers;

use App\Models\User;

class PersonalManageController extends Controller
{
    public function index()
    {
        $personal = User::where('role', 'personal')->latest()->paginate(10);

        return view('admin.personal.index', compact('personal'));
    }

    // Visualización de la información de registro: el administrador
    // puede consultarla pero no editarla.
    public function show(User $personal)
    {
        abort_unless($personal->role === 'personal', 404);

        return view('admin.personal.show', compact('personal'));
    }
}
