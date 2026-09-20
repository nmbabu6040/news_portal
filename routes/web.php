<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\SubscriberController;
use App\Http\Controllers\EpaperController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TagController as AdminTagController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\EpaperController as AdminEpaperController;
use App\Http\Controllers\Admin\SubscriberController as AdminSubscriberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| পাবলিক রুট (সবাই দেখতে পাবে)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/article/{article:slug}', [ArticleController::class, 'show'])->name('article.show');
Route::post('/article/{article:slug}/comment', [CommentController::class, 'store'])->name('comment.store');
Route::get('/author/{user}', [AuthorController::class, 'show'])->name('author.show');
Route::get('/epaper', [EpaperController::class, 'index'])->name('epaper');
Route::post('/subscribe', [SubscriberController::class, 'store'])->name('subscribe');

// SEO / সিন্ডিকেশন
Route::get('/sitemap.xml', [SitemapController::class, 'index']);
Route::get('/feed', [FeedController::class, 'index'])->name('feed');

/*
|--------------------------------------------------------------------------
| Breeze-এর ডিফল্ট রুট (dashboard/profile) — এগুলো রাখা হলো, ডিলিট করবেন না
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| অ্যাডমিন রুট (লগইন প্রয়োজন)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/articles', [AdminArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [AdminArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [AdminArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [AdminArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [AdminArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [AdminArticleController::class, 'destroy'])->name('articles.destroy');
    Route::delete('/photos/{photo}', [AdminArticleController::class, 'destroyPhoto'])->name('photos.destroy');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('/tags', [AdminTagController::class, 'index'])->name('tags.index');
    Route::post('/tags', [AdminTagController::class, 'store'])->name('tags.store');
    Route::put('/tags/{tag}', [AdminTagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{tag}', [AdminTagController::class, 'destroy'])->name('tags.destroy');

    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments.index');
    Route::patch('/comments/{comment}/approve', [AdminCommentController::class, 'approve'])->name('comments.approve');
    Route::delete('/comments/{comment}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/epapers', [AdminEpaperController::class, 'index'])->name('epapers.index');
    Route::post('/epapers', [AdminEpaperController::class, 'store'])->name('epapers.store');
    Route::put('/epapers/{epaper}', [AdminEpaperController::class, 'update'])->name('epapers.update');
    Route::delete('/epapers/{epaper}', [AdminEpaperController::class, 'destroy'])->name('epapers.destroy');

    Route::get('/subscribers', [AdminSubscriberController::class, 'index'])->name('subscribers.index');
    Route::delete('/subscribers/{subscriber}', [AdminSubscriberController::class, 'destroy'])->name('subscribers.destroy');
});

require __DIR__ . '/auth.php';
