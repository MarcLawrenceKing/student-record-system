<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Redirect guests to login
Route::get('/', function () {
    return redirect()->route('login');
})->middleware('guest');

Route::get('/test-scheme', function (Illuminate\Http\Request $request) {
    return [
        'laravel_thinks_https' => $request->isSecure(),
        'scheme' => $request->getScheme(),
        'forwarded_proto' => $request->header('X-Forwarded-Proto'),
    ];
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/batch-create', [StudentController::class, 'batchCreate'])->name('students.batch.create');
    Route::post('/students/batch-store', [StudentController::class, 'batchStore'])->name('students.batch.store');
    Route::get('/students/{student}', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    //Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::delete('/students/bulk-delete', [StudentController::class, 'bulkDelete'])->name('students.bulkDelete');

});

// this allows auth routes (login and logout)
require __DIR__.'/auth.php';
