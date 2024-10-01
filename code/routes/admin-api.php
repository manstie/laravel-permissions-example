<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;


Route::apiResource('company', CompanyController::class);
