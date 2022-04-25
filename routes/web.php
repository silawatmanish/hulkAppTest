<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['middleware' => ['auth']], function () {
    Route::resource('projects', 'ProjectController');

    Route::get('deleteProject/{id}', 'ProjectController@deleteProject')->name('deleteProject');

    Route::post('update-project/{id}', 'ProjectController@updateProject')->name('update-project');

    Route::get('project/{project_id}/tasks', 'TaskController@index')->name('project.tasks');

    Route::get('project/{project_id}/add-task', 'TaskController@addTask')->name('projects.add-tast');

    Route::post('projects/{project_id}/store-task', 'TaskController@storeTask')->name('projects.store-task');

    Route::get('deleteTask/{id}', 'TaskController@deleteTask')->name('deleteTask');

    Route::get('project/{project_id}/edit-task/{id}', 'TaskController@edit')->name('project.edit-task');

    Route::post('update-task/{project_id}/{id}', 'TaskController@updateTask')->name('project.updatetask');


    Route::get('project/{project_id}/task/{id}/leave-comment', 'TaskController@comment')->name('project.task.leave-comments');

    Route::post('store-comment', 'TaskController@storeComment')->name('store-comment');


    Route::get('get-last-comment', 'TaskController@getLastComment')->name('get-last-comment');

    Route::get('delete-comment', 'TaskController@deleteComment')->name('delete-comment');



    Route::post('store-reply', 'TaskController@storeReply')->name('store-reply');

    
    Route::get('get-last-reply', 'TaskController@getLastReply')->name('get-last-reply');

    Route::get('delete-reply', 'TaskController@deleteReply')->name('delete-reply');


    

});


Route::get('check', 'TaskController@check');





