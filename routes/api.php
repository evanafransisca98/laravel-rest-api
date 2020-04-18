<?php

Route::get('/customer', 'CustomerController@index');
Route::post('/customer/created', 'CustomerController@created');
Route::post('/customer/updated', 'CustomerController@updated');
Route::post('/customer/deleted', 'CustomerController@deleted');