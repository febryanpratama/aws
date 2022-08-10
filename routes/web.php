<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('login');
});

// Generated routes for authentication
Auth::routes();

// For development purposes
Route::get('test', 'DeveloperController@test')->name('test');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
Route::middleware('CheckLevel:user,admin')->group(function () {
    Route::get('dashboard', 'HomeController@index')->name('dashboard');
    Route::get('fileOrder', 'HomeController@fileOrder')->name('fileOrder');
    Route::post('fileOrder', 'HomeController@fileOrderPost')->name('fileOrderPost');
    Route::get('fileManager', 'HomeController@fileManager')->name('fileManager');
    Route::get('fileManager/search', 'HomeController@fileManagerSearch')->name('fileManagerSearch');
    Route::get('attendanceHistory', 'HomeController@attendanceHistory')->name('attendanceHistory');
    Route::post('attendance-out', 'HomeController@attendanceOut')->name('attendanceOut');
    Route::get('settings', 'HomeController@settings')->name('settings');
    Route::post('fileOrderUpload/{id}', 'HomeController@fileOrderUpload')->name('fileOrderUpload');
    Route::post('settings', 'HomeController@settingsPost')->name('settingsPost');

    Route::post('settings/esign/save', 'HomeController@esignPost')->name('esignPost');

    Route::get('fileOrderHistory', 'HomeController@fileOrderHistory')->name('fileOrderHistory');
    Route::get('fileOrderCancel/{id}', 'HomeController@fileOrderCancel')->name('fileOrderCancel');
    Route::get('fileOrderCompleted/{id}', 'HomeController@fileOrderCompleted')->name('fileOrderCompleted');
    Route::post('fileOrderComment/{id}', 'HomeController@fileOrderComment')->name('fileOrderComment');


    Route::get('dailyActivities', 'DailyActivityController@index')->name('dailyActivities');
    Route::post('dailyActivities', 'DailyActivityController@store')->name('dailyActivitiesPost');
    Route::post('dailyActivityUpdate/{id}', 'DailyActivityController@update')->name('dailyActivityUpdate');
    Route::get('dailyActivityDelete/{id}', 'DailyActivityController@destroy')->name('dailyActivityDelete');

    Route::get('permission', 'PermissionController@index')->name('permission.index');
    Route::post('permission/store', 'PermissionController@store')->name('permission.store');
    Route::get('permission/delete/{id}', 'PermissionController@destroy')->name('permission.destroy');

    Route::get('weeks', 'WeekController@index')->name('weeks.index');
    Route::get('weeks/timesheet/{month}/{year}', 'WeekController@timesheet')->name('weeks.timesheet');
    Route::post('weeks/store', 'WeekController@store')->name('weeks.store');
    Route::get('weeks/{id}/edit', 'WeekController@edit')->name('weeks.edit');
    Route::get('weeks/{id}/delete', 'WeekController@destroy')->name('weeks.delete');

    Route::get('weeks/{id}/activity', 'WeekActivityController@index')->name('weeks_activity.index');
    Route::post('weeks/{id}/activity/update', 'WeekActivityController@update')->name('weeks_activity.update');
});

Route::middleware('CheckLevel:admin')->group(function () {

    Route::group([

        'prefix' => 'user',
    ], function () {
        Route::get('/', [UserController::class, 'index'])->name('user.index');
    });


    Route::get('fileOrderReview', 'HomeController@fileOrderReview')->name('fileOrderReview');
    Route::post('fileOrderReview/{id}', 'HomeController@fileOrderReviewPost')->name('fileOrderReviewPost');
    // fileOrderReview
    Route::get('userAttendance', 'HomeController@userAttendance')->name('userAttendance');
    Route::get('attendanceSearch', 'HomeController@attendanceSearch')->name('attendanceSearch');
    //     Route::get('fileOrderHistory', 'HomeController@fileOrderHistory')->name('fileOrderHistory');
    //     Route::get('fileOrderCancel/{id}', 'HomeController@fileOrderCancel')->name('fileOrderCancel');
    //     Route::get('fileOrderCompleted/{id}', 'HomeController@fileOrderCompleted')->name('fileOrderCompleted');
    //     Route::post('fileOrderComment/{id}', 'HomeController@fileOrderComment')->name('fileOrderComment');
});
