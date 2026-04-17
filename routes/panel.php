<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\WhiteLabelSettingController;
use App\Http\Controllers\NotificationSettingController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DiscountOfferController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SolarPricingController;
use App\Http\Controllers\GstController;
use App\Http\Controllers\PaymentSettingController;
use App\Http\Controllers\DiscountSettingController;
use App\Http\Controllers\AccountController;

Route::controller(DashboardController::class)->group(function () {
    Route::get('/dashboard', 'dashboard')->name('dashboard');
});

Route::controller(SolarPricingController::class)->prefix('pricings')->name('pricings.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
});

Route::controller(GstController::class)->prefix('gst')->name('gst.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/update', 'update')->name('update');
});

Route::controller(PaymentSettingController::class)->prefix('payments')->name('payments.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/update', 'update')->name('update');
});

Route::controller(DiscountSettingController::class)->prefix('discounts')->name('discounts.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/update', 'update')->name('update');
});
Route::controller(ProfileController::class)->group(function () {
    Route::get('/profile', 'profile')->name('profile');
    Route::post('/profile/update', 'updateProfile')->name('profile.update');
    Route::post('/profile/update-profile', 'updateAvatar')->name('profile.update-avatar');
    Route::post('/profile/change-password', 'changePassword')->name('profile.change-password');
});

Route::resource('roles', RoleController::class);
Route::resource('permissions', PermissionController::class);

Route::prefix('users')->name('users.')->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{user}', 'show')->name('show');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
        Route::patch('/{user}/status', 'updateStatus')->name('status');
    });

});

// Quote Management
Route::get('quotes/{id}/download', [\App\Http\Controllers\Admin\QuoteController::class, 'download'])->name('quotes.download');
Route::resource('quotes', \App\Http\Controllers\Admin\QuoteController::class);

    Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('vendors/create', [VendorController::class, 'create'])->name('vendors.create');
    Route::post('vendors', [VendorController::class, 'store'])->name('vendors.store');
    Route::get('vendors/{id}', [VendorController::class, 'show'])->name('vendors.show');
    Route::get('vendors/{id}/edit', [VendorController::class, 'edit'])->name('vendors.edit');
     Route::put('vendors/{user}', [VendorController::class, 'update'])->name('vendors.update');
   Route::delete('vendors/{user}', [VendorController::class, 'destroy'])
    ->name('vendors.destroy');

   

    
    // Vendor status update
    Route::post('vendors/{id}/status', [VendorController::class, 'updateStatus'])->name('vendors.status');
    
    // Vendor verification
    Route::post('vendors/{vendor}/verify', [VendorController::class, 'verify'])->name('vendors.verify');



Route::get('/leads', [LeadController::class, 'index'])->name('leads.index');
Route::get('/leads/create', [LeadController::class, 'create'])->name('leads.create');
Route::post('/leads', [LeadController::class, 'store'])->name('leads.store');
Route::get('/leads/{lead}', [LeadController::class, 'show'])->name('leads.show');
Route::get('/leads/{lead}/edit', [LeadController::class, 'edit'])->name('leads.edit');
Route::put('/leads/{lead}', [LeadController::class, 'update'])->name('leads.update');
Route::delete('/leads/{lead}', [LeadController::class, 'destroy'])->name('leads.destroy');
Route::post('/leads/{id}/quick-assign', [LeadController::class, 'quickAssign'])->name('leads.quick-assign');

// Additional routes
Route::post('/leads/{lead}/assign', [LeadController::class, 'assign'])->name('leads.assign');
Route::post('/leads/{lead}/archive', [LeadController::class, 'archive'])->name('leads.archive');
Route::get('/leads/export', [LeadController::class, 'export'])->name('leads.export');
Route::get('/leads-import', [LeadController::class, 'showImportForm'])->name('leads.import.form');
Route::post('/leads/import', [LeadController::class, 'import'])->name('leads.import');
Route::get('/leads/download-template', [LeadController::class, 'downloadTemplate'])->name('leads.download-template');



