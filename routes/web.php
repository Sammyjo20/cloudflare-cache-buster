<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClearCacheController;

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

Route::match(['get', 'post'], '/clear-zone/{zone}', [ClearCacheController::class, 'clearZone'])->middleware('clearZoneCache')->name('cache.clear');
