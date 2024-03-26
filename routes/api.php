<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommercialController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\TransactionController;

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

Route::post('/logout', [AuthController::class, 'logout']);
Route::get('entreprise/{userId}', [EntrepriseController::class, 'show']);


Route::group(['middleware' => 'auth.custom'], function () {
    //Counting
    Route::get('/clients/count', 'App\Http\Controllers\ClientController@count');
    Route::get('/services/count', 'App\Http\Controllers\ServiceController@count');
    Route::get('/commercials/count', 'App\Http\Controllers\CommercialController@count');
    Route::get('/partners/count', 'App\Http\Controllers\PartnerController@count');
    Route::get('/transactions/count', 'App\Http\Controllers\TransactionController@count');
    //Client
    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/clients', [ClientController::class, 'store']);
    Route::put('/clients/{id}', [ClientController::class, 'update']);
    Route::get('/clients/{id}', [ClientController::class, 'show']);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

    //Service
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);

    //Agent
    Route::get('/agents', [CommercialController::class, 'index']);
    Route::post('/agents', [CommercialController::class, 'store']);
    Route::put('/agents/{id}', [CommercialController::class, 'update']);
    Route::delete('/agents/{id}', [CommercialController::class, 'destroy']);

    //Partners
    Route::middleware('api')->group(function () {
        Route::get('/partners', [PartnerController::class, 'index']);
        Route::post('/partners', [PartnerController::class, 'store']);
        Route::delete('/partners/{id}', [PartnerController::class, 'destroy']);
        Route::put('/partners/{id}', [PartnerController::class, 'update']);
    });

    //Sales Pipelines
    Route::get('/pipelines', [PipelineController::class, 'index']);
    Route::post('/pipelines', [PipelineController::class, 'store']);
    Route::get('/pipelines/{id}', [PipelineController::class, 'show']);
    Route::delete('/pipelines/{id}', [PipelineController::class, 'destroy']);
    Route::put('/pipelines/{pipeline}/steps', [PipelineController::class, 'saveStepOrder']);
    Route::delete('/steps/{id}', [PipelineController::class, 'destroyStep']);
    Route::post('/steps', [PipelineController::class, 'addStep']);
});
Route::get('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// Admin Dashboard Routes
Route::get('/nbclients', [AdminController::class, 'CountClients']);
Route::get('/piechart', [AdminController::class, 'piechart']);
Route::get('/interventionsperday', [AdminController::class, 'countIntervention']);
Route::get('/countinterventions', [AdminController::class, 'countInterventions']);
Route::get('/revenuperdate', [AdminController::class, 'revenues']);

Route::get('/ca', [AdminController::class, 'Ca']);
Route::get('/countservices', [AdminController::class, 'CountServices']);
Route::get('/CountDemands', [AdminController::class, 'CountDemands']);



//CountDemands
Route::get('posts', 'PostController@index');
Route::group(['prefix' => 'post'], function () {
    Route::post('add', 'PostController@add');
    Route::get('edit/{id}', 'PostController@edit');
    Route::post('update/{id}', 'PostController@update');
    Route::delete('delete/{id}', 'PostController@delete');
});

//Transactions
Route::get('/transactions/{pipeline}', [TransactionController::class, 'index']);
Route::post('/transactions', [TransactionController::class, 'store']);

//Auth
Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('forgotpassword', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('resetpassword', [ForgotPasswordController::class, 'sendResetLink'])->name('password.reset');
    //  Route::get('/password/reset', 'Auth\ResetPasswordController@showResetForm')->name('password.request');
    //Route::post('/password/reset', 'ResetPasswordController@reset');
    //  Route::post('/resetpassword/{token}', 'ResetPasswordController@reset');
    Route::post('/resetpassword', [ResetPasswordController::class, 'reset']);




    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
});

Route::group(
    ['prefix' => 'entreprises'],
    function () {
        Route::post('/register', [EntrepriseController::class, 'register']);
        Route::post('/commercial/register', [CommercialController::class, 'register']);
    }
);
