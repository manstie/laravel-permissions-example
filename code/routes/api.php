<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('admin.')->prefix('admin')->middleware('auth:admin')->group(base_path('routes/admin-api.php'));

Route::middleware(['auth:api,admin'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('company', CompanyController::class);
});