Route::get('documents', [DocumentController::class, 'index'])->name('documents.index');
Route::get('documents/create', [DocumentController::class, 'create'])->name('documents.create');
Route::post('documents', [DocumentController::class, 'store'])->name('documents.store');
Route::get('documents/{document}', [DocumentController::class, 'show'])->name('documents.show');
Route::get('documents/{document}/edit', [DocumentController::class, 'edit'])->name('documents.edit');
Route::put('documents/{document}', [DocumentController::class, 'update'])->name('documents.update');
Route::delete('documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
Route::post('documents/{document}/verify', [DocumentController::class, 'verify'])->name('documents.verify');

// routes/web.php (or routes/admin.php if you have separate admin routes)
Route::prefix('discount-offer')->name('discount-offer.')->group(function () {
    Route::get('/', [DiscountOfferController::class, 'index'])->name('index');
    Route::get('/pending', [DiscountOfferController::class, 'pending'])->name('pending');
    Route::get('/create', [DiscountOfferController::class, 'create'])->name('create');
    Route::post('/', [DiscountOfferController::class, 'store'])->name('store');
    Route::get('/{discountOffer}', [DiscountOfferController::class, 'show'])->name('show');
    Route::get('/{discountOffer}/edit', [DiscountOfferController::class, 'edit'])->name('edit');
    Route::put('/{discountOffer}', [DiscountOfferController::class, 'update'])->name('update');
     Route::post('/{discountOffer}/approve', [DiscountOfferController::class, 'approve'])->name('approve');
    Route::post('/{discountOffer}/reject', [DiscountOfferController::class, 'reject'])->name('reject');
    Route::delete('/{discountOffer}', [DiscountOfferController::class, 'destroy'])->name('destroy');
});


Route::prefix('accounts')->name('accounts.')->group(function () {
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::get('/{payment}', [AccountController::class, 'show'])->name('show');
    Route::patch('/{id}/verify', [AccountController::class, 'verify'])->name('verify');
    Route::post('/{payment}/status', [AccountController::class, 'updateStatus'])->name('status.update');
    Route::delete('/{payment}', [AccountController::class, 'destroy'])->name('destroy');
});

// Digital Locker
Route::prefix('locker')->name('locker.')->group(function () {
    Route::get('/', [\App\Http\Controllers\LockerController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\LockerController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\LockerController::class, 'store'])->name('store');
    Route::delete('/{id}', [\App\Http\Controllers\LockerController::class, 'destroy'])->name('destroy');
});

// Service Requests
Route::prefix('services')->name('services.')->group(function () {
    Route::get('/', [\App\Http\Controllers\ServiceRequestController::class, 'index'])->name('index');
    // Change to put for status update
    Route::put('/{id}/status', [\App\Http\Controllers\ServiceRequestController::class, 'updateStatus'])->name('status.update');
    Route::delete('/{id}', [\App\Http\Controllers\ServiceRequestController::class, 'destroy'])->name('destroy');
});

// Enquiries
Route::prefix('enquiries')->name('enquiries.')->group(function () {
    Route::get('/', [\App\Http\Controllers\EnquiryController::class, 'index'])->name('index');
    Route::get('/{id}', [\App\Http\Controllers\EnquiryController::class, 'show'])->name('show');
    Route::put('/{id}/status', [\App\Http\Controllers\EnquiryController::class, 'updateStatus'])->name('status.update');
    Route::delete('/{id}', [\App\Http\Controllers\EnquiryController::class, 'destroy'])->name('destroy');
});

// Project Management
Route::prefix('projects')->name('projects.')->group(function () {
    Route::get('/', [ProjectController::class, 'index'])->name('index');
    Route::get('/create', [ProjectController::class, 'create'])->name('create');
    Route::post('/', [ProjectController::class, 'store'])->name('store');
    Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
    Route::get('/{project}/edit', [ProjectController::class, 'edit'])->name('edit');
    Route::put('/{project}', [ProjectController::class, 'update'])->name('update');
    Route::post('/{project}/advance', [ProjectController::class, 'advanceStage'])->name('advance');
    Route::post('/{project}/approve-discount', [ProjectController::class, 'approveDiscount'])->name('approve-discount');
    Route::delete('/{project}', [ProjectController::class, 'destroy'])->name('destroy');
});


Route::prefix('reports')->middleware(['auth'])->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/filter', [ReportController::class, 'filter'])->name('reports.filter');
    Route::get('/download/pdf', [ReportController::class, 'downloadPdf'])->name('reports.download.pdf');
    Route::get('/download/excel', [ReportController::class, 'downloadExcel'])->name('reports.download.excel');
});

Route::get('/settings/white-label', [WhiteLabelSettingController::class, 'manage'])->name('settings.manage');
Route::post('/settings/white-label', [WhiteLabelSettingController::class, 'update'])->name('settings.update');

Route::controller(\App\Http\Controllers\CmsController::class)->prefix('cms')->name('cms.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');
});

// Route::get('/notifications', [NotificationSettingController::class, 'index'])->name('notification.settings');
// Route::post('/notifications/update', [NotificationSettingController::class, 'updateSettings'])->name('notification.settings.update');




// Notification Routes
Route::prefix('notifications')->name('notification.')->group(function () {
                Route::get('/settings', [NotificationSettingController::class, 'index'])
                    ->name('settings');
                
                Route::post('/settings/update', [NotificationSettingController::class, 'updateSettings'])
                    ->name('settings.update');
                
                 // Yeh route POST method ke liye hai
                Route::post('/test', [NotificationSettingController::class, 'testNotification'])
                    ->name('test');
                
                // Agar aapko GET method se test page dikhana hai, toh alag route banayein:
                Route::get('/test-form', [NotificationSettingController::class, 'showTestForm'])
                    ->name('test.form');
                
              
                
                Route::get('/logs', [NotificationSettingController::class, 'showLogs'])
                    ->name('logs');

                Route::get('/latest', [\App\Http\Controllers\AdminNotificationController::class, 'getLatest'])
                    ->name('latest');
                
                Route::post('/{id}/read', [\App\Http\Controllers\AdminNotificationController::class, 'markAsRead'])
                    ->name('read');

                Route::post('/read-all', [\App\Http\Controllers\AdminNotificationController::class, 'markAllAsRead'])
                    ->name('read-all');
            });

// Support & FAQs
Route::prefix('support')->name('support.')->group(function () {
    Route::get('/', [\App\Http\Controllers\admin\SupportController::class, 'index'])->name('index');
    Route::post('/settings', [\App\Http\Controllers\admin\SupportController::class, 'updateSettings'])->name('settings.update');
    Route::post('/faqs', [\App\Http\Controllers\admin\SupportController::class, 'storeFaq'])->name('faqs.store');
    Route::put('/faqs/{faq}', [\App\Http\Controllers\admin\SupportController::class, 'updateFaq'])->name('faqs.update');
    Route::delete('/faqs/{faq}', [\App\Http\Controllers\admin\SupportController::class, 'destroyFaq'])->name('faqs.destroy');
});
