<?php

use App\Http\Controllers\Alamat\AlamatController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LaporanBulananController;
use App\Http\Controllers\Midtrans\MidtransCallback;
use App\Http\Controllers\Product\AddStockProductController;
use App\Http\Controllers\Product\AddThumbController;
use App\Http\Controllers\Product\DeleteStockProductController;
use App\Http\Controllers\Product\ProductsController;
use App\Http\Controllers\Product\DeleteThumbController;
use App\Http\Controllers\Product\EditStockController;
use App\Http\Controllers\Product\GetProductsbyCategory;
use App\Http\Controllers\Product\ReadStockController;
use App\Http\Controllers\Product\SearchProductController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SendLinkResetPasswordControlller;
use App\Http\Controllers\StatistikController;
use App\Http\Controllers\tokenCheckController;
use App\Http\Controllers\Transaksi\AdminConfirmPesananController;
use App\Http\Controllers\Transaksi\ReadTransaksibyCustomerController;
use App\Http\Controllers\Transaksi\TransaksiController;
use App\Http\Controllers\Transaksi\UpdateTransaksiPaymentCancel;
use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use App\Models\Payment;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


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

Route::controller(RoleController::class)->group(function(){
    Route::get('/roles','index')->middleware('auth:sanctum');
    Route::post('/roles', 'store');
});

Route::prefix('auth')->group(function(){
    Route::post('/login', [AuthenticationController::class,'login']);
    Route::post('admin/login', [AuthenticationController::class,'loginadmin']);
    Route::post('/register', [AuthenticationController::class,'register']);
    Route::get('/logout', [AuthenticationController::class,'logout'])->middleware('auth:sanctum');
    Route::patch('/profile', [UserController::class, 'selfUpdateProfile'])->middleware('auth:sanctum');
    Route::patch('/password', [UserController::class, 'selfUpdatePassword'])->middleware('auth:sanctum');
    Route::get('/check-token', tokenCheckController::class);
    Route::post('/send-reset-password', SendLinkResetPasswordControlller::class);
    Route::post('/reset-password', ResetPasswordController::class);
});

// ["middleware"=>['auth:sanctum']]
Route::prefix('admin')->group(function(){
    Route::post('register/cs', [UserController::class, 'createCS'])->middleware('auth:sanctum');
    Route::patch('customerservice/{id}', [UserController::class, 'userUpdate'])->middleware('auth:sanctum');
    Route::get('user/customer', [UserController::class, 'userCustomer'])->middleware('auth:sanctum');
    Route::get('user/customerservice', [UserController::class, 'userCustomerService'])->middleware('auth:sanctum');
    Route::delete('user/{id}', [UserController::class, 'deleteUser'])->middleware('auth:sanctum');
    Route::get('statistik', StatistikController::class)->middleware('auth:sanctum');

});

Route::post('/laporan', [LaporanBulananController::class, 'download']);



// Route::apiResource('/category', CategoryController::class)
Route::post('/category', [CategoryController::class, 'store'])->middleware('auth:sanctum');
Route::get('/category', [CategoryController::class, 'index']);
Route::patch('/category/{category}', [CategoryController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/category/{category}', [CategoryController::class, 'show']);

// Route::apiResource('/stock', StockController::class);
// Route::patch('/stock/{stock}/update', UpdateStockController::class);

Route::post('/products', [ProductsController::class, 'store'])->middleware('auth:sanctum');
Route::get('/products', [ProductsController::class, 'index']);
Route::patch('/products/{products}', [ProductsController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/products/{id}', [ProductsController::class, 'destroy'])->middleware('auth:sanctum');
Route::get('/products/{products}', [ProductsController::class, 'show']);
Route::get('/product/search', SearchProductController::class);

Route::delete('/product-thumb/{thumb}', DeleteThumbController::class)->middleware('auth:sanctum');
Route::post('/product-thumb/{product}', AddThumbController::class)->middleware('auth:sanctum');
Route::post('/product-stock/{product}', AddStockProductController::class)->middleware('auth:sanctum');
Route::patch('/product-stock/{product}', EditStockController::class)->middleware('auth:sanctum');
Route::delete('/stock/{stock}', DeleteStockProductController::class)->middleware('auth:sanctum');
Route::get('/stock/{id}', ReadStockController::class);

// Route::apiResource('/gambar', ThumbsController::class);

Route::get('/provinsi',[AlamatController::class, 'provinces']);
Route::get('/provinsi/{id}',[AlamatController::class, 'findKota']);
Route::get('/kota/{id}',[AlamatController::class, 'findKecamatan']);
Route::get('/kecamatan/{id}',[AlamatController::class, 'findKelurahan']);


Route::apiResource('/cart', CartController::class)->middleware('auth:sanctum');
Route::apiResource('/transaksi', TransaksiController::class)->middleware('auth:sanctum');
Route::get('/user-transaksi', ReadTransaksibyCustomerController::class)->middleware('auth:sanctum');
Route::patch('/confirm-pesanan/{id}', AdminConfirmPesananController::class);

Route::get('/provinces', [RajaOngkirController::class, 'getProvinces'])->middleware('auth:sanctum');
Route::get('/cities/{id}', [RajaOngkirController::class, 'getCities'])->middleware('auth:sanctum');
Route::post('/cek-ongkir', [RajaOngkirController::class, "cekOngkir"])->middleware('auth:sanctum');
Route::post('/midtrans-callback', MidtransCallback::class);
Route::patch('/cancel-payment/{id}', UpdateTransaksiPaymentCancel::class)->middleware('auth:sanctum');

Route::get('/total-user', [StatistikController::class, 'totalCustomer']);
Route::get('/total-transaksi', [StatistikController::class, 'totalTransaksi']);
Route::get('/total-pendapatan', [StatistikController::class, 'totalPendapatan']);

Route::get('/invoice/{id}', [InvoiceController::class, 'download'])->middleware('auth:sanctum');




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    return new UserResource($user);
});
