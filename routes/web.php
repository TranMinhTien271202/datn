<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/choose-login', 'Client\HomeController@choose')->name('choose');
Route::get('/search/title', 'Client\HomeController@searchByTitle');
Route::get('/search/title-cat/{id}', 'Client\JobController@searchByTitle');

Route::get('/actived/{candidate}/{token}', 'Candidate\RegisterController@actived')->name('actived');
Route::get('404', function () {
    return view('email.404');
});
Route::get('refresh-pass', 'Candidate\RegisterController@refresh')->name('refresh');
Route::post('refresh-pass', 'Candidate\RegisterController@refreshPass')->name('refreshPass');
Route::get('get-pass/{candidate}/{token}', 'Candidate\RegisterController@getPass')->name('getPass');
Route::post('get-pass/{candidate}/{token}', 'Candidate\RegisterController@postPass')->name('postPass');

Route::get('/logout', ['as' => 'logout', 'uses' => 'Client\Auth\LoginController@logout']);
// login google
Route::get('/googleLogin', 'Client\Auth\LoginGoogleController@getGoogleLoginClient')->name('getGoogleLoginClient');
Route::get('/googleLogin/callback', 'Client\Auth\LoginGoogleController@loginClientCallback');

//candidate
Route::get('/', 'Client\HomeController@index')->name('index');
Route::get('/search', 'Client\HomeController@search')->name('search');
Route::get('/send', 'Client\MailController@send')->name('send');
Route::get('/job-speed', 'Client\MailController@jobspeed')->name('jobspeed');
Route::get('/job-speed-apply', 'Client\MailController@speedapply')->name('speedapply');

Route::get('/job', 'Client\JobController@jobPost')->name('job');
Route::get('/job-cat/{id}', 'Client\JobController@job_cat')->name('job-cat');
Route::get('/job-detail/{id}', 'Client\JobController@detail')->name('job-detail');
Route::post('/job-searchs', 'Client\JobController@searchs')->name('searchs');

Route::get('/change-password', 'Client\CandidateController@change')->name('change_password');
Route::post('/update_password', 'Client\CandidateController@update_pass')->name('update_pass');
Route::get('/candidate-detail/{id}', 'Client\CandidateController@detail')->name('detail');
Route::post('/candidate-profile-edit/{id}', 'Client\CandidateController@update')->name('update');
Route::post('/status/{candidate}&{type}', 'Client\CandidateController@status')->name('status');

Route::get('/seeker', 'Client\SeekerController@index')->name('seeker');
Route::post('/seeker', 'Client\SeekerController@store')->name('store');
Route::get('/delete-seeker/{id}', 'Client\SeekerController@destroy')->name('delete_seeker');

Route::middleware(['auth.candidate'])->group(function () {
    
    Route::get('/shortlisted-job', 'Client\ShortlistedController@shortlisted_job')->name('shortlisted_job');
    Route::get('/shortlisted/{id}', 'Client\ShortlistedController@shortlisted')->name('shortlisted');
    Route::get('/delete-shortlisted/{id}', 'Client\ShortlistedController@destroy')->name('delete_shortlisted');
    
    Route::get('/shortlisted-company/{id}', 'Client\ShortlistCompanyController@shortlisted_company')->name('shortlisted_company');
    Route::get('/shortlisted-list-company', 'Client\ShortlistCompanyController@shortlisted')->name('shortlisted_list_company');
    Route::get('/delete-shortlisted-company/{id}', 'Client\ShortlistCompanyController@destroy')->name('delete_shortlisted_company');
    
    Route::get('/applied/{id}', 'Client\JobPostActivitiesController@applied')->name('applied');
    Route::POST('/appliedAJAX', 'Client\JobPostActivitiesController@appliedAjax')->name('appliedAJAX');
    Route::get('/jobApply', 'Client\JobPostActivitiesController@jobApply')->name('jobApply');
    Route::get('/delete-applied-job/{id}', 'Client\JobPostActivitiesController@destroy')->name('delete_applied_jobs');
});


//Client/company
Route::get('/company-list', 'Client\CompanyController@index')->name('company-list');
Route::post('/company-filter', 'Client\CompanyController@filter')->name('company-filter');
Route::get('/company-rate/{id}', 'Client\CompanyController@getRate')->name('getRate');

Route::get('/company-detail/{id}', 'Client\CompanyController@detail')->name('company-detail');
Route::get('/company-feedback/{id}', 'Client\CompanyController@feedback')->name('feedback');
Route::post('/feedback/{id}', 'Client\CompanyController@saveFeedback')->name('saveFeedback');

// Register Client
Route::get('/register', ['as' => 'candidate.register', 'uses' => 'Candidate\RegisterController@getRegister']);
Route::post('/register', ['as' => 'candidate.register.post', 'uses' => 'Candidate\RegisterController@postRegister']);

// login
Route::get('/login/{job_id?}', ['as' => 'candidate.login', 'uses' => 'Client\Auth\LoginController@getLogin']);
Route::post('/login', ['as' => 'candidate.login.post', 'uses' => 'Client\Auth\LoginController@postLogin']);

