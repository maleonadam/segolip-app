<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [WebsiteController::class, 'index'])->name('welcome');
Route::get('/faqs', [WebsiteController::class, 'faqs'])->name('faqs');
Route::get('/sanger_sequencing', [WebsiteController::class, 'sanger'])->name('sanger');
Route::get('/fragment_analysis', [WebsiteController::class, 'fragment'])->name('fragment');
Route::get('/kasp_genotyping', [WebsiteController::class, 'kasp'])->name('kasp');
Route::get('/dna_rna_extraction', [WebsiteController::class, 'dnarna'])->name('dnarna');
Route::get('/oligonucleotide_procurement', [WebsiteController::class, 'oligo'])->name('oligo');
Route::post('/inquiry', [WebsiteController::class, 'submitInquiry'])->name('submit-inquiry');

Route::get('/ordering', [ServiceController::class, 'ordering'])->name('ordering');

Route::group(['middleware' => 'auth'], function () {
    Route::patch('uploadPhoto/{product}', [ProductController::class, 'uploadPhoto'])->name('products.uploadPhoto');
    Route::patch('uploadDetails/{product}', [ProductController::class, 'uploadDetails'])->name('products.uploadDetails');
    Route::patch('uploadReport/{product}', [ProductController::class, 'uploadReport'])->name('products.uploadReport');
    Route::get('goToReport/{product}', [ProductController::class, 'goToReport'])->name('products.goToReport');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    Route::get('/thankyou', [CheckoutController::class, 'thankyou'])->name('confirmation.thankyou');

    Route::resource('todos', TodoController::class);
    Route::resource('products', ProductController::class);
    Route::resource('services', ServiceController::class);

    Route::get('/myorders', [OrderController::class, 'getClientOrders'])->name('myorders');
    Route::get('/my-orders/show/{id}', [OrderController::class, 'clientViewSingleOrder'])->name('my-orders.show');

    Route::get('/form/download/{order}/{form}', [OrderController::class, 'downloadForm']);

    // Signed service specification
    Route::get('/my-orders/signed/{order}', [OrderController::class, 'getSigned'])->name('my-orders.get-signed');
    Route::patch('/my-orders/signed/{order}', [OrderController::class, 'uploadSigned'])->name('my-orders.upload-signed');
    Route::get('/signed/download/{order}/{signed}', [OrderController::class, 'downloadSigned']);

    // Payment
    Route::get('/my-orders/payment/{order}', [OrderController::class, 'getPayment'])->name('my-orders.get-payment');
    Route::patch('/my-orders/payment/{order}', [OrderController::class, 'uploadPayment'])->name('my-orders.upload-payment');
    Route::get('/payment/download/{order}/{payment}', [OrderController::class, 'downloadPayment']);

    // Downloads
    Route::get('/service_speci/download/{order}/{service_speci}', [OrderController::class, 'downloadService']);
    Route::get('/invoice/download/{order}/{invoice}', [OrderController::class, 'downloadInvoice']);
    Route::get('/receipt/download/{order}/{receipt}', [OrderController::class, 'downloadReceipt']);
    Route::get('/image/download/{order}/{image}', [OrderController::class, 'downloadImage']);
    // Route::get('/data/download/{order}/{data}', 'OrderController@downloadData');

    // Account
    Route::get('/useraccount', [AccountController::class, 'index'])->name('useraccount');
    Route::get('/useraccount/edit', [AccountController::class, 'edit'])->name('useraccount-edit');
    Route::post('/useraccount/{id}/edit', [AccountController::class, 'update'])->name('editProfile');
    Route::get('/change/password', [AccountController::class, 'changePassword'])->name('change-password');
    Route::post('/change/password', [AccountController::class, 'postChangePassword'])->name('changePassword');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/allorders', [OrderController::class, 'index'])->name('allorders');

    // Service specification
    Route::get('/all-orders/service/{order}', [OrderController::class, 'getService'])->name('all-orders.get-service');
    Route::patch('/all-orders/service/{order}', [OrderController::class, 'uploadService'])->name('all-orders.upload-service');

    // Invoice
    Route::get('/all-orders/invoice/{order}', [OrderController::class, 'getInvoice'])->name('all-orders.get-invoice');
    Route::patch('/all-orders/invoice/{order}', [OrderController::class, 'uploadInvoice'])->name('all-orders.upload-invoice');

    // Receipt
    Route::get('/all-orders/receipt/{order}', [OrderController::class, 'getReceipt'])->name('all-orders.get-receipt');
    Route::patch('/all-orders/receipt/{order}', [OrderController::class, 'uploadReceipt'])->name('all-orders.upload-receipt');

    // Data
    Route::get('/all-orders/data/{order}', [OrderController::class, 'getData'])->name('all-orders.get-data');
    Route::patch('/all-orders/data/{order}', [OrderController::class, 'uploadData'])->name('all-orders.upload-data');

    // Status
    Route::get('/all-orders/status/{order}', [OrderController::class, 'getStatus'])->name('all-orders.get-status');
    Route::patch('/all-orders/status/{order}', [OrderController::class, 'updateStatus'])->name('all-orders.update-status');

    Route::get('/all-orders/show/{id}', [OrderController::class, 'staffViewSingleOrder'])->name('all-orders.show');

    // User Roles
    Route::get('/users', [UserController::class, 'index'])->name('all-users');
    Route::post('/search_users', [UserController::class, 'searchUser'])->name('search-users');
    Route::get('/assign/role/{user_id}', [UserController::class, 'getAssignRole']);
    Route::post('/assign/role/{user_id}', [UserController::class, 'assignRole'])->name('assignRole');
    Route::get('/remove/role/{user_id}', [UserController::class, 'getRemoveRole']);
    Route::post('/remove/role/{user_id}', [UserController::class, 'removeRole'])->name('removeRole');

    // Orders count
    Route::get('/counters', [CounterController::class, 'allCounters'])->name('all-counters');

    // Reports
    Route::get('/charts', [ChartController::class, 'allCharts'])->name('all-charts');
    Route::get('/reports', [ReportController::class, 'allReports'])->name('all-reports');
    Route::get('/orders_report_export', [ReportController::class, 'exportOrdersReport'])->name('orders-report-export');
});

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/{service}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
