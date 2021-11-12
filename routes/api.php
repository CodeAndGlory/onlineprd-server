<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['prefix' => 'v1', 'namespace' => 'API'], function () {
    Route::get('/userinfo', 'UserController@userInfo')->name('user.information');
    Route::get('/countofunverified', 'UserController@countOfUnverified')->name('user.unverified');

    Route::get('/mail', 'LetterController@sendAppointmentLetter');
    Route::get('/letters-by-assignment', 'LetterController@getLettersByAssignment');
    Route::get('/assignments-by-user-term', 'AssignmentController@getAssignmentsByUserTerm');

    Route::apiResource('assignments', 'AssignmentController');
    Route::apiResource('non-course-assignments', 'NonCourseAssignmentController');
    Route::apiResource('comments', 'CommentController');
    Route::apiResource('courses', 'CourseController');
    Route::apiResource('departments', 'DepartmentController');
    Route::apiResource('form-field-lookups', 'FormFieldLookupController');
    Route::apiResource('email-templates', 'EmailTemplateController');
    Route::apiResource('letters', 'LetterController');
    Route::apiResource('offerings', 'OfferingController');
    Route::apiResource('parts-of-term', 'PartOfTermController');
    Route::apiResource('permissions', 'PermissionController');
    Route::apiResource('roles', 'RoleController');
    Route::apiResource('department-user-roles', 'DepartmentUserRoleController');
    Route::apiResource('terms', 'TermController');
    Route::apiResource('users', 'UserController');
    Route::apiResource('tags', 'TagController');
    Route::apiResource('eclasses', 'EclassController');
});
