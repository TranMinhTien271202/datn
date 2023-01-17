<?php

use Illuminate\Support\Facades\Route;

Route::get('', function () {
    return redirect()->route('admin.dashboard');
});
Route::get('/dashboard', 'Admin\DashboardController@index')->name('dashboard');
Route::get('/logout', ['as'=>'logout','uses'=> 'Admin\LoginController@getLogOut']);

Route::resource('user', 'Admin\UserController');
Route::resource('role', 'Admin\RoleController');
Route::resource('permission', 'Admin\PermissionController');

Route::prefix('candidate')->name('candidate.')->group(function () {
    Route::get('/', 'Admin\CandidateController@index')->name('index');
    Route::get('create', 'Admin\CandidateController@create')->name('create');
    Route::post('store', 'Admin\CandidateController@store')->name('store');
    Route::get('edit/{id}', 'Admin\CandidateController@edit')->name('edit');
    Route::post('update/{id}', 'Admin\CandidateController@update')->name('update');
    Route::delete('/{id}', 'Admin\CandidateController@destroy')->name('destroy');
    Route::post('/{id}', 'Admin\CandidateController@status')->name('status');
});
Route::prefix('company')->name('company.')->group(function () {
    Route::get('/', 'Admin\CompanyController@index')->name('index');
    Route::get('create', 'Admin\CompanyController@create')->name('create');
    Route::post('store', 'Admin\CompanyController@store')->name('store');
    Route::get('edit/{id}', 'Admin\CompanyController@edit')->name('edit');
    Route::post('update/{id}', 'Admin\CompanyController@update')->name('update');
    Route::delete('/{id}', 'Admin\CompanyController@destroy')->name('destroy');
    Route::post('/{id}', 'Admin\CompanyController@status')->name('status');

    Route::get('list-post/{id}', 'Admin\CompanyController@getListPost')->name('getListPost');
});
Route::prefix('blacklist')->name('blacklist.')->group(function () {
    Route::get('candidate', 'Admin\BlacklistController@index_can')->name('index_can');
    Route::get('company', 'Admin\BlacklistController@index_cpn')->name('index_cpn');
});
Route::prefix('skill')->name('skill.')->group(function () {
    Route::get('/', 'Admin\SkillController@index')->name('index');
    Route::get('create', 'Admin\SkillController@create')->name('create');
    Route::post('store', 'Admin\SkillController@store')->name('store');
    Route::get('edit/{id}', 'Admin\SkillController@edit')->name('edit');
    Route::post('update/{id}', 'Admin\SkillController@update')->name('update');
    Route::delete('/{id}', 'Admin\SkillController@destroy')->name('destroy');
});
Route::prefix('major')->name('major.')->group(function () {
    Route::get('/', 'Admin\MajorController@index')->name('index');
    Route::get('create', 'Admin\MajorController@create')->name('create');
    Route::post('store', 'Admin\MajorController@store')->name('store');
    Route::get('edit/{id}', 'Admin\MajorController@edit')->name('edit');
    Route::post('update/{id}', 'Admin\MajorController@update')->name('update');
    Route::delete('/{id}', 'Admin\MajorController@destroy')->name('destroy');
});
Route::prefix('seekerProfile')->name('seekerProfile.')->group(function () {
    Route::get('/', 'Admin\SeekerProfileController@index')->name('index');
    Route::post('update/{id}', 'Admin\SeekerProfileController@update')->name('update');
    Route::delete('/{id}', 'Admin\SeekerProfileController@destroy')->name('destroy');
});
Route::prefix('package')->name('package.')->group(function () {
    // candidate
    Route::prefix('candidate')->name('candidate.')->group(function () {
        Route::get('/', 'Admin\PackageController@index')->name('index');
        Route::get('create', 'Admin\PackageController@create')->name('create');
        Route::post('store', 'Admin\PackageController@store')->name('store');
        Route::get('edit/{id}', 'Admin\PackageController@edit')->name('edit');
        Route::post('update/{id}', 'Admin\PackageController@update')->name('update');
        Route::delete('/{id}', 'Admin\PackageController@destroy')->name('destroy');
        Route::post('/{id}', 'Admin\PackageController@status')->name('status');
    });
    // company
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/', 'Admin\PackageController@indexc')->name('indexc');
        Route::get('create', 'Admin\PackageController@createc')->name('createc');
        Route::post('store', 'Admin\PackageController@storec')->name('storec');
        Route::get('edit/{id}', 'Admin\PackageController@editc')->name('editc');
        Route::post('update/{id}', 'Admin\PackageController@updatec')->name('updatec');
        Route::delete('/{id}', 'Admin\PackageController@destroy')->name('destroy');
        Route::post('/{id}', 'Admin\PackageController@status')->name('status');
    });
});
Route::prefix('feedback')->name('feedback.')->group(function () {
    // company
    Route::prefix('company')->name('company.')->group(function () {
        Route::get('/{id}', 'Admin\FeedbackController@indexc')->name('indexc');
        Route::delete('/{ida}/{id}', 'Admin\FeedbackController@destroy')->name('destroy');
    });
    // candidate
    Route::prefix('candidate')->name('candidate.')->group(function () {
        Route::get('/{id}', 'Admin\FeedbackController@index')->name('index');
        Route::delete('/{ida}/{id}', 'Admin\FeedbackController@destroy')->name('destroy');
    });
});
