<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\EntryController;
use App\Http\Controllers\ShiftController;

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


Route::get('/', [UserController::class,'login'])->name("login");
Route::post('/login', [UserController::class,'postLogin']);


Route::get('/logout',function(){
	Auth::logout();
	return Redirect::to('/');
});

Route::group(['middleware'=>'auth'],function(){
	Route::group(['prefix'=>"admin"], function(){
		// Route::get('/print-post', [UserController::class,'printPost']);
		Route::get('/dashboard',[AdminController::class,'dashboard']);
		Route::get('/reset-password',[UserController::class,'resetPassword']);
		Route::post('/reset-password',[UserController::class,'updatePassword']);

		Route::get('/all-entries',[EntryController::class,'allEntries']);
		
		Route::group(['prefix'=>"entries"], function(){
			Route::get('/{type}',[EntryController::class,'index']);
			Route::get('/print/{id?}', [EntryController::class,'printPost']);
			

			
		});		

		Route::group(['prefix'=>"shift"], function(){
			Route::get('/current',[ShiftController::class,'index']);
			Route::get('/print/{type}',[ShiftController::class,'print']);
			
			
		});

		Route::group(['prefix'=>"users"], function(){
			Route::get('/',[UserController::class,'users']);
		});

	});
});

Route::group(['prefix'=>"api"], function(){
	
	Route::group(['prefix'=>"entries"], function(){
		Route::post('/init/{type}',[EntryController::class,'initEntry']);
		Route::post('/init-all',[EntryController::class,'initAllEntry']);
		Route::post('/edit-init',[EntryController::class,'editEntry']);
		Route::post('/store/{type}',[EntryController::class,'store']);
		Route::post('/cal-check',[EntryController::class,'calCheck']);
		Route::post('/checkout-init',[EntryController::class,'checkoutInit']);
		Route::post('/checkout-store',[EntryController::class,'checkoutStore']);
		Route::get('/delete/{id}',[EntryController::class,'delete']);
		Route::post('/init-single-entry',[EntryController::class,'initSingleEntry']);
		Route::get('/delete-e-entry/{entry_id}/{e_entry_id}',[EntryController::class,'deleteEnEntry']);

	});
	Route::group(['prefix'=>"shift"], function(){
		Route::post('/init',[ShiftController::class,'init']);
		Route::post('/prev-init',[ShiftController::class,'prevInit']);

	});

	Route::group(['prefix'=>"users"], function(){
		Route::post('/init',[UserController::class,'initUsers']);
		Route::post('/edit-init',[UserController::class,'editUser']);
		Route::post('/store',[UserController::class,'storeUser']);
	});
});
