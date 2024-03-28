<?php

use App\Http\Controllers\PDFCrudController;
use Illuminate\Support\Facades\Auth;
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

Route::get("/user", [PDFCrudController::class, 'index']);
Route::get("/user_list", [PDFCrudController::class, 'user_list']);
Route::post("/add_user", [PDFCrudController::class, 'add_user']);
Route::post("/delete_user", [PDFCrudController::class, 'delete_user']);
Route::post("/edit_user", [PDFCrudController::class, 'edit_user']);


Route::post('/view_pdf', [PDFCrudController::class, 'viewPDF'])->name('view-pdf');
Route::post('/download-pdf', [PDFCrudController::class, 'downloadPDF'])->name('download-pdf');

Route::get('/make_pdf/{id}', [PDFCrudController::class, 'genratePdf']);
Route::get("/user_to_excel/{id}", [PDFCrudController::class, 'user_to_excel']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
