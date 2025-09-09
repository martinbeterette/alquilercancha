<?php
use Illuminate\Support\Facades\Route;

Route::get('/test-flux', fn () => view('test-flux'));
require __DIR__.'/routes_breeze.php';
require __DIR__.'/routes.php';
