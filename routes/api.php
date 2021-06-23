<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DirectoryController;
use App\Http\Controllers\API\FileController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
  
    Route::apiResources([
        'directories' => DirectoryController::class,
    ]);
    Route::post('upload', [FileController::class, 'store']);
    Route::get('folder/{id}/files', [FileController::class, 'index']);
    Route::get('download/{file_id}', [FileController::class, 'downloadFile']);
    Route::post('fileSettings', [FileController::class, 'fileSettings']);
    Route::get('fileSettings', [FileController::class, 'getFileSettings']);



