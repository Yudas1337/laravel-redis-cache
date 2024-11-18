<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Benchmark;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

Route::get('/cached', function () {

    Cache::remember('categories:all', 3600, fn() => Category::query()->get());
    Cache::remember('products:all', 3600, fn() => Product::query()->get());

    return 'OK!';
});

Route::get('/', function () {
    Benchmark::dd([
        'categories-get' => fn() => Category::query()->get(),
        'products-get' => fn() => Product::query()->get(),
        'cached-categories' => fn() => Cache::get('categories:all'),
        'cached-products' => fn() => Cache::get('products:all'),
    ], 100);
});

