<?php

use App\Http\Controllers\LogEntryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('entries.index');
});

Route::resource('entries', LogEntryController::class);
