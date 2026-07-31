<?php

namespace App\Http\Controllers\Enseignant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MatiereController extends Controller
{
    /**
     * Affiche la liste des matières enseignées par l'enseignant connecté,
     * avec les classes concernées pour chacune
     */
    public function index()
    {
        $matieres = Auth::user()->consulterMatieres()->load('enseignements.classe');

        return view('enseignant.matieres.index', compact('matieres'));
    }
}