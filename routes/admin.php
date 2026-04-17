<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['role:admin','auth']], function () {

    Route::get('/',function(){
        return redirect()->route('admin.dashboard');
    });

});