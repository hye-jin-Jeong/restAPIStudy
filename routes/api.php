<?php

use Illuminate\Http\Request;
use App\Article;

// Route::get('articles', function(){
//     return Article::all();
// });

// Route::get('articles/{id}', function($id){
//     return Article::find($id);
// });

// Route::post('articles', function(Request $request){
//     return Article::create($request->all);
// });

// Route::put('articles/{id}', function(Request $request, $id){
//     $article = Article::findOrFail($id);
//     $article->update($request->all());

//     return $article;
// });

// Route::delete('articles/{id}', function($id){
//     Article::find($id)->delete();

//     return 204;
// });

// Route::get('articles', 'ArticleController@index');
// Route::get('articles/{id}', 'ArticleController@show');
// Route::post('articles', 'ArticleController@store');
// Route::put('articles/{id}', 'ArticleController@update');
// Route::delete('articles/{id}', 'ArticleController@delete');



Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');

Route::middleware('auth:api')->get('/user', function(Request $request){
    return $request->user();
});

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('articles', 'ArticleController@index');
    Route::get('articles/{article}', 'ArticleController@show');
    Route::post('articles', 'ArticleController@store');
    Route::put('articles/{article}', 'ArticleController@update');
    Route::delete('articles/{article}', 'ArticleController@delete');
});