<?php

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function()
{
    Route::match(['get', 'post'], '/autocomplete','AjaxController@autocomplete')->name('ajax.autocomplete');
    Route::match(['get', 'post'], '/can-delete','AjaxController@canDelete')->name('ajax.can_delete');
    Route::match(['get', 'post'], '/show-delete-window','AjaxController@showDeleteWindow')->name('ajax.show_delete_window');

    Route::resource('employee', 'EmployeeController',['except' => [
        'create', 'store', 'show'
    ]]);

    Route::match(['get', 'post'], '/edit','TreeController@edit')->name('tree.edit');
    Route::match(['get', 'post'], '/tree','TreeController@tree')->name('tree.tree');
    Route::match(['get', 'post'], '/lazy','TreeController@lazy')->name('tree.lazy');
});

Auth::routes();