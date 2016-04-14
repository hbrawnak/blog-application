<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', function () {
        return view('welcome');
    })->name('home');

    Route::post('/signup', [
        'uses' => 'UserController@postSignUp',
        'as' => 'signup' //as using in form action
    ]);

    Route::post('/signin', [
        'uses' => 'UserController@postSignIn',
        'as' => 'signin'
    ]);

    Route::get('/dashboard', [
        'uses' => 'PostController@getDashboard',
        'as' => 'dashboard',
        'middleware' => 'auth'
    ]);

    Route::post('/createpost', [
        'uses' => 'PostController@postCreatePost',
        'as' => 'post.create',
        'middleware' => 'auth'
    ]);

    Route::get('/delete-post/{post_id}', [
        'uses' => 'PostController@getDeletePost',
        'as' => 'post.delete',
        'middleware' => 'auth'
    ]);

    Route::get('/logout', [
       'uses' => 'PostController@getLogout',
        'as' => 'logout'
    ]);

    Route::post('/edit', [
        'uses' => 'PostController@postEditPost',
        'as' => 'edit'
    ]);

    Route::get('/account', [
        'uses' => 'UserController@userAccount',
        'as' => 'account'
    ]);

    Route::post('/updateaccount', [
        'uses' => 'UserController@postSaveAccount',
        'as' => 'account.save'
    ]);

    Route::get('/userimage/{filename}', [
       'uses' => 'UserController@getUserImage',
        'as' => 'account.image'
    ]);

    Route::get('/profile/{user_id}', [
        'uses' => 'UserController@getUserProfile',
        'as' => 'profile'
    ]);

    Route::get('/update-password', [
        'uses' => 'UserController@getChangePassword',
        'as' => 'password.update'
    ]);

    Route::post('/save-password', [
        'uses' => 'UserController@postUpdatePassword',
        'as' => 'password.save'
    ]);


    //Admin route is below

    Route::get('/admin', function() {
        return view('admin.login');
    } )->name('adminLogin');

    Route::post('/admin.signin', [
        'uses' => 'AdminController@postAdminSignIn',
        'as' => 'adminSignIn'
    ]);

    Route::get('/admin-dashboard', [
        'uses' => 'AdminController@getAdminDashboard',
        'as' => 'adminDashboard',
        'middleware' => 'auth'
    ]);

    Route::get('/active-user/{user_id}', [
        'uses' => 'AdminController@getActiveUser',
        'as' => 'user.active',
        'middleware' => 'auth'
    ]);

    Route::get('/inactive-user/{user_id}', [
        'uses' => 'AdminController@getInactiveUser',
        'as' => 'user.inactive',
        'middleware' => 'auth'
    ]);

    Route::get('/delete-user/{user_id}', [
        'uses' => 'AdminController@getDeleteUser',
        'as' => 'user.delete',
        'middleware' => 'auth'
    ]);

    Route::get('/user-profile/{user_id}', [
        'uses' => 'AdminController@getUserData',
        'as' => 'user-profile'
    ]);

    Route::post('/update-user-profile/{user_id}', [
        'uses' => 'AdminController@postUserData',
        'as' => 'update.user',
        'middleware' => 'auth'
    ]);

    Route::get('/admin.logout', [
        'uses' => 'AdminController@getAdminLogout',
        'as' => 'adminLogout'
    ]);
});
