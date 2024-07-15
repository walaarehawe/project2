<?php

use App\Http\Controllers\Address\CityController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ManageMenu\ProductController;
use App\Http\Controllers\ManageMenu\CategoryController;
use App\Http\Controllers\ManageMenu\SectionController;
use App\Http\Controllers\Auth\SignInController;
use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Casher\InvoiceController;
use App\Http\Controllers\Order\OrderExternalController;
use App\Http\Controllers\Order\OrderInternalController;
use App\Http\Controllers\Order\OrderLocalController;
use App\Http\Controllers\PreparatioSection\HeadPreparationController;
use App\Http\Controllers\Table\TableController;
use App\Models\Order\OrderExternalUser;
use Illuminate\Http\Request;

use App\Http\Controllers\ManageMenu\RatingController;
use App\Http\Controllers\Offer\OfferController;
use App\Http\Controllers\Offer\OfferDetailsController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Order\OrderDetalisController;
use App\Http\Controllers\Order\OrderSearchController;
use Illuminate\Support\Facades\Route;

//Manage Section
Route::post('DeleteSection', [SectionController::class, 'DeleteSection']);
Route::post('EditSection', [SectionController::class, 'EditSection']);
Route::post('AddSection', [SectionController::class, 'AddSection']);
Route::get('ShowSection', [SectionController::class, 'ShowSection']);
Route::post('ChangeStatus', [SectionController::class, 'ChangeStatus']);

//Route::post('storeq',[AddressController::class,'storeq']);
// Route::post('storeaddress', [AddressController::class, 'store']);
// Route::post('showAddress', [AddressController::class, 'show']);
Route::post('showAddress', [AddressController::class, 'show']);
Route::post('Addtransport', [AddressController::class, 'Addtransport']);
Route::get('showtransport', [AddressController::class, 'showtransport']);
Route::post('Selecttransport', [AddressController::class, 'Selecttransport']);

Route::post('AddTransportationCost', [AddressController::class, 'AddTransportationCost']);

//Manage category
Route::post('DeleteCategory', [CategoryController::class, 'DeleteCategory']);
Route::post('EditCategory', [CategoryController::class, 'EditCategory']);
Route::post('AddCategory', [CategoryController::class, 'AddCategory']);
Route::get('ShowCategory', [CategoryController::class, 'ShowCategory']);

//Manage Product
Route::post('Search', [ProductController::class, 'Search']);
Route::post('EditProduct', [ProductController::class, 'EditProduct']);
Route::post('Addproduct', [ProductController::class, 'Addproduct']);
Route::post('Filter', [ProductController::class, 'Filter']);
Route::get('Showproduct', [ProductController::class, 'Showproduct']);
Route::post('ChangeType', [ProductController::class, 'ChangeType']);
Route::post('ShowType', [ProductController::class, 'ShowType']);
Route::post('DeleteProduct', [ProductController::class, 'DeleteProduct']);
Route::post('showDetails', [ProductController::class, 'showDetails']);
Route::post('AddRating', [RatingController::class, 'AddRating']);


//Auth:
Route::post('code', [RegisterController::class, 'code']);
Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [SignInController::class, 'login']);
Route::post('experience', [OrderInternalController::class, 'ex']);




Route::group(['namespace' => 'order'], function () {
    Route::post('store', [OrderInternalController::class, 'store']);
    Route::post('storedetalis', [OrderInternalController::class, 'on']);
    Route::post('product', [OrderInternalController::class, 'product']);
    Route::post('ordertable', [InvoiceController::class, 'store']);
    Route::post('update/table', [TableController::class, 'update']);

});

Route::group(['prefix' => 'order'], function () {
    Route::post('index', [OrderController::class, 'index']);
    Route::post('orderLocal', [OrderController::class, 'orderLocal']);
    Route::post('orderExternal', [OrderController::class, 'orderExternal']);
});
Route::group(['prefix' => 'orderLocal'], function () {
    Route::post('store', [OrderLocalController::class, 'store']);
});

Route::group(['prefix' => 'External', 'middleware' => 'auth:sanctum'], function () {
    Route::post('store', [OrderExternalController::class, 'store']);
    Route::post('show', [OrderExternalController::class, 'show']);
});

Route::group(['prefix' => 'table'], function () {
    Route::post('store', [TableController::class, 'store']);
    Route::get('index', [TableController::class, 'index']);
    Route::post('show', [TableController::class, 'show']);
    Route::post('Delete', [TableController::class, 'show']);
});

Route::group(['prefix' => 'tablestatus'], function () {
    Route::post('update', [InvoiceController::class, 'update']);
});

Route::group(['prefix' => 'Invoice'], function () {
    Route::post('update', [InvoiceController::class, 'update']);
    Route::post('show', [InvoiceController::class, 'showInvoiceTable']);
    Route::post('showInvoiceOrderNumber', [InvoiceController::class, 'showInvoiceOrderNumber']);
    Route::post('invoiceLocal', [InvoiceController::class, 'invoiceLocal']);
    Route::post('invoiceInternal', [InvoiceController::class, 'invoiceInternal']);
    Route::post('invoiceExternal', [InvoiceController::class, 'invoiceExternal']);
});

Route::group(['prefix' => 'PreparetionDepartment'], function () {
    Route::post('ConfirmReady', [HeadPreparationController::class, 'update']);
});
Route::group(['prefix' => 'Address', 'middleware' => 'auth:sanctum'], function () {
    Route::post('storeaddress', [AddressController::class, 'store']);
    Route::post('showAddress', [AddressController::class, 'show']);
});
Route::group(['prefix' => 'offers'], function () {
    Route::post('store', [OfferController::class, 'store']);
});
Route::group(['prefix' => 'offers'], function () {
    Route::post('store', [OfferController::class, 'store']);
    Route::post('index', [OfferController::class, 'index']);
    Route::post('update', [OfferController::class, 'update']);
    Route::post('Delete', [OfferController::class, 'Delete']);
    Route::post('search', [OfferController::class, 'search']);
});
Route::group(['prefix' => 'offersDetalis'], function () {
    Route::post('store', [OfferDetailsController::class, 'store']);
    Route::post('index', [OfferDetailsController::class, 'index']);
    Route::post('show', [OfferDetailsController::class, 'show']);
    Route::post('update', [OfferDetailsController::class, 'update']);
    Route::post('Delete', [OfferDetailsController::class, 'Delete']);
});




Route::group(['prefix' => 'e', 'middleware' => 'auth:sanctum'], function () {

    Route::post('getadderss', [InvoiceController::class, 'getadderss']);
});
Route::group(['prefix' => 'OrderDetalis', 'middleware' => 'auth:sanctum'], function () {

    Route::post('getUnpaidOrdersByUserId', [OrderDetalisController::class, 'getUnpaidOrdersByUserId']);
    Route::post('orderDetalis', [OrderDetalisController::class, 'orderDetalis']);
});
Route::group(['prefix' => 'search'], function () {
    Route::post('order', [OrderSearchController::class, 'search']);
    Route::post('calculateTotalPrice', [OrderSearchController::class, 'calculateTotalPrice']);
});
