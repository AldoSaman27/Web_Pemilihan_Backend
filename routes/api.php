<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\PemilihController;
use App\Http\Controllers\VotingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post("/v2/auth/register", [UserController::class, "register"]);
Route::post("/v2/auth/login", [UserController::class, "login"]);
Route::post("/v2/auth/logout", [UserController::class, "logout"]);
Route::post("/v2/auth/statusToken", [UserController::class, "statusToken"]);

Route::post("/v2/kandidat/store", [KandidatController::class, "store"]);
Route::get("/v2/kandidat/index", [KandidatController::class, "index"]);
Route::get("/v2/kandidat/show/{id}", [KandidatController::class, "show"]);
Route::post("/v2/kandidat/update/{id}", [KandidatController::class, "update"]);
Route::delete("/v2/kandidat/destroy/{id}", [KandidatController::class, "destroy"]);

Route::post("/v2/pemilih/store", [PemilihController::class, "store"]);
Route::get("/v2/pemilih/index", [PemilihController::class, "index"]);
Route::get("/v2/pemilih/show/{id}", [PemilihController::class, "show"]);
Route::post("/v2/pemilih/update/{id}", [PemilihController::class, "update"]);
Route::delete("/v2/pemilih/destroy/{id}", [PemilihController::class, "destroy"]);

Route::post("/v2/voting/store", [VotingController::class, "store"]);
Route::get("/v2/voting/index", [VotingController::class, "index"]);