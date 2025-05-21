<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamController;
use App\Livewire\OfficialProfile;
use App\Models\Official;

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/fixtures', function () {
    return view('pages.fixtures');
});

Route::get('/teams', function () {
    return view('pages.teams');
});

Route::get('/teams/{team:slug}', [TeamController::class, 'show'])->name('teams.show');

Route::get('/cup', function () {
    return view('pages.cup');
});

Route::get('/officials', function () {
    return view('pages.officials');
});

Route::get('/organisation', function () {
    return view('pages.organisation');
});

Route::get('/notices', [\App\Http\Controllers\NoticeController::class, 'index'])->name('notices.index');
Route::get('/notices/{notice:slug}', [\App\Http\Controllers\NoticeController::class, 'show'])->name('notices.show');

Route::get('/officials/{official:slug}', function (Official $official) {
    return view('officials.show', compact('official'));
})->name('officials.show');

