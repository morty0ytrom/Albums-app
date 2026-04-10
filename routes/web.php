<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AlbumController;

Route::get('/', function () {
    return redirect('/albums');
});

//dashboard (breeze)
Route::get('/dashboard', function () {
    return redirect()->route('albums.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// profile (breeze)
Route::middleware('auth')->group(function () {

    // редактирование профиля
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // удаление профиля
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// albums (публичные) //
// главная страница альбомов
Route::get('/albums', [AlbumController::class, 'index'])->name('albums.index');

// albums (защищённые) //
Route::middleware(['auth'])->group(function () {

    // создание альбома
    Route::get('/albums/create', [AlbumController::class, 'create']);
    Route::post('/albums', [AlbumController::class, 'store']);

    // редактирование альбома
    Route::get('/albums/{id}/edit', [AlbumController::class, 'edit']);
    Route::put('/albums/{id}', [AlbumController::class, 'update']);

    // удаление альбома
    Route::delete('/albums/{id}', [AlbumController::class, 'destroy']);
});

Route::get('/albums/fetch', [AlbumController::class, 'fetchFromApi']);
// Route::get('/api/album-info', function () {
//     $title = request()->title;

//     return response()->json([
//         'results' => [
//             'albummatches' => [
//                 'album' => [
//                     [
//                         'artist' => $title,
//                         'image' => [
//                             ['#text' => ''],
//                             ['#text' => ''],
//                             ['#text' => 'https://img.freepik.com/premium-photo/album-cover-cd-design_663277-36600.jpg']
//                         ]
//                     ]
//                 ]
//             ]
//         ]
//     ]);
// });

// auth (breeze)
require __DIR__.'/auth.php';
