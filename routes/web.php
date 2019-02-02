<?php

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


Route::get('/', 'HomeController@index')->name('home');

Route::group(['prefix' => 'float-data'], function () {
  Route::get('/upload', 'UploadsController@uploadData')->name('float_data.upload');
  Route::post('/save', 'UploadsController@saveAllData')->name('float_data.save');
  Route::get('/remove/{id}', 'UploadsController@removeData')->name('float_data.remove');


  Route::get('/edit/{id}', 'ClaimFloatsController@edit')->name('claim_float.edit');
  Route::post('/update/{id}', 'ClaimFloatsController@update')->name('claim_float.update');

  Route::group(['prefix' => 'mail'], function () {
    Route::get('/fresh-floats', 'MailsController@viewFreshFloats')->name('mail.fresh_float_view');
    Route::get('/view-hospitals/{float_file_id}', 'MailsController@viewFloatHospitals')->name('mail.fresh_float.hospital_view');

    Route::get('/make-excel/{float_file_id}/{hospital_id}', 'MailsController@makeExcel')->name('mail.fresh_float.make_excel');

    Route::get('/send-mail', 'MailsController@sendMail')->name('mail.send_mail');

  });

});

Route::group(['prefix' => 'hospital'], function () {
  Route::get('/create', 'HospitalsController@create')->name('hospital.create');
  Route::post('/save', 'HospitalsController@save')->name('hospital.save');
  Route::get('/disable/{id}', 'HospitalsController@disable')->name('hospital.disable');

	Route::get('/', 'HospitalsController@index')->name('hospital.index');
	Route::get('/{id}/edit', 'HospitalsController@edit')->name('hospital.edit');
	Route::post('/{id}/update', 'HospitalsController@update')->name('hospital.update');
  Route::get('/{id}', 'HospitalsController@viewHospitalDetails')->name('hospital.details');

  Route::group(['prefix' => 'export'], function () {
    Route::get('/pdf/{id}', 'HospitalsController@exportToPdf')->name('hospital.pdf.export');
    Route::get('/excel/{id}', 'HospitalsController@exportToExcel')->name('hospital.excel.export');
  });
});

Route::get('/update-data', 'UpdateController@update_data')->name('update_data');
Route::post('/save-data', 'UpdateController@save_data')->name('save_data');