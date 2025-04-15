<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BranchController;
use App\Http\Controllers\SalaryController;


Route::get('/',[BranchController::class,'index']);

Route::get('salary',[SalaryController::class,'index']);

Route::post('/salary/store', [SalaryController::class, 'store'])->name('salary.store');
Route::get('allsalary', [SalaryController::class, 'showsalarydata'])->name('salary.index');

