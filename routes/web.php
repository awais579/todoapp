<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [CategoryController::class, 'viewTask'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/create_category', [CategoryController::class, 'category'])
    ->middleware(['auth', 'verified'])->name('create_category');

Route::get('/view_category', [CategoryController::class, 'seeCategory'])
    ->middleware(['auth', 'verified'])->name('view_category');

Route::get('/add_task', [CategoryController::class, 'addTask'])
    ->middleware(['auth', 'verified'])->name('add_task');

Route::get('/view_task', [CategoryController::class, 'viewTask'])
    ->middleware(['auth', 'verified'])->name('view_task');

Route::get('/delete_task/{id}', [CategoryController::class, 'deleteTask'])
    ->middleware(['auth', 'verified'])->name('delete_task');

Route::get('/edit_task/{id}', [CategoryController::class, 'editTasks'])
    ->middleware(['auth', 'verified'])->name('edit_tasks');

Route::post('/save_editied/{id}', [CategoryController::class, 'saveEditis'])
    ->middleware(['auth', 'verified'])->name('save_editied');

Route::post('/filter', [CategoryController::class, 'filter'])->middleware(['auth', 'verified'])->name('filter');
// Route::post('/priority_filter', [CategoryController::class, 'PriorityFilter'])->middleware(['auth', 'verified'])->name('priority_filter');

// Route::post('/all', [CategoryController::class, 'all'])->middleware(['auth', 'verified'])->name('get_all');

Route::post('/change_Status', [CategoryController::class, 'changeStatus'])->middleware(['auth', 'verified'])->name('changeStatus');

Route::get('gettasks', [CategoryController::class, 'gettasks'])->middleware(['auth', 'verified'])->name('gettasks');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
