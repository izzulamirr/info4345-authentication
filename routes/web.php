<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login'])
    ->middleware('throttle:login')
    ->name('login');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::resource('todo', TodoController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::view('/two-factor-settings', 'auth.two-factor-setting')->name('two-factor-settings');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::post('/admin/users/{id}/deactivate', [AdminController::class, 'deactivate'])->name('users.deactivate');
    Route::post('/admin/users/{id}/activate', [AdminController::class, 'activate'])->name('users.activate');

    Route::get('/admin/permissions', [AdminController::class, 'permissions'])->name('admin.permissions');
    Route::post('/admin/permissions', [AdminController::class, 'updatePermissions'])->name('admin.permissions.update');
});