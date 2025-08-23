<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Livewire\Users\UserIndex;
use App\Livewire\Users\UserCreate;
use App\Livewire\Users\UserEdit;
use App\Http\Middleware\EnsurePasswordIsSet;
use App\Livewire\Roles\RoleCreate;
use App\Livewire\Roles\RoleEdit;
use App\Livewire\Roles\RoleIndex;
use App\Livewire\Roles\RoleShow;
use App\Livewire\Users\UserShow;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Google login
Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-auth/callback', function () {
    $user_google = Socialite::driver('google')->stateless()->user();

    $user = User::withTrashed()->where('email', $user_google->email)->first();

    if ($user) {
        if ($user->trashed()) {
            $user->restore();
            $user->password = null; // limpiar password para forzar al usuario a establecer una nueva
        }
        $user->google_id = $user_google->id;
        $user->name = $user_google->name;
        $user->avatar = $user_google->avatar;
        $user->email_verified_at = now();
        $user->save();
    } else {
        $user = User::create([
            'google_id' => $user_google->id,
            'name' => $user_google->name,
            'email' => $user_google->email,
            'avatar' => $user_google->avatar,
            'email_verified_at' => now(),
        ]);
    }

    Auth::login($user);

    return redirect('/dashboard');
});

// Facebook login
Route::get('/facebook-auth/redirect', function () {
    return Socialite::driver('facebook')->redirect();
});

Route::get('/facebook-auth/callback', function () {
    $user_facebook = Socialite::driver('facebook')->stateless()->user();

    $user = User::withTrashed()->where('email', $user_facebook->email)->first();

    if ($user) {
        if ($user->trashed()) {
            $user->restore();
            $user->password = null;
        }
        $user->facebook_id = $user_facebook->id;
        $user->name = $user_facebook->name;
        $user->avatar = $user_facebook->avatar;
        $user->email_verified_at = now();
        $user->save();
    } else {
        $user = User::create([
            'facebook_id' => $user_facebook->id,
            'name' => $user_facebook->name,
            'email' => $user_facebook->email,
            'avatar' => $user_facebook->avatar,
            'email_verified_at' => now(),
        ]);
    }

    Auth::login($user);

    return redirect('/dashboard');
});


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', EnsurePasswordIsSet::class])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    //Roles
    Route::get("roles", RoleIndex::class)->name("roles.index")->middleware("permission:role.menu|role.view|role.create|relo.edit|role.delete");
    Route::get("roles/create", RoleCreate::class)->name("roles.create")->middleware("permission:role.create");
    Route::get("roles/{id}/edit", RoleEdit::class)->name("roles.edit")->middleware("permission:role.edit");
    Route::get("roles/{id}", RoleShow::class)->name("roles.show")->middleware("permission:role.view");

    //Usuarios
    Route::get("users", UserIndex::class)->name("users.index")->middleware("permission:usuario.menu|usuario.create|usuario.view|usuario.edit|usuario.delete");
    Route::get("users/create", UserCreate::class)->name("users.create")->middleware("permission:usuario.create");
    Route::get("users/{id}/edit", UserEdit::class)->name("users.edit")->middleware("permission:usuario.edit");
    Route::get("users/{id}", UserShow::class)->name("users.show")->middleware("permission:usuario.view");
});

require __DIR__ . '/auth.php';
