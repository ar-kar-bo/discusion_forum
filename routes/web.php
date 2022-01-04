<?php
use Illuminate\Support\Facades\Route;

Route::get('/','PageController@index');
Route::get('/login','AuthController@showLogin');
Route::post('/login','AuthController@postLogin')->name('login');
Route::get('/register','AuthController@showRegister');
Route::post('/register','AuthController@postRegister')->name('register');
Route::get('/logout','AuthController@logout')->name('logout');
