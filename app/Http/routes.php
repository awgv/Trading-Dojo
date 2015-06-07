<?php

Route::get('/', 'GeneralController@index');

Route::get('/item/find', 'AutocompleteItemController@getSearchResults');



Route::controllers([
	'account'  => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::group(['prefix' => 'user'], function () {
	Route::get('status/online'  , 'AccountController@statusOnline');
	Route::get('status/offline' , 'AccountController@statusOffline');
	Route::get('{seller}'       , 'AccountController@seller');
});



Route::group(['prefix' => 'offer'], function () {
	Route::post('publish/guest' , 'OfferController@guestStore');
	Route::post('publish/user'  , 'OfferController@authStore');
	Route::post('remove'        , 'OfferController@remove');
	Route::post('expire'        , 'OfferController@expire');
	Route::post('update'        , 'OfferController@update');
	Route::post('renew'         , 'OfferController@renew');
	Route::get('renew/all'      , 'OfferController@renewAll');
});



Route::group(['prefix' => 'messages'], function () {
	Route::get('/'           , ['as' => 'messages'            , 'uses' => 'MessagesController@messages']);
	Route::post('check'       , ['as' => 'messages.check'      , 'uses' => 'MessagesController@check']);
	Route::post('send/store' , ['as' => 'messages.send.store' , 'uses' => 'MessagesController@store']);
	Route::get('remove/{id}' , ['as' => 'messages.remove'     , 'uses' => 'MessagesController@remove']);
	Route::get('{id}'        , ['as' => 'messages.show'       , 'uses' => 'MessagesController@show']);
	Route::put('{id}'        , ['as' => 'messages.update'     , 'uses' => 'MessagesController@update']);
});



Route::get('/offers/recent/{platform}' , 'OfferController@recent');
Route::get('/{platform}/{item}'        , 'OfferController@get');