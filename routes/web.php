<?php

use Illuminate\Support\Facades\Route;
use Spatie\Health\Http\Controllers\HealthCheckJsonResultsController;

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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Auth::routes();

Route::get('/health', HealthCheckJsonResultsController::class);
Route::get('/', [App\Http\Controllers\FileController::class, 'index'])->name('home')->middleware('log');
Route::get('/dashboard', [App\Http\Controllers\FileController::class, 'index'])->name('dashboard')->middleware('log');
//Route::group( ['middleware' => ['auth'] ],function(){
//
//
//    Route::get('/files', [App\Http\Controllers\FileController::class, 'index'])->name('files');
//
//});
Route::group( ['prefix' => 'file','middleware' => ['log'] ],function(){//,'middleware' => ['auth']
    Route::get('/download/{id}', [App\Http\Controllers\FileController::class, 'downloadfile'])->name('file.download');
    Route::delete('/deleteselected', [App\Http\Controllers\FileController::class, 'deleteselectedfiles'])->name('file.deleteselected')->middleware(['file']);
//    Route::get('/downloadselected', [App\Http\Controllers\FileController::class, 'zipDownload'])->name('file.downloadselected');
    Route::post('/save', [App\Http\Controllers\FileController::class, 'savefile'])->name('file.save');
    Route::post('/modify', [App\Http\Controllers\FileController::class, 'modifyfile'])->name('file.modify');
    Route::get('/lockAllSelected', [App\Http\Controllers\FileController::class, 'lock_files'])->name('file.lockAllSelected')->middleware(['file']);
    Route::get('/unlockAllSelected', [App\Http\Controllers\FileController::class, 'unlock_files'])->name('file.unlockAllSelected');


});
Route::resource('group', 'App\Http\Controllers\GroupController')->middleware(['auth','log']);
Route::group( ['prefix' => 'group','middleware' => ['auth','log'] ],function(){
    Route::get('/delete/{id}' ,[App\Http\Controllers\GroupController::class, 'delete'])->name('group.delete')->middleware('group');
    Route::get('/users/{id}',[App\Http\Controllers\Admin\UserController::class, 'getgroupusers'])->name('group.users')->middleware('group');
    Route::get('users/add/{id}',[\App\Http\Controllers\GroupController::class, 'addusersgroup'])->name('users.group.add')->middleware('group');
    Route::post('users/store/{id}',[\App\Http\Controllers\GroupController::class, 'storeusersgroup'])->name('group.store.users')->middleware('group');
    Route::post('users/delete/{id}',[\App\Http\Controllers\GroupController::class, 'deleteusersgroup'])->name('group.delete.user')->middleware('group');
    Route::post('users/store/files/{id}',[\App\Http\Controllers\GroupController::class, 'storefilesgroup'])->name('group.store.files')->middleware('group');
    Route::post('/deletefilegroup/{id}', [App\Http\Controllers\GroupController::class, 'deletefilegroup'])->name('file.groupdelete')->middleware('group');
    Route::get('user/{id}',[\App\Http\Controllers\GroupController::class, 'getusergroup'])->name('user.groups')->middleware('user');
    Route::get('user/files/{id}',[\App\Http\Controllers\GroupController::class, 'getusergroupfiles'])->name('user.group.files')->middleware('group');
    Route::get('user/files/add/{id}',[\App\Http\Controllers\GroupController::class, 'usergroupfilesadd'])->name('user.group.files.add')->middleware('group');


});

Route::group([
    'namespace' => 'App\Http\Controllers\Admin',
    'prefix' => 'admin',
    'middleware' => ['auth','admin','log'],
], function () {
    Route::resource('user', 'UserController');
//    Route::resource('group', 'GroupController');
    Route::get('user/history/{id}',[App\Http\Controllers\Admin\UserController::class, 'getuserhistory'])->name('user.history');
    Route::get('file/history/{id}',[App\Http\Controllers\FileController::class, 'getfilehistory'])->name('file.history');

//
//    Route::get('users',[App\Http\Controllers\Admin\UserController::class, 'index'])->name('user.index');
//    Route::get('users/create',[App\Http\Controllers\Admin\UserController::class, 'create'])->name('user.create');
//    Route::POST('users/store',[App\Http\Controllers\Admin\UserController::class, 'store'])->name('user.store');
//    Route::PUT('users/update{id}',[App\Http\Controllers\Admin\UserController::class, 'update'])->name('user.update');
//    Route::delete('users/destroy',[App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('user.deleteselected');
//    Route::get('user/edit{id}',[App\Http\Controllers\Admin\UserController::class, 'edit'])->name('user.edit');
//    Route::get('user/show{id}',[App\Http\Controllers\Admin\UserController::class, 'show'])->name('user.show');
});
