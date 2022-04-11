<?php

use App\Http\Controllers\Api\CandidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'candidate'], function () {

    Route::get(
        '/',
        [CandidateController::class, 'all']
    );

    Route::get(
        '/getStatuses',
        [CandidateController::class, 'getStatuses']
    );

    Route::post(
        '/',
        [CandidateController::class, 'create']
    );

    Route::get(
        '/{id}',
        [CandidateController::class, 'get']
    );

    Route::put(
        '/{id}',
        [CandidateController::class, 'update']
    );

    Route::delete(
        '/{id}/deleteSkills',
        [CandidateController::class, 'deleteSkill']
    );

    Route::put(
        '/{id}/updateStatus',
        [CandidateController::class, 'changeStatus']
    );
});
