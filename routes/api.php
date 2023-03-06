<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\Api\RegistrationController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\CourseObjectiveController;
use App\Http\Controllers\CourseOutcomeController;
use App\Http\Controllers\LecturesController;
use App\Http\Controllers\AssessmentsController;
use App\Http\Controllers\EnrolledStudentsController;
use App\Http\Controllers\AssessmentGradesController;
use App\Http\Controllers\StartEnrollmentController;
use App\Http\Controllers\ObjectiveBreakdownController;
use App\Http\Controllers\assBreakdownController;






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
        Route::get('getFacultyMembers', [UserController::class, ('getAllFacultyMembers')]);
        Route::post('deleteRegUser', [RegistrationController::class, ('deleteRegUser')]);
        Route::post('assignRoletoRegUser', [RegistrationController::class, ('assignRoleToRegisteredUser')]);

        Route::group(['prefix' => 'roles'], function () {
            Route::get('getRoles', [RolesController::class, ('getAllRoles')]);
            Route::post('addRoles', [RolesController::class, ('addrole')]);
            Route::post('deleteTheRole', [RolesController::class, ('deleteRole')]);
        });

        Route::group(['prefix' => 'courses'], function () {
            Route::get('allCourses', [CoursesController::class, ('getAllCourses')]);
            Route::get('allAssignedCourses', [CoursesController::class, ('getAllAssignedCourses')]);
            Route::post('addCourse', [CoursesController::class, ('addCourse')]);
            Route::post('assignCourse', [CoursesController::class, ('assignCourses')]);
            Route::get('getMyCourses', [CoursesController::class, ('getLoggedInUserCourses')]);
            Route::post('addCourseObjectives', [CourseObjectiveController::class, ('addCourseObjective')]);
            Route::post('getCourseObjectives', [CourseObjectiveController::class, ('getCourseObjective')]);
            Route::post('addBreakdownStructure', [ObjectiveBreakdownController::class, ('addBreakdownStructure')]);
      
            // Route::post('addRoles', [RolesController::class, ('addrole')]);
            // Route::post('deleteTheRole', [RolesController::class, ('deleteRole')]);
        });
        Route::group(['prefix' => 'lectures'], function () {
            Route::post('uploadNewLecFileToServer', [LecturesController::class, ('uploadNewLecFile')]);
            Route::post('uploadFileRecordToDatabase', [LecturesController::class, ('uploadFileRecordToDatabase')]);
            Route::get('getCourseOutline', [LecturesController::class, ('getMyOutline')]);
            Route::post('downloadOutlineFile', [LecturesController::class, ('downloadOutlineFile')]);
            Route::post('approveOrRejectOutline', [LecturesController::class, ('approveOrRejectOutline')]);
            
            Route::post('updateLectureOutline', [LecturesController::class, ('updateLectureOutline')]);
            Route::post('uploadMoreLecFile', [LecturesController::class, ('uploadMoreLecFile')]);
           
            

        });
        Route::group(['prefix' => 'assessments'], function () {
            Route::post('uploadAssessmentFiletoServer', [AssessmentsController::class, ('uploadAssessmentFile')]);
            Route::post('addAssessmentsToDatabase', [AssessmentsController::class, ('addAssessment')]);
            Route::get('getAssessments', [AssessmentsController::class, ('getAssessments')]);
            Route::post('downloadAssessmentsFile', [AssessmentsController::class, ('downloadAssessmentFile')]);
            Route::post('sendResultToHod', [AssessmentsController::class, ('sendResultToHod')]);
            Route::post('addAssessmentBreakdown', [assBreakdownController::class, ('addAssessmentBreakdown')]);
          
        });
        Route::group(['prefix' => 'enrolledstudents'], function () {
            Route::get('getAllEnrolledStudents', [EnrolledStudentsController::class, ('getEnrolledStudents')]);
           
            Route::post('enrollNewCourse', [EnrolledStudentsController::class, ('enrollNewCourse')]);
            // Route::get('getAssessments', [AssessmentsController::class, ('getAssessments')]);
            // Route::post('downloadAssessmentsFile', [AssessmentsController::class, ('downloadAssessmentFile')]);
        });
        Route::group(['prefix' => 'assessmentsMarks'], function () {
            Route::post('addAssessmentMarks', [AssessmentGradesController::class, ('addAssessmentMarks')]);
            Route::get('getAssessmentsMarks', [AssessmentGradesController::class, ('getAssessmentsMarks')]);
            Route::get('getEveryInfoWithMarks', [AssessmentGradesController::class, ('getEveryInfoWithMarks')]);
            // Route::post('downloadAssessmentsFile', [AssessmentsController::class, ('downloadAssessmentFile')]);
        });
        Route::group(['prefix' => 'startenrollment'], function () {
            Route::post('addNewStartEnrollmentSchedule', [StartEnrollmentController::class, ('addNewStartEnrollmentSchedule')]);
            Route::get('getAllStartEnrollments', [StartEnrollmentController::class, ('getAllStartEnrollments')]);
            Route::post('updateStartEnrollmentSchedule', [StartEnrollmentController::class, ('updateStartEnrollmentSchedule')]);
            // Route::post('downloadAssessmentsFile', [AssessmentsController::class, ('downloadAssessmentFile')]);
        });

    });
});
