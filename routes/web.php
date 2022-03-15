<?php

use App\Http\Controllers\ArticleCT;
use App\Http\Controllers\AssessmentCT;
use App\Http\Controllers\AssessmentDetailCT;
use App\Http\Controllers\AssessmentInstrumenCT;
use App\Http\Controllers\AssesmentResultCT;
use App\Http\Controllers\AuthCT;
use App\Http\Controllers\BannerCT;
use App\Http\Controllers\CategoryCT;
use App\Http\Controllers\CounselorCT;
use App\Http\Controllers\ConsultationCT;
use App\Http\Controllers\ConsultationDeletedCT;
use App\Http\Controllers\EventCT;
use App\Http\Controllers\FileCT;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MaterialCT;
use App\Http\Controllers\MenuNavigationCT;
use App\Http\Controllers\NotificationCT;
use App\Http\Controllers\ReportCT;
use App\Http\Controllers\ReportConsultationCT;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RulesCT;
use App\Http\Controllers\StakeholderCT;
use App\Http\Controllers\StakeholderGalleryCT;
use App\Http\Controllers\StakeholderMemberCT;
use App\Http\Controllers\StakeholderThreadsCT;
use App\Http\Controllers\StakeholderThreadsDeletedCT;
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

        // PENGEMBANGAN BATCH 2
        // Event
        Route::resource('event', EventCT::class);
        Route::get('event/datatable/list', [EventCT::class, 'data']);

        // Materi
        Route::resource('material', MaterialCT::class);
        Route::get('material/datatable/list', [MaterialCT::class, 'data']);
        Route::resource('material/file', FileCT::class);
        Route::get('material/file/datatable/list/{id}', [FileCT::class, 'data']);
        Route::get('material/{id}/create', [FileCT::class, 'create']);
        Route::post('material/{id}/create', [FileCT::class, 'store']);
        // Kategori Materi
        Route::resource('category', CategoryCT::class);
        Route::get('category/datatable/list', [MaterialCT::class, 'data_category']);

        // Stakeholder deleted threads
        Route::resource('stakeholder/threads/trash', StakeholderThreadsDeletedCT::class);
        Route::get('stakeholder/threads/trash/{id}', [StakeholderThreadsDeletedCT::class, 'getThreadsByID']);
        Route::patch('stakeholder/threads/trash/{id}', [StakeholderThreadsDeletedCT::class, 'restore']);
        // Stakeholder threads
        Route::resource('stakeholder/threads', StakeholderThreadsCT::class);
        Route::get('stakeholder/threads/{id}', [StakeholderThreadsCT::class, 'getThreadsByID']);
        Route::patch('stakeholder/threads/{id}/close', [StakeholderThreadsCT::class, 'closeThreads']);
        Route::patch('stakeholder/threads/{id}/open', [StakeholderThreadsCT::class, 'openThreads']);
        // Stakeholder Members
        Route::resource('stakeholder/members', StakeholderMemberCT::class);
        Route::patch('stakeholder/members/restore/{id}', [StakeholderMemberCT::class, 'restoreMember']);
        // Stakeholder gallery
        Route::resource('stakeholder/gallery', StakeholderGalleryCT::class);
        // Stakeholder
        Route::resource('stakeholder', StakeholderCT::class);
        Route::get('stakeholder/{id}', [StakeholderCT::class, 'getStakeholderByID']);
        Route::get('stakeholder/regencies/{id}', [StakeholderCT::class, 'getRegencyByProvince']);
        Route::patch('stakeholder/restore/{id}', [StakeholderCT::class, 'restoreStakeholder']);

        // Konselor
        Route::resource('counselor', CounselorCT::class);
        Route::patch('counselor/restore/{id}', [CounselorCT::class, 'restore']);
        // Konsultasi deleted
        Route::resource('consultation/trash', ConsultationDeletedCT::class);
        Route::get('consultation/trash/public', [ConsultationDeletedCT::class, 'getPublicConsultation']);
        Route::get('consultation/trash/private', [ConsultationDeletedCT::class, 'getPrivateConsultation']);
        Route::get('consultation/trash/{id}', [ConsultationDeletedCT::class, 'getById']);
        Route::get('consultation/trash/create', [ConsultationDeletedCT::class, 'create']);
        Route::patch('consultation/trash/{id}/restore', [ConsultationDeletedCT::class, 'restore']);
        Route::delete('consultation/trash/replies/{id}', [ConsultationDeletedCT::class, 'deleteReply']);
        // Konsultasi
        Route::get('consultation/public', [ConsultationCT::class, 'getPublicConsultation']);
        Route::get('consultation/private', [ConsultationCT::class, 'getPrivateConsultation']);
        Route::get('consultation/{id}', [ConsultationCT::class, 'getById']);
        Route::patch('consultation/{id}/close', [ConsultationCT::class, 'closeConsultation']);
        Route::patch('consultation/{id}/open', [ConsultationCT::class, 'openConsultation']);
        Route::patch('consultation/{id}/open_user', [ConsultationCT::class, 'makeOtherUserReply']);
        Route::patch('consultation/{id}/close_user', [ConsultationCT::class, 'closeOtherUserReply']);
        Route::delete('consultation/replies/{id}', [ConsultationCT::class, 'deleteReply']);
        Route::resource('consultation', ConsultationCT::class);

        // Notifikasi
        Route::get('notification', [NotificationCT::class, 'index']);
        Route::post('notification/send', [NotificationCT::class, 'sendNotification']);

        // Aturan atau Panduan
        Route::resource('rules', RulesCT::class);

        // Laporan Konsultasi
        Route::get('reportconsultation', [ReportConsultationCT::class, 'index']);
        Route::get('reportconsultation/datatable/list/{type}', [ConsultationCT::class, 'getTypeReportConsultation']);
    });
});
