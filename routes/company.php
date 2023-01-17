<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Company\ProfileController;

Route::get('',"Company\DashboardController@home")->name('home');
Route::get('/dashboard', function () {
    return redirect()->route('company.home');
});
Route::post('/logout',"Company\LoginController@logOut")->name('logOut');
Route::prefix('post')->name('post.')->group(function () {
    Route::get('/','Company\JobPostController@index')->name('index');
    Route::get('create','Company\JobPostController@create')->name('create');
    Route::POST('store','Company\JobPostController@store')->name('store');
    Route::get('edit/{id}','Company\JobPostController@edit')->name('edit');
    Route::post('update/{id}', 'Company\JobPostController@update')->name('update');
    Route::get('profileApply/{id}', 'Company\JobPostController@profileApply')->name('profileApply');
});
Route::get('/favorite','Company\FavoriteController@index')->name('favorite');

Route::get('profile',['as'=>'profile','uses'=>'Company\ProfileController@edit']);
Route::post('profile',['as'=>'profile.update','uses'=>'Company\ProfileController@update']);
Route::get('filter',['as'=>'filter','uses'=>'Company\FilterCvController@index']);
// Route::post('filter',['as'=>'filter.update','uses'=>'Company\ProfileController@update']);

Route::get('image-paper',['as'=>'image-paper','uses'=>'Company\ImagePaperController@index']);
Route::post('image-paper',['as'=>'image-paper.update','uses'=>'Company\ImagePaperController@update']);

Route::get('view-profile-candidate/{id}', 'Company\ViewCvController@viewProfile')->name('viewProfile');

Route::get('view-info-candidate/{id}', 'Company\ViewCvController@viewProfileHidden')->name('viewProfileHidden');

Route::get('manage-cv/', 'Company\ManageCVController@index')->name('manageCV');

Route::get('view-open-cv', 'Company\OpenCvController@index')->name('viewOpenCv');

Route::get('view-open-cv/save-open/{id}', 'Company\OpenCvController@store')->name('SaveOpenCv');

Route::get('package','Company\CoinController@getListPackage')->name('listPackage');
Route::post('insertInvoice','Company\CoinController@insertInvoice')->name('insertInvoice');
Route::post('payment','Company\CoinController@payment')->name('payment');
Route::get('vnpay_return','Company\CoinController@vnpay_return')->name('vnpay_return');
Route::get('vnpay_ipn','Company\CoinController@vnpay_ipn')->name('vnpay_ipn');
Route::get('detail-candidates/{id}', 'Company\DetailCandidateController@index')->name('detail-candidate.index');
Route::get('feedback/{id}','Company\DetailCandidateController@feedback')->name('feedback');
Route::post('feedback/{id}','Company\DetailCandidateController@saveFeedback')->name('saveFeedback');

Route::get('detail-profile/{id}', 'Company\DetailCandidateController@viewHidden')->name('detail-profile.hidden');

Route::get('historyPayment', 'Company\CoinController@historyPayment')->name('historyPayment');


// Route::get('detail-candidates/{$id}',['as'=>'detail-candidate.index', 'uses'=>'Company\DetailCandidateController@index']);

// Route::post('image-paper',['as'=>'image-paper.update','uses'=>'Company\DetailCandidateController@update']);
