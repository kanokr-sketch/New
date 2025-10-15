<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\c_inController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WorkHourController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// แสดงหน้า Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// ส่งข้อมูล Login
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Routes สำหรับผู้ใช้งานทั่วไป (ต้อง login ก่อน)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // หน้า Dashboard
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

    // ระบบ Check-in / Check-out
    Route::get('/checkin', [c_inController::class, 'showCheckInPage'])->name('c_in.checkin'); // หน้า check-in
    Route::post('/checkin', [c_inController::class, 'checkIn'])->name('c_in.store'); // บันทึก check-in
    Route::post('/checkout', [c_inController::class, 'checkOut'])->name('c_in.checkout'); // บันทึก check-out

    // หน้าแสดงเงินเดือนของพนักงาน
    Route::get('/employee/salary', [EmployeeController::class, 'salaryForm'])->name('employee.salary'); // ฟอร์มเลือกเดือน
    Route::get('/employee/salary/{month}', [EmployeeController::class, 'showSalary'])->name('employee.salary.show'); // แสดงเงินเดือนของเดือนที่เลือก

    // หน้าเพิ่มชั่วโมงการทำงาน (WorkHourController)
    Route::get('/workhours/create', [WorkHourController::class, 'create'])->name('workhours.create'); // ฟอร์มเพิ่มชั่วโมงการทำงาน
    Route::post('/workhours/store', [WorkHourController::class, 'store'])->name('workhours.store'); // บันทึกชั่วโมงการทำงานแบบเดี่ยว
    Route::post('/workhours/store-multiple', [WorkHourController::class, 'storeMultiple'])->name('workhours.storeMultiple'); // บันทึกชั่วโมงการทำงานแบบหลายรายการ
});


/*
|--------------------------------------------------------------------------
| Routes สำหรับ Admin (ต้อง login ก่อน)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth'])->group(function () {

    // แสดงรายชื่อพนักงานทั้งหมด
    Route::get('/employees', [AdminController::class, 'listEmployees'])->name('admin.employee.list');

    // แสดงฟอร์มเพิ่มพนักงาน
    Route::get('/employees/create', [AdminController::class, 'createEmployee'])->name('admin.employee.create');

    // บันทึกพนักงานใหม่
    Route::post('/employees', [AdminController::class, 'storeEmployee'])->name('admin.employee.store');


    // แก้ไขพนักงาน
    Route::get('/employees/{id}/edit', [AdminController::class, 'editEmployee'])->name('admin.employee.edit');
    Route::put('/employees/{id}', [AdminController::class, 'updateEmployee'])->name('admin.employee.update');
    Route::put('/admin/employees/{id}', [AdminController::class, 'updateEmployee'])->name('admin.employee.update');

    // บันทึกพนักงานใหม่
    Route::post('/employees', [AdminController::class, 'storeEmployee'])->name('admin.employee.store');



    // ลบพนักงาน
    Route::delete('/employees/{id}', [AdminController::class, 'deleteEmployee'])->name('admin.employee.destroy');

    // แสดงเงินเดือนของแอดมิน
    Route::get('/salary', [AdminController::class, 'showSalary'])->name('admin.salary');

  // ฟอร์มเลือกพนักงานเพื่อดูเงินเดือน
    Route::get('/salary/employee', [AdminController::class, 'salaryEmployeeForm'])
        ->name('admin.salary.employee.form');

    // แสดงเงินเดือนของพนักงานที่เลือก
    Route::get('/salary/employee/{employeeId}', [AdminController::class, 'showEmployeeSalary'])
        ->name('admin.salary.employee.show');

    Route::get('/workhours/{id}/edit', [WorkHourController::class, 'edit'])->name('workhour.edit');
    Route::put('/workhours/{id}', [WorkHourController::class, 'update'])->name('workhour.update');
    Route::delete('/workhours/{id}', [WorkHourController::class, 'destroy'])->name('workhour.delete');

    Route::get('/admin/salary/all', [AdminController::class, 'showAllEmployeesSalary'])->name('admin.salary.all');

});

Route::get('/employee/profile', [App\Http\Controllers\EmployeeController::class, 'profile'])->name('employee.profile');


Route::get('/employee/profile/edit', [App\Http\Controllers\EmployeeController::class, 'editProfile'])->name('employee.edit.profile');
Route::post('/employee/profile/update', [App\Http\Controllers\EmployeeController::class, 'updateProfile'])->name('employee.update.profile');