//company
Route::get('company/register', ['as' => 'company.register', 'uses' => 'Company\RegisterController@getRegister']);
Route::post('company/register', ['as' => 'register.store', 'uses' => 'Company\RegisterController@postRegister']);

Route::get('/actived-company/{candidate}/{token}', 'Company\RegisterController@activeCompany')->name('activeCompany');
Route::get('refresh-pass-company', 'Company\RegisterController@PassCompany')->name('PassCompany');
Route::post('refresh-pass-company', 'Company\RegisterController@PassCompanies')->name('PassCompanies');
Route::get('get-pass-company/{candidate}/{token}', 'Company\RegisterController@getPassCompany')->name('getPassCompany');
Route::post('get-pass-company/{candidate}/{token}', 'Company\RegisterController@postPassCompany')->name('postPassCompany');

Route::get('company/login', ['as' => 'company.login', 'uses' => 'Company\LoginController@getLogin']);
Route::post('company/login', ['as' => 'company.login.post', 'uses' => 'Company\LoginController@postLogin']);

//admin
Route::get('admin/login', ['as' => 'login', 'uses' => 'Admin\LoginController@getLogin']);
Route::post('admin/login', ['as' => 'login.post', 'uses' => 'Admin\LoginController@postLogin']);

// create CV
Route::get('create-cv', 'Client\CreateCvController@createNew')->name('createNew');
// info CV
Route::get('update-cv/{idsee}', 'Client\CreateCvController@index')->name('CreateCV');
Route::post('update-cv/saveInfo', 'Client\CreateCvController@saveInfo')->name('saveInfo');
Route::post('update-cv/updateInfo', 'Client\CreateCvController@updateInfo')->name('updateInfo');

//experiences
Route::post('update-cv/saveExperience', 'Client\CreateCvController@saveExperience')->name('saveExperience');
Route::post('update-cv/updateExperience/{id}', 'Client\CreateCvController@updateExperience')->name('updateExperience');
Route::get('update-cv/deleteExperience/{idsee}', 'Client\CreateCvController@deleteExperience')->name('deleteExperience');

//skills
Route::post('update-cv/saveSkills', 'Client\CreateCvController@saveSkills')->name('saveSkills');
Route::get('update-cv/DeleteAllSkill/{idsee}', 'Client\CreateCvController@DeleteAllSkill')->name('DeleteAllSkill');

//educations
Route::post('update-cv/saveEducation', 'Client\CreateCvController@saveEducation')->name('saveEducation');
Route::post('update-cv/updateEducation/{id}', 'Client\CreateCvController@updateEducation')->name('updateEducation');
Route::get('update-cv/deleteEducation/{id}', 'Client\CreateCvController@deleteEducation')->name('deleteEducation');

//certificates
Route::post('update-cv/saveCertificate', 'Client\CreateCvController@saveCertificate')->name('saveCertificate');
Route::post('update-cv/updateCertificate/{id}', 'Client\CreateCvController@updateCertificate')->name('updateCertificate');
Route::get('update-cv/deleteCertificate/{id}', 'Client\CreateCvController@deleteCertificate')->name('deleteCertificate');

//skill_other
Route::post('update-cv/saveSkillOther', 'Client\CreateCvController@saveSkillOther')->name('saveSkillOther');
Route::post('update-cv/updateSkillOther/{id}', 'Client\CreateCvController@updateSkillOther')->name('updateSkillOther');
Route::get('update-cv/deleteSkillOther/{id}', 'Client\CreateCvController@deleteSkillOther')->name('deleteSkillOther');

//project
Route::post('update-cv/saveProject', 'Client\CreateCvController@saveProject')->name('saveProject');
Route::post('update-cv/updateProject/{id}', 'Client\CreateCvController@updateProject')->name('updateProject');
Route::get('update-cv/deleteProject/{id}', 'Client\CreateCvController@deleteProject')->name('deleteProject');

//tools_used
Route::post('update-cv/saveTools', 'Client\CreateCvController@saveTools')->name('saveTools');
Route::post('update-cv/updateTools/{id}', 'Client\CreateCvController@updateTools')->name('updateTools');
Route::get('update-cv/deleteTools/{id}', 'Client\CreateCvController@deleteTools')->name('deleteTools');

Route::get('update-cv/getPdf/{idsee}', 'Client\CreateCvController@getPdf')->name('getPdf');

Route::get('package', 'Client\CoinController@getListPackage')->name('listPackage');
Route::post('insertInvoice', 'Client\CoinController@insertInvoice')->name('insertInvoice');
Route::post('payment', 'Client\CoinController@payment')->name('payment');
Route::get('vnpay_return', 'Client\CoinController@vnpay_return')->name('vnpay_return');
Route::get('vnpay_ipn', 'Client\CoinController@vnpay_ipn')->name('vnpay_ipn');
// Route::get('detail-candidates/{id}', 'Client\DetailCandidateController@index')->name('detail-candidate.index');
Route::get('historyPayment', 'Client\CoinController@historyPayment')->name('historyPayment');

Route::get('change-language/{language}', 'LanguageController@changeLanguage')->name('change-language');

Route::get('modal_selectCV', 'Client\JobController@modal_selectCV')->name('modal_selectCV');
