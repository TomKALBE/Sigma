<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StepController;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\RedirectIfAuthenticated;
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


Route::get('/', [HomeController::class,'index']);
Route::get('/formation/{id}', [FormationController::class,'index'])->name('formations');



Auth::routes();

Route::middleware([RedirectIfAuthenticated::class])->group(function (){
    Route::get('/contact/', [ContactController::class,'index'])->name('contact');
    Route::post('/contact/send', [ContactController::class,'send']);
});

Route::middleware([Authenticate::class])->group(function (){
    Route::get('/home', [HomeController::class, 'home'])->name('home');
    Route::put('/home/edit/{id}', [HomeController::class, 'edit']);
    Route::delete('/home/delete/{id}', [HomeController::class, 'delete']);
    /*---- Formation ----*/
    Route::post('/formation/add', [FormationController::class,'add']);
    Route::get('/formation/edit/{id}', [FormationController::class,'edit']);

    /*---- Chapter ----*/
    Route::post('/chapter/add/{id}', [ChapterController::class,'add']);
    Route::delete('chapter/delete/{id}', [ChapterController::class,'delete']);
    Route::put('chapter/modify/{id}', [ChapterController::class,'modify']);
    Route::post('/chapter/changeNum/{id}', [ChapterController::class,'changeNum']);
    /*---- Step ----*/
    Route::post('/step/add/', [StepController::class,'add']);
    Route::delete('step/delete/{id}', [StepController::class,'delete']);
    Route::post('/step/get/{id}', [StepController::class,'get']);
    Route::put('/step/modify/{id}', [StepController::class,'modify']);
    Route::post('/step/changeNum/{id}', [StepController::class,'changeNum']);

    /*---- Profile ----*/
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/picture', [ProfileController::class, 'changePicture']);
    Route::put('/profile/bpicture', [ProfileController::class, 'changeBpicture']);
    Route::put('/profile/modifyInfo', [ProfileController::class, 'modifyInfo']);
    Route::put('/changePassword', [ProfileController::class, 'changePassword']);

    Route::middleware([IsAdmin::class])->group(function (){
        Route::get('/register/{id}',[RegisterController::class,('add')]);
        Route::get('/refuse/{id}',[RegisterController::class,('refuse')]);
        Route::get('/admin',[AdminController::class,('index')]);
        Route::get('/manage',[ManageController::class,('index')]);
        Route::post('/category/add', [CategoryController::class,'add']);
        Route::delete('/category/delete/{id}', [CategoryController::class,'delete']);
        Route::put('/category/modify/{id}', [CategoryController::class,'modify']);
        Route::put('/profile/modify/{id}', [ProfileController::class,'modify']);
        Route::delete('/profile/delete/{id}', [ProfileController::class,'delete']);



        /*---- Category ----*/
        Route::post('/category/add/', [CategoryController::class,'add']);

    });

});


