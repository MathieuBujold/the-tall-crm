<?php

use App\Enum\AppPermission;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) {
        Session::put('locale', $locale);
        App::setLocale($locale);
        return redirect()->route('home')->with('locale-changed', true);
    }
    return redirect()->route('home');
})->where('locale', 'en|fr')->name('change.lang.direct');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified', 'permission:view_dashboard'])
    ->name('dashboard');

/*
Route::get('test', function () {
    $user = auth()->user();
    $user->givePermission(AppPermission::VIEW_DASHBOARD);
    return 'ok';
})->middleware(['auth', 'verified'])->name('test');
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/users', function () {
        return view('pages.users.index');
    })->middleware('permission:edit_user')->name('users.index');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';
