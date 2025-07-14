<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ClinicController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AdminController;
use App\Http\Middleware\RolePermission;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TreatmentBoardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SoapTemplateController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\Analyticscontroller;
use App\Http\Controllers\SmartLouController;
use App\Http\Controllers\ReminderController;


// Show registration form
Route::get('/admin/register', function () {
    return view('admin_register');
})->name('admin.register.form');

// Handle registration submission
Route::post('/admin/register', [AdminController::class, 'register'])->name('admin.register');

// Show login form
Route::get('/', function () {
    return view('admin_login');
})->name('admin.login.form');

// Handle login submission
Route::post('/admin/login', [AdminController::class, 'adminlogin'])->name('admin.login');





Route::middleware(RolePermission::class)->group(function () {
//        Route::get('/dashboard', function () {
//     return view('admin_dashboard');
// })->name('dashboard');
Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::post('/admin/change-password', [AdminController::class, 'changePassword'])->name('admin.change.password');
Route::get('/logout',[AdminController::class,'logout']);

// Vet Routes
Route::prefix('vets')->group(function () {
    Route::get('/create', [AdminDashboardController::class, 'createvet'])->name('vets.create');
    Route::post('/', [AdminDashboardController::class, 'storevet'])->name('vets.store');
});
// Appointment Routes
Route::get('/appointments/json', [AppointmentController::class, 'calendarData']);
Route::post('/appointments/update-time', [AppointmentController::class, 'updateTimee']);
Route::post('/appointments/checkin', [AppointmentController::class, 'checkin'])->name('appointments.checkin');

Route::post('/appointments/{id}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
Route::controller(AppointmentController::class)->prefix('appointments')->group(function () {
    Route::get('/', 'index')->name('appointments.index');
    Route::get('/calendar', 'calendar')->name('appointments.calendar');
    Route::post('/', 'store')->name('appointments.store');
    Route::get('/{appointment}', 'show')->name('appointments.show');
    Route::post('/update', 'update')->name('appointments.update'); 
    Route::delete('/{appointment}', 'destroy')->name('appointments.destroy');
    Route::get('/client/{client}/pets', 'getClientPets')->name('appointments.client.pets');
    Route::get('/pets/{id}/info','getPetInfo')->name('appointments.pet.info');//I ADD THIS
});

Route::patch('/appointments/{appointment}/update-time', [AppointmentController::class, 'updateTime'])
    ->name('appointments.update-time');
Route::get('/appointments/series/{id}', [AppointmentController::class, 'showSeries'])->name('appointments.series');
Route::get('overdue', [AdminDashboardController::class, 'overdue']);
Route::post('/appointments/{appointment}/invoice-items', [AppointmentController::class, 'storeInvoiceItems'])->name('appointments.invoice_items.store');
Route::post('/appointments/upload-document', [AppointmentController::class, 'uploadDocument'])->name('appointments.uploadDocument');


// Client Routes
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
Route::get('/clients/{client}', [ClientController::class, 'show'])->name('clients.show');
Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');
Route::put('/clients/update', [ClientController::class, 'update'])->name('clients.update');
Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
Route::get('/clients/export/excel', [ClientController::class, 'exportExcel'])->name('clients.export.excel');
Route::get('/clients/export/pdf', [ClientController::class, 'exportPDF'])->name('clients.export.pdf');
Route::get('/clients/fetch-by-name', [ClientController::class, 'fetchByName']);

// Pet Management Routes
// Pet Management Routes
Route::prefix('pets')->group(function () {
    Route::get('/', [PetController::class, 'index'])->name('pets.index');
    Route::post('/', [PetController::class, 'store'])->name('pets.store');
    Route::get('/{pet}', [PetController::class, 'show'])->name('pets.show');
    Route::get('/{pet}/edit', [PetController::class, 'edit'])->name('pets.edit'); // Add this line
    Route::put('/pets/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::put('/{pet}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/{pet}', [PetController::class, 'destroy'])->name('pets.destroy');
});

Route::get('/pet-directory', [PetController::class, 'petDirectory'])->name('pet.directory');


// ✅ Dynamic route using controller
Route::get('/pet-directory/view/{id}', [PetController::class, 'view'])->name('pet.directory.view');

// //pet dummy route 3
// Route::view('/appointment/billing', 'appointments_billing')->name('appointment.billing');
Route::get('/appointment/billing/{id}', [AppointmentController::class, 'billing'])->name('appointment.billing');
Route::post('/appointment/{id}/discharge-note', [AppointmentController::class, 'storeDischargeNote'])->name('appointment.discharge.store');
Route::post('/appointment/{id}/soap-note', [AppointmentController::class, 'storeSoapNote'])->name('appointment.soap.store');
Route::post('/appointment/{id}/store-medication', [AppointmentController::class, 'storeMedication'])->name('appointment.storeMedication');

// Cancel appointment (new)
Route::post('/appointments/update-status/{id}', [AppointmentController::class, 'cancelStatus'])->name('appointments.cancelStatus');



Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/create', [ProductController::class, 'create'])->name('products.create');
    // Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::get('/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    // Route::put('/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::post('/update', [ProductController::class, 'update'])->name('products.update');

    Route::delete('/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // Additional product routes
    Route::post('/{product}/restock', [ProductController::class, 'restock'])->name('products.restock');
    Route::get('/export/excel', [ProductController::class, 'exportExcel'])->name('products.export.excel');
    Route::get('/export/pdf', [ProductController::class, 'exportPdf'])->name('products.export.pdf');
});
 Route::get('/suppliers', [SupplierController::class, 'index'])
         ->name('suppliers.index');
    
    // Store new supplier
    Route::post('/suppliers', [SupplierController::class, 'store'])
         ->name('suppliers.store');
    
    // Update existing supplier
Route::put('/suppliers/{supplier}', [SupplierController::class, 'update'])->name('suppliers.update');

    
    // Delete supplier
    Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy'])
         ->name('suppliers.destroy');
Route::get('/suppliers/export/excel', [SupplierController::class, 'exportExcel'])->name('suppliers.export.excel');
Route::get('/suppliers/export/pdf', [SupplierController::class, 'exportPDF'])->name('suppliers.export.pdf');


//clinic part
    Route::get('/clinics', [ClinicController::class, 'index'])->name('clinics.index');
    Route::post('/clinics', [ClinicController::class, 'store'])->name('clinics.store');
   Route::post('/clinics/update', [ClinicController::class, 'update'])->name('clinics.update');
    Route::delete('/clinics/{clinic}', [ClinicController::class, 'destroy'])->name('clinics.destroy');
Route::get('/clinics/export/excel', [ClinicController::class, 'exportExcel'])->name('clinics.export.excel');
Route::get('/clinics/export/pdf', [ClinicController::class, 'exportPDF'])->name('clinics.export.pdf');



//purchase order
Route::prefix('purchase-orders')->group(function () {
    Route::get('/', [PurchaseOrderController::class, 'index'])->name('purchase-orders.index');
    Route::get('/create', [PurchaseOrderController::class, 'create'])->name('purchase-orders.create');
    Route::post('/', [PurchaseOrderController::class, 'store'])->name('purchase-orders.store');
    Route::get('/{id}', [PurchaseOrderController::class, 'show'])->name('purchase-orders.show');
    Route::get('/{id}/edit', [PurchaseOrderController::class, 'edit'])->name('purchase-orders.edit');
    Route::put('/{id}', [PurchaseOrderController::class, 'update'])->name('purchase-orders.update');
    Route::delete('/{id}', [PurchaseOrderController::class, 'destroy'])->name('purchase-orders.destroy');
    Route::get('/export/excel', [PurchaseOrderController::class, 'exportExcel'])->name('purchase-orders.export.excel');
    Route::get('/export/pdf', [PurchaseOrderController::class, 'exportPDF'])->name('purchase-orders.export.pdf');

});



    // Medical Record Routes
Route::prefix('medical-records')->group(function () {
    Route::get('/', [MedicalRecordController::class, 'index'])->name('medical-records.index');
    Route::post('/', [MedicalRecordController::class, 'store'])->name('medical-records.store');
    Route::get('/create', [MedicalRecordController::class, 'create'])->name('medical-records.create');
    Route::get('/{medicalRecord}', [MedicalRecordController::class, 'show'])->name('medical-records.show');
    Route::get('/{medicalRecord}/edit', [MedicalRecordController::class, 'edit'])->name('medical-records.edit');
Route::put('/{medicalRecord}', [MedicalRecordController::class, 'update'])->name('medical-records.update');

    Route::delete('/{medicalRecord}', [MedicalRecordController::class, 'destroy'])->name('medical-records.destroy');
    
    // From appointment
    Route::get('/appointments/{appointment}/create', [MedicalRecordController::class, 'createFromAppointment'])
        ->name('medical-records.create-from-appointment');
    
Route::get('/{id}/attachments', [MedicalRecordController::class, 'getAttachments'])->name('medical-records.attachments');
});

//for treatment board
Route::prefix('treatment-board')->group(function () {
    Route::get('/', [TreatmentBoardController::class, 'index'])->name('treatment-board.index');
    Route::post('/', [TreatmentBoardController::class, 'store'])->name('treatment-board.store');
    Route::put('/update', [TreatmentBoardController::class, 'update'])->name('treatment-board.update');
});

// Invoice Routes
Route::group(['prefix' => 'invoices'], function() {

    Route::get('/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    // Route::post('/', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::post('/invoice-items/store', [InvoiceController::class, 'storeInvoiceItems'])->name('invoice_items.store');
    Route::put('/{id}', [InvoiceController::class, 'update'])->name('invoices.update');
    Route::delete('/{id}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
   Route::delete('/payments/{payment}', [InvoiceController::class, 'destroyPayment'])->name('invoices.payments.destroy');
    // Invoice Items Route (for AJAX)
    Route::get('/{id}/items', [InvoiceController::class, 'getItems'])->name('invoices.items');
    Route::post('/invoice/medication/store', [InvoiceController::class, 'storeMedication'])->name('invoice.medication.store');

    
    // Client Appointments Route (keep this for any other potential uses)
    Route::get('/client/{client}/appointments', [InvoiceController::class, 'getClientAppointments'])->name('invoices.client.appointments');
    
    // Payment Routes
    Route::post('/{id}/payments', [InvoiceController::class, 'addPayment'])->name('invoices.payments.store');
});
   Route::get('/billing', [InvoiceController::class, 'index'])->name('billing.view');

Route::prefix('reports')->group(function () {
    Route::get('/invoices', [ReportController::class, 'index'])->name('reports.index');
});



// SOAP Template Routes
Route::prefix('soap-templates')->group(function () {
    Route::get('/', [SoapTemplateController::class, 'index'])->name('soap-templates.index');
    Route::post('/', [SoapTemplateController::class, 'store'])->name('soap-templates.store');
    Route::put('/{soapTemplate}', [SoapTemplateController::class, 'update'])->name('soap-templates.update');
    Route::delete('/{soapTemplate}', [SoapTemplateController::class, 'destroy'])->name('soap-templates.destroy');
    
    // AJAX routes
    Route::get('/by-category', [SoapTemplateController::class, 'getByCategory'])->name('soap-templates.by-category');
    Route::get('/template-content', [SoapTemplateController::class, 'getTemplateContent'])->name('soap-templates.template-content');
    Route::post('/quick-apply', [SoapTemplateController::class, 'quickApply'])->name('soap-templates.quick-apply');
});
Route::post('/appointments/check-conflict', [AppointmentController::class, 'checkConflict'])->name('appointments.check-conflict');


//check mail notifications
Route::post('/send-vet-notifications', [AdminDashboardController::class, 'sendVetNotifications'])
    ->name('send.vet.notification');


//  Route::view('/billing', 'billing')->name('billing.view');   


Route::post('/pets/{pet}/send-email', [AppointmentController::class, 'sendEmail'])->name('pets.sendEmail');
Route::post('/appointments/{pet}/send-email', [AppointmentController::class, 'sendEmail'])->name('appointments.sendEmail');


Route::get('/inventory', [ProductController::class, 'inventory'])->name('inventory');
Route::post('/inventory/store', [ProductController::class, 'store'])->name('inventory.store');
Route::delete('/inventory/{id}', [ProductController::class, 'destroy'])->name('inventory.destroy');


//settings page

Route::get('/settings', [SettingsController::class, 'settings'])->name('settings');
Route::post('/settings/insert-contact', [SettingsController::class, 'insertContact'])->name('settings.insertContact');

//message page
Route::get('/messages', function () {
    return view('message'); // your file is in resources/views/message.blade.php
})->name('messages');

Route::prefix('reminders')->group(function () {
    Route::get('/', [ReminderController::class, 'index'])->name('reminders.index');
    Route::post('/', [ReminderController::class, 'store'])->name('reminders.store');
    Route::put('/{reminder}', [ReminderController::class, 'update'])->name('reminders.update');
    Route::delete('/{reminder}', [ReminderController::class, 'destroy'])->name('reminders.destroy');
    Route::post('/{reminder}/update-status', [ReminderController::class, 'updateStatus'])->name('reminders.update-status');
});

Route::get('/analytics', [Analyticscontroller::class, 'analytics'])->name('analytics');

Route::get('/smartlou', [SmartLouController::class, 'index'])->name('smartlou');

});



















