<?php

use App\Models\ArticleLike;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/','PageController@index');
Route::get('/article/{slug}','PageController@detail');
Route::get('/category/{slug}','PageController@byCategory');
Route::get('/language/{slug}','PageController@byLanguage');

Route::get('/login','AuthController@showLogin');
Route::post('/login','AuthController@postLogin')->name('login');
Route::get('/register','AuthController@showRegister');
Route::post('/register','AuthController@postRegister')->name('register');
Route::get('/logout','AuthController@logout')->name('logout');

Route::get('/create-article','PageController@createArticle');
Route::post('/create-article','PageController@postArticle')->name('create-article');

Route::get('/article/like/{id}','PageController@like');
Route::get('/articleliked','PageController@byLiked');

Route::get('/test/{id}',function($id){
    return ArticleLike::where('user_id',Auth::user()->id)->where('article_id',$id)->first();
});
