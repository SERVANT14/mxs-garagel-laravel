<?php

Route::get('/', 'TracksController@index')->name('tracks');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/create', 'TracksController@create');
    Route::get('{track}', 'TracksController@show')->name('tracks.show');
});

