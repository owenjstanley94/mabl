<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/results', function () {
    return view('pages.results');
});

Route::get('/fixtures', function () {
    return view('pages.fixtures');
});

Route::get('/teams', function () {
    return view('pages.teams');
});


Route::get('/cup', function () {
    return view('pages.cup');
});

Route::get('/officials', function () {
    return view('pages.officials');
});

Route::get('/organisation', function () {
    return view('pages.organisation');
});

Route::get('/notices', function () {
    return view('pages.notices');
});

