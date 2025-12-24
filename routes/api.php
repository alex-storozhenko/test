<?php

declare(strict_types=1);

use App\CRM\Controllers\AvailablePropertiesController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/properties/available-for-operations',
    [AvailablePropertiesController::class, 'index']
)->middleware('auth:sanctum');
