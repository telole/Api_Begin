<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

route::post('register', [AuthController::class, 'Signup']);
route::post('login', [AuthController::class, 'Login']);

route::post('logout', [AuthController::class, 'Logout']);

route::get('artikel', [ArtikelController::class, 'index']);
route::post('artikel/create', [ArtikelController::class, 'store']);  
route::get('artikel/{id}', [ArtikelController::class, 'show']);  
route::put('artikel/{id}', [ArtikelController::class, 'update']);  
route::delete('artikel/{id}', [ArtikelController::class, 'destroy']);  
route::get('artikels', [ArtikelController::class, 'search']); 

Route::middleware('auth:sanctum')->group( function() {
});
