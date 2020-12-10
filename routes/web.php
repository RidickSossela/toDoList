<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middlewere' => 'auth'], function () {
    Route::get('/project', 'ProjectController@index')->name('project');
    
    Route::resource('project', 'ProjectController')->except([
        'create', 'edit'
    ]);

    Route::resource('task', 'TaskController')->except([
        'index', 'create'
    ]);
    Route::get('tasklist/{project}', 'TaskController@list')->name('taskList');

});