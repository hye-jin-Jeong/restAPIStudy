<?php

use Illuminate\Http\Request;
use App\Article;

Route::get('articles', function(){
    return Article::all();
});

Route::get('articles/{id}', function($id){
    return Article::find($id);
});

Route::post('articles', function(Request $request){
    return Article::create($request->all);
});

Route::put('articles/{id}', function(Request $request, $id){
    $article = Article::findOrFail($id);
    $article->update($request->all());

    return $article;
});

Route::delete('articles/{id}', function($id){
    Article::find($id)->delete();

    return 204;
});