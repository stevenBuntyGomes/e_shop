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

// frontend controller

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'FrontendController@index')->name('index');
Route::get('product/details/{slug}', 'FrontendController@productDetails');

Route::get('frontend_contact', 'FrontendController@contact')->name('contact');
Route::get('shop', 'FrontendController@shop')->name('shop');
Route::post('contact/insert', 'FrontendController@contactInsertion')->name('contactInsert');
Route::get('customer/register', 'FrontendController@customerRegister');
Route::post('customer/register/post', 'FrontendController@customerRegisterPost');
Route::post('review/post', 'FrontendController@reviewPost');
Route::get('search', 'FrontendController@search');
// frontendController
// cartController starts

Route::post('cart/page', 'CartController@cartStore')->name('cart.view');
Route::get('cart/', 'CartController@cartIndex')->name('cart.index');
Route::get('cart/{cupon_name}', 'CartController@cartIndex')->name('cartCupon');
Route::get('cart/remove/{cart_id}', 'CartController@cartRemove')->name('cart.remove');
Route::post('cart/updarte', 'CartController@cartUpdate')->name('cart.updarte');

// cartController ends

// Route::get('abouter', function(){
//   return view("about");
// });
// WishListController Starts

Route::get('wishList/', 'WishListController@index')->name('wishList');
Route::get('wishList/{wish_id}', 'WishListController@wishStore')->name('wishStore');
Route::get('wish/remove/{wish_id}', 'WishListController@removeWishList')->name('removeWishList');

// WishListController ends

// contactController starts

Route::resource('contact', 'ContactController');
Route::get('contact/delete/{contact_id}', 'ContactController@contactDelete')->name('contactDelete');
Route::get('contact/download/{contact_id}', 'ContactController@contactDownload')->name('contactDownload');

// contactController ends

//

// frontend controller

Route::get('about', 'FrontendController@about');
Route::get('support/from/us', 'FrontendController@supportfromus');
Route::get('our/service', 'FrontendController@service');
//CategoryController Routing
Route::get('/add/category', 'CategoryController@product')->name('category');
//adding category
Route::post('/add/category/posting', 'CategoryController@addcategoryPost')->name('addcategoryPost');
Route::post('/edit/category/post', 'CategoryController@editCategoryPost')->name('editCategoryPost');
Route::get('edit/category/{category_id}', 'CategoryController@editCategory')->name('editCategorys');
Route::get('/delete/category/{category_id}', 'CategoryController@deleteCategory')->name('deleteCategory');
Route::get('/restore/category/{category_id}', 'CategoryController@restoreCategory')->name('restoreCategory');
Route::get('/force/delete/category/{category_id}', 'CategoryController@forceDeleteCategory')->name('forceDeleteCategory');
Route::post('/mark/deleted', 'CategoryController@markTheDelete')->name('markTheDelete');
Route::post('/bulk/restore', 'CategoryController@markRestoreCategory')->name('markRestoreCategory');
// Route::get('contact', function(){
//   return view("contact");
// });
// MVC
// sending newsletter start
Route::get('send/newsletter', 'HomeController@newsLetters');
// sending newsletter end

// productController---------
Route::resource('product', 'ProductController');
// productController---------


// OrderController starts-------
Route::resource('order', 'OrderController');
Route::get('order/cancel/{order_id}', 'OrderController@cancelOrder')->name('orderCancel');
// OrderController starts-------

// SliderController routing start
Route::resource('slider', 'SliderController');
Route::get('restore_slider/{slider_id}', 'SliderController@restore')->name('sliderRestore');
Route::get('sliderPermDel/{slider_id}', 'SliderController@forceDelete')->name('permDel');
Route::post('slider/mark/del', 'SliderController@markDelete')->name('markDelSlider');
// SliderController routing end

// testimonialController routing start

Route::resource('testimonial', 'TestimonialController');
Route::get('restore/testimonial/{testi_id}', 'TestimonialController@restoreTesti')->name('restoreTesti');
Route::get('force/delete/testimonial/{testi_id}', 'TestimonialController@forceDelTesti')->name('forceDel');

// testimonialController routing end

// profile edit Routing
Route::get('/profile/edit', 'ProfileController@editProfile');
Route::post('/edit/profile/post', 'ProfileController@editProfilePost');
Route::post('/edit/password/post', 'ProfileController@passwordEditPost');
Route::post('change/profile/photo', 'ProfileController@editProfileImage');

Auth::routes(['verify' => true]);

// profile edit Routing

// CuponController routing

Route::resource('cupon', 'CuponController');

// CuponController routing


Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

// CustomerController starts
Route::get('customer/home', 'CustomerController@customerHome')->name('customerHome');
Route::get('customer/invoice/download/{order_id}', 'CustomerController@CustomerInvoice');
// CustomerController starts


// GitHubController starts

Route::get('login/github', 'GitHubController@redirectToProvider');
Route::get('login/github/callback', 'GitHubController@handleProviderCallback');

// GitHubController starts


// StripePaymentController starts

Route::get('stripe', 'StripePaymentController@stripe');
Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');
// StripePaymentController ends

// CheckoutController starts

Route::get('checkout', 'CheckoutController@index');
Route::post('checkout/post', 'CheckoutController@store');
Route::post('/get/city/list/ajax', 'CheckoutController@getCityAjax');
Route::get('/test/mail', 'CheckoutController@testMail');
Route::get('test/sms', 'CheckoutController@testSMS');


// CheckoutController ends
