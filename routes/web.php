<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\SummaryEmailController;
use Illuminate\Support\Facades\Route;

// Redirect guests to login
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard'); // authenticated users go to dashboard
    }
    return redirect()->route('login'); // guests go to login
});

Route::get('/test-scheme', function (Illuminate\Http\Request $request) {
    return [
        'laravel_thinks_https' => $request->isSecure(),
        'scheme' => $request->getScheme(),
        'forwarded_proto' => $request->header('X-Forwarded-Proto'),
    ];
});

// Authenticated user routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
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

    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('/subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
    Route::get('/subjects/batch-create', [SubjectController::class, 'batchCreate'])->name('subjects.batch.create');
    Route::post('/subjects/batch-store', [SubjectController::class, 'batchStore'])->name('subjects.batch.store');
    Route::get('/subjects/{subject}', [SubjectController::class, 'show'])->name('subjects.show');
    Route::get('/subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
    Route::put('/subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    //Route::delete('/subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    Route::delete('/subjects/bulk-delete', [SubjectController::class, 'bulkDelete'])->name('subjects.bulkDelete');

    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
    Route::get('/enrollments/create', [EnrollmentController::class, 'create'])->name('enrollments.create');
    Route::post('/enrollments', [EnrollmentController::class, 'store'])->name('enrollments.store');
    Route::get('/enrollments/batch-create', [EnrollmentController::class, 'batchCreate'])->name('enrollments.batch.create');
    Route::post('/enrollments/batch-store', [EnrollmentController::class, 'batchStore'])->name('enrollments.batch.store');
    Route::get('/enrollments/{enrollment}', [EnrollmentController::class, 'show'])->name('enrollments.show');
    Route::get('/enrollments/{enrollment}/edit', [EnrollmentController::class, 'edit'])->name('enrollments.edit');
    Route::put('/enrollments/{enrollment}', [EnrollmentController::class, 'update'])->name('enrollments.update');
    //Route::delete('/enrollments/{enrollment}', [EnrollmentController::class, 'destroy'])->name('enrollments.destroy');
    Route::delete('/enrollments/bulk-delete', [EnrollmentController::class, 'bulkDelete'])->name('enrollments.bulkDelete');

    Route::get('/summary_emails', [SummaryEmailController::class, 'index'])->name('summary_emails.index');
    Route::get('/summary_emails/create', [SummaryEmailController::class, 'create'])->name('summary_emails.create');
    Route::post('/summary_emails', [SummaryEmailController::class, 'store'])->name('summary_emails.store');
    Route::get('/summary_emails/batch-create', [SummaryEmailController::class, 'batchCreate'])->name('summary_emails.batch.create');
    Route::post('/summary_emails/batch-store', [SummaryEmailController::class, 'batchStore'])->name('summary_emails.batch.store');
    Route::get('/summary_emails/{summary_email}', [SummaryEmailController::class, 'show'])->name('summary_emails.show');
    Route::get('/summary_emails/{summary_email}/edit', [SummaryEmailController::class, 'edit'])->name('summary_emails.edit');
    Route::put('/summary_emails/{summary_email}', [SummaryEmailController::class, 'update'])->name('summary_emails.update');
    //Route::delete('/summary_emails/{summary_email}', [SummaryEmailController::class, 'destroy'])->name('summary_emails.destroy');
    Route::delete('/summary_emails/bulk-delete', [SummaryEmailController::class, 'bulkDelete'])->name('summary_emails.bulkDelete');
    Route::post('/summary_emails/bulk-send', [SummaryEmailController::class, 'bulkSend'])->name('summary_emails.bulkSend');

});

// this allows auth routes (login and logout)
require __DIR__.'/auth.php';
