<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FrontEndController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('front-end.index');
// });

Route::get('/', [FrontEndController::class,'index'])->name('front-end.index');

Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');


// Students Register
Route::prefix('students')->name('students.')->group(function(){
    Route::post('/register',[RegisterController::class,'studentRegister'])->name('register');
    Route::post('/login',[LoginController::class,'studentLogin'])->name('login');
});

// Teacher Registration
Route::prefix('teachers')->name('teachers.')->group(function(){
    Route::post('/register',[RegisterController::class,'teacherRegister'])->name('register');
    Route::post('/login',[LoginController::class,'teacherLogin'])->name('login');
});

Route::prefix('admin')->middleware('checkAdmin')->name('admin.')->group(function(){
    // dashboard
    Route::get('/dashboard', [AdminController::class,'index'])->name('dashboard');
    Route::get('/management', [AdminController::class,'managementView'])->name('management');
    Route::get('/user/approve/{encrypt_id}', [AdminController::class,'statusChange'])->name('user.approve');
    Route::get('/user/delete/{encrypt_id}', [AdminController::class,'teacherDelete'])->name('user.delete');
    Route::get('/user/block/{encrypt_id}', [AdminController::class,'statusChange'])->name('user.block');
    // dipartment
    Route::get('/students/departments', [AdminController::class,'studentsDipartmentShow'])->name('students.dipartments');
    Route::post('/students/department/add', [AdminController::class,'studentsDipartmentAdd'])->name('department.add');
    Route::get('/students/attendance/report', [AdminController::class,'studentsAttendanceAdminSide'])->name('attendance.report');
    Route::post('/students/attendance', [AdminController::class,'getStudentsAttendanceAjax'])->name('getAttendanceAjax');
    Route::get('/department/delete/{encrypt_id}', [AdminController::class,'departmentDelete'])->name('department.delete');

    // Semester
    Route::post('semester/add',[AdminController::class,'addSemester'])->name('semester.add');
    Route::get('semester/delete/{encrypt_id}',[AdminController::class,'deleteSemester'])->name('semester.delete');

    // Subject
    Route::post('subject/add',[AdminController::class, 'subjectAdd'])->name('subject.add');
    Route::get('subject/delete/{encrypt_id}',[AdminController::class, 'subjectDelete'])->name('subject.delete');
});

// Students Attendance
Route::post('semester/get',[AdminController::class,'getSemesterAjax'])->name('getSemester.ajax');
Route::get('students/attendance',[AdminController::class,'studentsAttendanceView'])->name('students.attendance');
Route::post('students/attendance/sheet',[AdminController::class,'attendanceSheet'])->name('students.attendance.sheet');
Route::post('students/attendance/submit',[AdminController::class,'attendanceSubmit'])->name('students.attendance.submit');
Route::get('students/attendance/result',[AdminController::class,'attendanceResult'])->name('students.attendance.report');
Route::post('students/attendance/report-load/',[AdminController::class,'attendanceReportLoad'])->name('students.attendance.result.load');

// Students Result
Route::get('students/result/make',[AdminController::class,'studentResultMake'])->name('student.result.make');
Route::post('students/result/add',[AdminController::class,'studentResultAdd'])->name('students.result.add');
Route::get('student/result/',[AdminController::class,'studentResult'])->name('student.result');

Route::get('/students/result/all',[AdminController::class, 'allStudentResultPage'])->name('all.students.result');
Route::post('/students/result/load',[AdminController::class, 'allStudentResultAjax'])->name('all.student.result.ajax');

Route::view('account','dashboard.account')->name('account.my');
Route::post('account/password/change',[AdminController::class,'passwordChange'])->name('account.password.change');


// Front End Controller
Route::post('student/semesters',[FrontEndController::class,'getSemestersAjax'])->name('student.semester.ajax'); // ajax request

Route::post('/students/get', [AdminController::class,'getStudents'])->name('getStudents.ajax'); // ajax request

// Admin Login
Route::get('admin/login',function(){
    if(Auth::check()) {
        if(auth()->user()->role == 5) {
            return redirect()->route('admin.dashboard');
        }else if(auth()->user()->role == 0 || auth()->user()->role == 1) {
            return redirect()->route('front-end.index');
        }
    }else {
        return view('admin.login');
    }
})->name('admin.login'); 
Route::post('admin/login',[LoginController::class,'adminLogin'])->name('admin.login');

