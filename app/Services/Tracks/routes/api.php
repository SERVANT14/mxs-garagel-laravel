<?php

Route::get('/categories', 'TrackCategoriesApi@index');
Route::get('/creators', 'CreatorsApi@index');

Route::post('/', 'TracksApi@store');
Route::get('/', 'TracksApi@index');
Route::put('/{track}', 'TracksApi@update');
Route::get('/{track}', 'TracksApi@show');
Route::delete('/{track}', 'TracksApi@destroy');
