<?php

use App\Http\Controllers\ClientHallController;
use App\Http\Controllers\ClientIndexController;
use App\Http\Controllers\ClientPaymentController;
use App\Http\Controllers\ClientTicketController;
use App\Http\Controllers\HallController;
use App\Http\Controllers\TakenPlaceController;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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

Route::get('/', [ClientIndexController::class, 'index'])->name('index');
Route::get('/hall', [ClientHallController::class, 'index'])->name('client_hall');
Route::get('/client_hall', [TakenPlaceController::class, 'update']);
Route::get('/payment', [ClientPaymentController::class, 'index'])->name('payment');
Route::get('/ticket', [ClientTicketController::class, 'index'])->name('ticket');
Route::get('qr-code-g', function () {
    QrCode::size(500)
        ->format('png')
        ->generate('www.google.com', public_path('images/qrcode.png'));
    return view('qrCode');
});

Auth::routes();

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/admin', [HallController::class, 'index'])->name('admin');
});

//public function index()
//{
//    $movies = Movie::all();
//
//    return view('/', compact('movies'));
//}

//Route::get('/', function () {
//    return view('welcome');
//});



//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
