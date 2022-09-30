<?php

use App\Models\classrooms;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Grades\GradesController;
use App\Http\Controllers\Sections\SectionsController;
use App\Http\Controllers\Classrooms\ClassroomsController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;



Auth::routes();

// this means that if the user is guest direct him to login page
// if the user is not a guset skip the login page

Route::group(['middleware' => ['guest']], function () {

    Route::get('/', function () {
        return view('auth.login');
    });
});


// this one below ('localeSessionRedirect', 'localizationRedirect', 'localeViewPath') is for translation Pakage

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'auth']
    ],
    function () {

        // =========================== Dashboard ===========================
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        // =========================== Grades ===========================
        Route::resource('Grades', GradesController::class);

        // =========================== Classrooms ===========================
        Route::resource('Classrooms', ClassroomsController::class);
        Route::post('delete_all', [ClassroomsController::class, 'delete_all'])->name('delete_all');
        Route::post('filter_classes', [ClassroomsController::class, 'filter_classes'])->name('filter_classes');

        // =========================== Grades ===========================
        Route::resource('Sections', SectionsController::class);
        Route::get('/GetClasses/{id}', [SectionsController::class, 'GetClasses'])->name('GetClasses');

        // =========================== Parents ===========================
        Route::view('add_parent', 'livewire.show_form');
    }
);
