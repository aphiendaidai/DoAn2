<?php

use App\Http\Controllers\company\MainCompany;
use App\Http\Middleware\checkCompany;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Homecontroller;
use App\Http\Controllers\Accountcontroller;
use App\Http\Controllers\JosController;
use App\Http\Controllers\admin\DasboardController;
use App\Http\Middleware\CheckAdmin;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\JobController;
use App\Http\Controllers\admin\JobAppliController;

Route::get('/', [Homecontroller::class, 'index'])->name('home');
Route::get('/job', [JosController::class, 'index'])->name('job');
Route::get('/job/detail/{id}',[JosController::class,'detail'])->name('jobdetail');
Route::post('/apply-job',[JosController::class,'applyJob'])->name('applyJob');

Route::post('/saved-job',[JosController::class,'saveJob'])->name('saveJob');

Route::get('/forget-password',[Accountcontroller::class,'forgetpass'])->name('forgetpass');
Route::post('/processForgotPassword',[Accountcontroller::class,'processForgotPassword'])->name('processForgotPassword');
Route::get('/reset-password/{token}',[Accountcontroller::class,'resetpassword'])->name('resetpassword');

Route::post('/processResetPassword',[Accountcontroller::class,'ProcessresetPassword'])->name('ProcessresetPassword');


Route::middleware([CheckAdmin::class])->group(function () {
  Route::get('/dashbroad', [DasboardController::class,'index'])->name('dashbroad');
  Route::get("/users", [UserController::class,'index'])->name('users');
  Route::get("/users/{id}", [UserController::class,'edit'])->name('users.edit');

  Route::put("/users/{id}",[UserController::class,'update'])->name('users.update');

  Route::delete('/users', [UserController::class,'deleteUser'])->name('users.delete');

  Route::get('/admin/job', [JobController::class,'index'])->name('admin.job');

  Route::get('/admin/edit/{id}', [JobController::class,'edit'])->name('admin.job.edit');

  Route::put('/admin/{id}', [JobController::class,'update'])->name('admin.job.update');

  Route::post('/admin/delete-job', [JobController::class,'deleteAdminJob'])->name('admin.deleteAdminJob');


  Route::get('/admin/jobapplication', [JobAppliController::class,'index'])->name('admin.jobapplication');

  Route::post('/admin/jobapplication', [JobAppliController::class,'delete'])->name('admin.jobapp.delete');

});


Route::middleware([checkCompany::class])->group(function () {
 
  Route::get( '/main', [MainCompany::class, 'index'])->name('company.main');

 Route::get( '/main/create-job', [Accountcontroller::class, 'createJob' ])->name('company.createjjob');

 Route::post('/main/save-job', [Accountcontroller::class, 'saveJob'])->name('company.saveJob');

 Route::get('/main/my-jobs', [Accountcontroller::class, 'myJobs'])->name('company.myJobs');

 Route::post('/update/{id}', [Accountcontroller::class, 'updateJob'])->name('company.updateJob');


  Route::get('/create-job', [Accountcontroller::class, 'createJob'])->name('account.createJob');
  Route::post('/save-job', [Accountcontroller::class, 'saveJob'])->name('account.saveJob');

  Route::get('/my-jobs/edit/{id}', [Accountcontroller::class, 'editJob'])->name('company.editJob');

  Route::post('/delete-job', [Accountcontroller::class,'deleteJob'])->name('company.deleteJob');

});




Route::group(['account'], function () {

  Route::group(['middleware' => 'guest'], function () {
     Route::get('/register', [Accountcontroller::class, 'registration'])->name('account.registration');
     Route::post('/process-register', [Accountcontroller::class, 'processRegistration'])->name('account.processRegistration');
     Route::get('/login', [Accountcontroller::class, 'login'])->name('account.login');
     Route::post('/authenticate', [Accountcontroller::class, 'authenticate'])->name('account.authenticate');
     
  });


  Route::group(['middleware' => 'auth'], function () {

    Route::get('/profile', [Accountcontroller::class, 'profile'])->name('account.profile');

    Route::put('/update-profile', [Accountcontroller::class, 'updateProfile'])->name('account.updateProfile');
    
    Route::get('/logout', [Accountcontroller::class, 'logout'])->name('account.logout');

    Route::post('/update-profile-pic', [Accountcontroller::class, 'updateProfilePic'])->name('account.updateProfilePic');

    // Route::get('/create-job', [Accountcontroller::class, 'createJob'])->name('account.createJob');

    // Route::post('/save-job', [Accountcontroller::class, 'saveJob'])->name('account.saveJob');

    // Route::get('/my-jobs', [Accountcontroller::class, 'myJobs'])->name('account.myJobs');
    // Route::get('/my-jobs/edit/{id}', [Accountcontroller::class, 'editJob'])->name('account.editJob');

    // Route::post('/update/{id}', [Accountcontroller::class, 'updateJob'])->name('account.updateJob');
    // Route::post('/delete-job', [Accountcontroller::class,'deleteJob'])->name('account.deleteJob');
    Route::get('/my-job-applications', [Accountcontroller::class, 'myJobApplications'])->name('account.myJobApplications');
    Route::post('/remove-job', [Accountcontroller::class,'removeJob'])->name('account.removeJob');
    Route::get('/savedJobs', [Accountcontroller::class, 'savedJobs'])->name('account.savedJobs');
    
    Route::post('/remove-save-job', [Accountcontroller::class,'removeSaveJob'])->name('account.removeSaveJob');

    Route::post('/change-password', [Accountcontroller::class, 'changePassword'])->name('account.changePassword');


  });


  
});