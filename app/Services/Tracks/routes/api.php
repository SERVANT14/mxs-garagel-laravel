<?php

Route::get('/', 'TracksApi@index');
Route::get('/{track}', 'TracksApi@show');
