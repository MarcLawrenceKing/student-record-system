<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// get method for default route "/"
// run the index method from StudentController
// this route is named students.index that can be used in blade 

Route::get('/', [StudentController::class, 'index'])->name('students.index');

// get method for /students/create
// run the create method from StudentController
// shows the form 
Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');

// Following REST:
// All creation happens via POST /students.
// All updates happen via PUT /students/{id}.
// All deletions happen via DELETE /students/{id}.

// this route is called when create student is submitted
// runs the store method in the StudentController
// stores new student value 
Route::post('/students', [StudentController::class, 'store'])->name('students.store');

// gets the student to be edited by its id
// shows the edit form for a specific student
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');

// saves the updated item 
// triggered when edit form is submitted
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');

// deletes an student item by its id
Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');


// Route::post('students/upload', [StudentController::class, 'uploadCSV'])->name('students.upload');
