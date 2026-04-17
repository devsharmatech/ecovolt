<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    else {
        $user = Auth::user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('dealer')) {
            return redirect()->route('dealer.dashboard');
        }
        if ($user->hasRole('accounts')) {
            return redirect()->route('accounts.dashboard');
        }
        if ($user->hasRole('user')) {
            return redirect()->route('user.dashboard');
        }
    }
});

Route::group(['middleware' => 'guest'], function () {
    Route::controller(LoginController::class)->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::post('login', 'loginSubmit')->name('loginSubmit');
    });

});

Route::middleware(['auth'])->group(function () {
    Route::controller(AuthController::class)->group(function () { 
        Route::get('logout','logout')->name('logout');
    }); 
});

Route::group(['middleware' => ['role:user','auth']], function () {
    //
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/',function(){
            return redirect()->route('user.dashboard');
        });

    });
});