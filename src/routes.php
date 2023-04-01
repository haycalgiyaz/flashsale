<?php
// Route::resource('/flashsale', 'Haycalgiyaz\Flashsale\Controllers\FlashSaleController');

// Route::get('testing', 'Haycalgiyaz\Flashsale\Controllers\FlashSaleController@testing');
	Route::get('flash-sale', 'Haycalgiyaz\Flashsale\Controllers\FlashSaleController@index');
	Route::post('flash-sale', 'Haycalgiyaz\Flashsale\Controllers\FlashSaleController@destroy');
	Route::get('flash-sale/datatable', 'Haycalgiyaz\Flashsale\Controllers\FlashSaleController@datatable');
	Route::get('flash-sale/form/{id?}', 'Haycalgiyaz\Flashsale\Controllers\FlashSaleController@form');
	Route::post('flash-sale/form/{id?}', 'Haycalgiyaz\Flashsale\Controllers\FlashSaleController@doForm');
	Route::get('flash-sale/tree/{id?}', 'Haycalgiyaz\Flashsale\Controllers\FlashSaleController@productsTree');

