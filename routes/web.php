<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\InstructeurController;
use App\Http\Controllers\VoertuigController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/instructeurs', [InstructeurController::class, 'index'])->name('instructeurs.index');
Route::get('/instructeurs/voertuigen', [InstructeurController::class, 'voertuigen'])->name('instructeurs.voertuigen');
Route::get('/instructeurs/voertuigen/toevoegen', [InstructeurController::class, 'toevoegenVoertuig'])->name('instructeurs.voertuigen.toevoegen');
Route::post('/instructeurs/voertuigen/toevoegen', [InstructeurController::class, 'toevoegenVoertuigOpslaan'])->name('instructeurs.voertuigen.toevoegen.opslaan');
Route::get('/instructeurs/voertuigen/wijzig', [InstructeurController::class, 'wijzigVoertuig'])->name('instructeurs.voertuigen.wijzig');
Route::post('/instructeurs/voertuigen/wijzig', [InstructeurController::class, 'wijzigVoertuigOpslaan'])->name('instructeurs.voertuigen.wijzig.opslaan');
Route::post('/instructeurs/voertuigen/verwijder', [InstructeurController::class, 'verwijderVoertuig'])->name('instructeurs.voertuigen.verwijder');
Route::get('/voertuigen', [VoertuigController::class, 'index'])->name('voertuigen.index');
Route::post('/voertuigen/verwijder', [VoertuigController::class, 'verwijder'])->name('voertuigen.verwijder');
