<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\CourseObjectiveController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'routes'], function () {
    // User Registraion Routes
    Route::group(['prefix' => 'registration'], function () {
        Route::post('registerNewUser', [RegistrationController::class, ('registeraNewUser')]);
        Route::post('login', [UserController::class, ('login')]);
        Route::post('email/verify-email', [VerifyEmailController::class, ('sendVerificationEmail')]);
    });
    // User Roles Routes
    Route::group(['prefix' => 'users', 'middleware' => 'auth:api'], function () {
        Route::get('getLoggedInUserInfo', [UserController::class, 'userInfo']);
        Route::get('getRegisterdUsers', [RegistrationController::class, ('getAllRegisterdUsers')]);
        Route::get('getVerifiedUsers', [UserController::class, ('getAllUsers')]);
        Route::post('deleteRegUser', [RegistrationController::class, ('deleteRegUser')]);
        Route::post('assignRoletoRegUser', [RegistrationController::class, ('assignRoleToRegisteredUser')]);

        Route::group(['prefix' => 'roles'], function () {
            Route::get('getRoles', [RolesController::class, ('getAllRoles')]);
            Route::post('addRoles', [RolesController::class, ('addrole')]);
            Route::post('deleteTheRole', [RolesController::class, ('deleteRole')]);
        });
        Route::group(['prefix' => 'courses'], function () {
            Route::get('allCourses', [CoursesController::class, ('getAllCourses')]);
            Route::post('addCourse', [CoursesController::class, ('addCourse')]);
            Route::post('assignCourse', [CoursesController::class, ('assignCourses')]);
            Route::get('getMyCourses', [CoursesController::class, ('getLoggedInUserCourses')]);
            Route::post('addCourseObjectives', [CourseObjectiveController::class, ('addCourseObjective')]);
            Route::get('getCourseObjectives', [CourseObjectiveController::class, ('getCourseObjective')]);
            // Route::post('addRoles', [RolesController::class, ('addrole')]);
            // Route::post('deleteTheRole', [RolesController::class, ('deleteRole')]);
        });
    });
});
