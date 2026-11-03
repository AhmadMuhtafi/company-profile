<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectImageController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\SiteController;

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])
            ->name('login');

        Route::post('/login', [AuthController::class, 'login'])
            ->name('login.process');
    });

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

         Route::resource('categories', CategoryController::class)
            ->except(['show']);

        Route::resource('clients', ClientController::class)
            ->except(['show']);

        Route::resource('projects', ProjectController::class)
            ->except(['show']);

        Route::get('/projects/{project}/images', [ProjectImageController::class, 'index'])
            ->name('projects.images.index');
        Route::post('/projects/{project}/images', [ProjectImageController::class, 'store'])
            ->name('projects.images.store');
        Route::put('/project-images/{image}', [ProjectImageController::class, 'update'])
            ->name('project-images.update');
        Route::delete('/project-images/{image}', [ProjectImageController::class, 'destroy'])
            ->name('project-images.destroy');

        Route::resource('services', ServiceController::class)
            ->except(['show']);

        Route::resource('documents', DocumentController::class)
            ->except(['show']);

        Route::resource('messages', MessageController::class)
            ->only(['index', 'show', 'update', 'destroy']);

        Route::get('/settings', [SettingController::class, 'index'])
            ->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])
            ->name('settings.update');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('logout');
    });

});

Route::get('/', [SiteController::class, 'home'])
    ->name('home');

Route::get('/tentang-kami', [SiteController::class, 'about'])
    ->name('about');

Route::get('/layanan', [SiteController::class, 'services'])
    ->name('services');

Route::get('/portofolio', [SiteController::class, 'portfolio'])
    ->name('portfolio.index');

Route::get('/portofolio/{slug}', [SiteController::class, 'project'])
    ->name('portfolio.show');

Route::get('/kontak', [SiteController::class, 'contact'])
    ->name('contact');

Route::post('/kontak', [SiteController::class, 'sendMessage'])
    ->middleware('throttle:5,1')
    ->name('contact.send');