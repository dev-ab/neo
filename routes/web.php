<?php

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
Route::middleware(['api'])->group(function() {
    
    //Home route
    Route::get('/', function () {
        return ['hello' => 'world'];
    });
    
    //Neo routes
    Route::get('/neo', 'NeoController@index');
    Route::get('/neo/hazardous', 'NeoController@hazardous');
    Route::get('/neo/fastest', 'NeoController@fastest');
    Route::get('/neo/best-year', 'NeoController@bestYear');
    Route::get('/neo/best-month', 'NeoController@bestMonth');
});
