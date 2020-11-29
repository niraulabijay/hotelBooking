<?php

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

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

Route::get('/create-super/{email}','authentication\RegistrationController@createAdmin');

//Authentication Routes
Route::post('/logout', 'authentication\LogController@logout')->name('logout');
Route::post('/admin/login/', 'authentication\LogController@check')->name('login_check');
Route::group([
    'namespace'=>'authentication',
    'middleware' => 'visitor'
], function () {

    Route::get('/', 'LogController@login')->name('admin_login');
    Route::get('/register', 'RegistrationController@register')->name('register');
//    Route::get('/login','LogController@admin_login')->name('admin_login');
    Route::get('/forgot_password','ForgotPasswordController@forgot_password')->name('forgot_password');
    Route::POST('/post_forgot_password','ForgotPasswordController@post_forgot_password')->name('post_forgot_password');

    //activation
    Route::get('/activate/{email}/{activationCode}','authentication\ActivationController@activate');

    Route::post('/store', 'authentication\RegistrationController@store')->name('register_user');

    //forgot_password
    Route::get('/reset_password/{email}/{code}','authentication\ForgotPasswordController@reset');
    Route::post('/reset_password/{email}/{code}','authentication\ForgotPasswordController@post_reset')->name('post_password_reset');

});

Route::get('/api-hint','authentication\LogController@apiHints');

Route::group([
    'prefix' => '/admin',
    'namespace'=>'admin',
    'as' => 'admin.',
    'middleware' => 'sentinel'
], function () {

    //dashboard
    Route::get('/',function(){
        return view('admin.index');
    })->name('dashboard');

    //desetinations
    Route::get('/destinations','DestinationController@index')->name('destinations');
    Route::post('/destination/add','DestinationController@store')->name('destination.store');
    Route::get('/destination/edit/{id}','DestinationController@edit')->name('destination.edit');
    Route::post('/destination/edit/{id}','DestinationController@update')->name('destination.update');
    Route::post('/destination/delete','DestinationController@delete')->name('destination.delete');

    //Brands
    Route::get('/brands','BrandController@index')->name('brands');
    Route::post('/brand/add','BrandController@add')->name('brands.add');
    Route::get('/brand/edit/{id}','BrandController@edit')->name('brands.edit');
    Route::post('/brand/edit/{id}','BrandController@update')->name('brands.update');
    Route::post('/brand/delete','BrandController@delete')->name('brands.delete');

    //Brand-Setting
    Route::get('brand-setting/{brandSlug}','BrandSettingController@index')->name('brand.setting');
    Route::post('brand-setting/{brandSlug}','BrandSettingController@update')->name('brand.setting.update');

    //Hotels
    Route::get('/hotels','HotelController@index')->name('hotels');
    Route::post('/hotel/add','HotelController@add')->name('hotels.add');
    Route::get('/hotel/edit/{id}','HotelController@edit')->name('hotels.edit');
    Route::post('/hotel/edit/{id}','HotelController@update')->name('hotels.update');
    Route::post('/hotel/delete','HotelController@delete')->name('hotels.delete');

    //Hotel Setting Routes
    Route::get('/hotel/setting/{id}','HotelSettingController@index')->name('hotel.setting');
    Route::post('/hotel/setting/{id}','HotelSettingController@update')->name('hotel.setting.update');

    //Room Types
    Route::get('/room-types','RoomTypeController@index')->name('roomType');
    Route::get('/room-type/add/{hotel_slug}','RoomTypeController@add')->name('roomType.add');
    Route::post('/room-type/add/{hotel_slug}','RoomTypeController@store')->name('roomType.store');
    Route::get('/room-type/edit/{roomTypeSlug}','RoomTypeController@edit')->name('roomType.edit');
    Route::post('/room-type/edit/{roomTypeSlug}','RoomTypeController@update')->name('roomType.update');
    Route::post('/room-type/delete','RoomTypeController@delete')->name('roomType.delete');

    // Room Routes
    Route::post('/room/add/','RoomController@store')->name('room.add');
    Route::get('room/edit/','RoomController@edit')->name('room.edit');
    Route::post('room/update','RoomController@update')->name('room.update');
    Route::post('room/delete','RoomController@delete')->name('room.delete');

    //Faq Category
    Route::get('/faqs','FaqController@index')->name('faqs');
    Route::post('/faqs','FaqController@storeCategory')->name('faqCategory.store');
    Route::get('/faq-category/{slug}/edit','FaqController@editCategory')->name('faqCategory.edit');
    Route::post('/faq-category/{slug}/edit','FaqController@updateCategory')->name('faqCategory.update');
    Route::post('/faq-category/delete','FaqController@deleteCategory')->name('faqCategory.delete');
    // Faq Question
    Route::post('/faq-question/add','FaqController@storeQuestion')->name('faq.store');
    Route::get('/faq-question/edit','FaqController@editQuestion')->name('faq.edit');
    Route::post('/faq-question/update','FaqController@updateQuestion')->name('faq.update');
    Route::post('/faq-question/delete','FaqController@deleteQuestion')->name('faq.delete');

    //Amenities Crud.
    Route::get('/amenities','AmenityController@index')->name('amenities');
    Route::post('/amenities','AmenityController@store')->name('amenity.store');
    Route::get('/amenity/{slug}','AmenityController@edit')->name('amenity.edit');
    Route::post('/amenity/{slug}','AmenityController@update')->name('amenity.update');
    Route::get('/amenity/delete/{id}','AmenityController@delete')->name('amenity.delete');

    //Inclusions Crud
    Route::get('/inclusions','InclusionController@index')->name('inclusions');

    //Booking
    Route::get('/booking/new','BookingController@new')->name('booking.new');
    Route::post('/booking/checkAvailable','BookingController@checkAvailable')->name('booking.checkAvailable');
    Route::post('/booking/proceed','BookingController@proceedBooking')->name('booking.proceedBooking');
    Route::post('/booking/new','BookingController@finalize')->name('booking.finalize');

    //Room Type Prices
    Route::get('/room-prices','RoomPriceController@index')->name('roomPrices');
    Route::get('/ajax/loadCalendar','RoomPriceController@loadCalendar')->name('ajaxPriceCalendar');


});
