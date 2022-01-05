<?php
use Illuminate\Support\Facades\Route;

Route::get('/','PageController@index');
Route::get('/category/{slug}','PageController@byCategory');
Route::get('/language/{slug}','PageController@byLanguage');
Route::get('/login','AuthController@showLogin');
Route::post('/login','AuthController@postLogin')->name('login');
Route::get('/register','AuthController@showRegister');
Route::post('/register','AuthController@postRegister')->name('register');
Route::get('/logout','AuthController@logout')->name('logout');

Route::get('/create-article','PageController@createArticle');
Route::post('/create-article','PageController@postArticle')->name('create-article');

