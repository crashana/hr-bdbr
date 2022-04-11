<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => '/',
    'as' => 'candidate.',
    'namespace' => 'App\Http\Controllers\Candidates'
], function () {

    Route::get('/', [
        'uses' => 'CandidateController@index',
        'as' => 'index']);

    Route::get('/datatable', [
        'uses' => 'CandidateController@datatable',
        'as' => 'datatable']);

    Route::post('/get', [
        'uses' => 'CandidateController@get',
        'as' => 'get']);


    Route::post('/store', [
        'uses' => 'CandidateController@store',
        'as' => 'store']);
});
