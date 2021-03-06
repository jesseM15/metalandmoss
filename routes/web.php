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

Route::get('/', 'PagesController@home');

Route::get('/cart', 'PagesController@cart');

Route::get('/calendar', 'PagesController@calendar');

Route::get('/schedules', 'PagesController@getSchedules');
Route::post('/save-schedule', 'PagesController@saveSchedule');
Route::post('/delete-schedule', 'PagesController@deleteSchedule');

Route::post('/contact', 'PagesController@contact');

// Route::get('{path?}', 'PagesController@index')->where('path', '.*');
