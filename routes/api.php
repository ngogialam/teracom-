<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProcessesController;
use App\Http\Controllers\Api\V1\FileAttachmentsController;
use App\Http\Controllers\Api\V1\ProcessStepsController;
use App\Http\Controllers\Api\V1\ApprovalProcessController;
use App\Http\Controllers\Api\V1\ProcessChangeLogsController;
use App\Http\Controllers\Api\V1\StepCheckListsController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\StepGroupConditionsController;
use App\Http\Controllers\Api\V1\StepTransferConditionsController;
use App\Http\Controllers\Api\V1\StepObjectsController;
use App\Http\Controllers\Api\V1\TicketHistoryController;
use App\Http\Controllers\Api\V1\TasksController;
use App\Http\Controllers\Api\V1\TaskTimesheetsController;
use App\Http\Controllers\Api\V1\TicketRequestsController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\TaskObjectController;
use App\Http\Controllers\Api\V1\TaskEvaluateController;
use App\Http\Controllers\Api\V1\PermissionController;

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

Route::prefix('v1')->group(function () {

    Route::group(['middleware' => ['jwt.verify']], function () {
        Route::resource('process-change-log', ProcessChangeLogsController::class);
        Route::resource('step-check-list', StepCheckListsController::class);
        Route::resource('step-object', StepObjectsController::class);
        Route::resource('tasks', TasksController::class);
        Route::resource('ticket-request', TicketRequestsController::class);
        Route::resource('process', ProcessesController::class);
        Route::resource('task-timesheet', TaskTimesheetsController::class);
        Route::resource('process-step', ProcessStepsController::class);
        Route::resource('file-attachment', FileAttachmentsController::class);
        Route::resource('step-transfer-condition', StepTransferConditionsController::class);
        Route::resource('permission', PermissionController::class);
        Route::resource('task-object', TaskObjectController::class);
        Route::resource('task-evaluate', TaskEvaluateController::class);
        Route::resource('step-group-condition', StepGroupConditionsController::class);

        Route::post('check-process-short-name', [ProcessesController::class, 'checkProcessShortName']);
        Route::post('process-step-child', [ProcessStepsController::class, 'storeChild']);
        Route::get('approval-process', [ApprovalProcessController::class, 'index']);
        Route::get('process-ticket-request', [TicketRequestsController::class, 'getProcessTicketRequest']);
        Route::get('process-ticket-request/{processId}', [
            TicketRequestsController::class,
            'getProcessTicketRequestDefault'
        ]);
        Route::get('users', [UserController::class, 'index']);
        Route::get('users/{id}', [UserController::class, 'show']);
        Route::put('users/{id}', [UserController::class, 'updateUser']);
        Route::get('departments', [DepartmentController::class, 'index']);
        Route::get('departments/{id}', [DepartmentController::class, 'show']);
        Route::put('department/activate/{id}', [DepartmentController::class, 'activateDepartment']);
        Route::put('department/deactivate/{id}', [DepartmentController::class, 'deactivateDepartment']);
        Route::get('groups-paging', [UserController::class, 'getListGroupsPaging']);
        Route::get('groups', [UserController::class, 'getAllGroups']);
        Route::get('groups/{id}', [UserController::class, 'showGroup']);
        Route::post('groups', [UserController::class, 'storeGroups']);
        Route::put('groups/{id}', [UserController::class, 'updateGroups']);
        Route::delete('groups/{id}', [UserController::class, 'deleteGroup']);
        Route::get('users-of-departments', [UserController::class, 'getUsersByDepartmentIds']);
        Route::get('roles', [RoleController::class, 'index']);
        Route::get('roles-by-department', [RoleController::class, 'getRolesByDepartmentIds']);
        Route::get('ticket-history', [TicketHistoryController::class, 'index']);

        // Auth
        Route::get('profile', [AuthController::class, 'profile'])->name('auth.profile');
    });

    // Auth
    Route::post('login', [AuthController::class, 'login'])->name('auth.login');
});
