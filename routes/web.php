<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['title' => 'Home']);
});

Route::get('/posts', function () {
    $posts = Post::latest()->filter(request(['keyword', 'author', 'category']))->paginate(10)->withQueryString();

    return view('posts', ['title' => 'Blog', 'posts' => $posts]);
});

Route::get('/posts/{post:slug}', function (Post $post) {
    return view('post', ['title' => 'Single Post', 'post' => $post]);
});

Route::get('/about', function () {
    return view('about', ['title' => 'About']);
});

Route::get('/contact', function () {
    return view('contact', ['title' => 'Contact Us']);
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', [PostController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');;
// Route::post('/dashboard', [PostController::class, 'store'])->middleware(['auth', 'verified'])->name('dashboard');;
// Route::get('/dashboard/create', [PostController::class, 'create'])->middleware(['auth', 'verified'])->name('dashboard');;
// Route::get('/dashboard/{post:slug}', [PostController::class, 'show'])->middleware(['auth', 'verified'])->name('dashboard');;
// Route::delete('/dashboard/{post:slug}', [PostController::class, 'destroy'])->middleware(['auth', 'verified'])->name('dashboard');;

Route::middleware(['auth', 'verified'])->group(function() {
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');;
    Route::post('/dashboard', [PostController::class, 'store']);
    Route::get('/dashboard/create', [PostController::class, 'create']);
    Route::delete('/dashboard/{post:slug}', [PostController::class, 'destroy']);
    Route::get('/dashboard/{post:slug}/edit', [PostController::class, 'edit']);
    Route::patch('/dashboard/{post:slug}', [PostController::class, 'update']);
    Route::get('/dashboard/{post:slug}', [PostController::class, 'show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
