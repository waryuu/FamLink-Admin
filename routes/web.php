<?php

use App\Http\Controllers\ArticleCT;
use App\Http\Controllers\AssessmentCT;
use App\Http\Controllers\AssessmentDetailCT;
use App\Http\Controllers\AssessmentInstrumenCT;
use App\Http\Controllers\AssesmentResultCT;
use App\Http\Controllers\AuthCT;
use App\Http\Controllers\BannerCT;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuNavigationCT;
use App\Http\Controllers\ReportCT;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserAdminCT;
use App\Http\Controllers\UserAppsCT;

Route::get('/', [AuthCT::class, 'loginView'])->name('login');
Route::get('/login', [AuthCT::class, 'loginView'])->name('login');
Route::post('/login', [AuthCT::class, 'login']);
Route::get('/logout', [AuthCT::class, 'logout']);

Route::group(['middleware' => 'auth'], function () {
    Route::prefix('admin')->group(function () {
        Route::resource('auth', AuthCT::class);
        Route::resource('menu', MenuNavigationCT::class);
        Route::get('menu-up/{id}', [MenuNavigationCT::class, 'up']);
        Route::get('menu-down/{id}', [MenuNavigationCT::class, 'down']);

        Route::resource('role', RoleController::class);
        Route::post('role/save-has-role', [RoleController::class, 'saveHasRole']);
        Route::resource('useradmin', UserAdminCT::class);
        Route::resource('assessment', AssessmentCT::class);
        Route::resource('assessment-detail', AssessmentDetailCT::class);
        Route::resource('assessment-result', AssesmentResultCT::class);
        Route::get('assessment-result/datatable/list/{id}', [AssesmentResultCT::class, 'data']);
        Route::get('assessment-detail/datatable/list/{id}', [AssessmentDetailCT::class, 'data']);
        Route::resource('assessment-instrument', AssessmentInstrumenCT::class);
        Route::get('assessment-instrument/datatable/list/{id}', [AssessmentInstrumenCT::class, 'data']);
        Route::resource('article', ArticleCT::class);
        Route::get('article/datatable/list', [ArticleCT::class, 'data']);
        Route::resource('banner', BannerCT::class);
        Route::get('banner/datatable/list', [BannerCT::class, 'data']);
        Route::resource('report', ReportCT::class);
        Route::get('report/datatable/list', [ReportCT::class, 'data']);
        Route::resource('userapps', UserAppsCT::class);
        Route::get('userapps/datatable/list', [UserAppsCT::class, 'data']);
        Route::get('report/download/excel', [ReportCT::class, 'download']);
        Route::get('report/download/excel/native', [ReportCT::class, 'downloadNative']);
        Route::get('userapps/download/excel', [UserAppsCT::class, 'download']);

    });
});
