<?php

use App\Http\Controllers\PersonaController;
use Illuminate\Support\Facades\Route;

Route::post('/personas', [PersonaController::class, 'store'])->name('api.personas.store');