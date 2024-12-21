<?php

use App\Providers\EurekaService;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});




// Routes CRUD pour le modèle Order
Route::get('/orders', [OrderController::class, 'index']); // Liste toutes les commandes
Route::post('/orders', [OrderController::class, 'store']); // Crée une nouvelle commande
Route::get('/orders/{id}', [OrderController::class, 'show']); // Affiche une commande spécifique
Route::put('/orders/{id}', [OrderController::class, 'update']); // Met à jour une commande spécifique
Route::delete('/orders/{id}', [OrderController::class, 'destroy']); // Supprime une commande spécifique


Route::get('/eureka/register', function () {
    $eurekaService = new EurekaService();
    $statusCode = $eurekaService->register();

    if ($statusCode === 204) {
        return response()->json([
            'message' => 'Application successfully registered with Eureka',
            'status' => $statusCode
        ]);
    }

    return response()->json([
        'message' => 'Failed to register application with Eureka',
        'status' => $statusCode
    ], $statusCode);
});
