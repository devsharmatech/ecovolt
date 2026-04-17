<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:vendor','auth']], function () {

    Route::get('/',function(){
        return redirect()->route('vendor.dashboard');
    });

});