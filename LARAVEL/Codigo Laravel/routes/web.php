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

/**
 * URL por defecto
 * @author Edwinlopezve@gmail.com e. López
 * @since V-1.0
 */
Route::get('/', function (){
    return redirect(url('/en'));
});



//Adarsh
Route::get('/propertyDetailPage/{id}',array('as'=>'propertyDetailPage','uses'=>'propertyDetailController@index'));
//Adarsh

Route::get('/sitemap', 'SitemapController@index');
//Route::get('/propertydetails', 'PropertyInfoController@index');

/**
 * Email sender enquiry
 * @author Edwinlopezve@gmail.com e. López
 * @since V-1.0
 */
Route::post('/sendEnquiry', 'EmailController@sendEnquiry');

/**
 * Email sender contact us
 * @author Edwinlopezve@gmail.com e. López
 * @since V-1.0
 */
Route::post('/sendContact', 'EmailController@sendContact');

Route::get('/me', 'Controller@test');

/**
 * URLs en Ingles
 * @author Edwinlopezve@gmail.com e. López
 * @since V-1.0
 */
Route::group(array('prefix' => 'en'), function() {
    Route::get('/', ['as' => 'main', 'uses' => 'IndexController@index']);
    Route::get('/{province}/{poblacion}/{propiedad}', ['as' => 'propertyInfo', 'uses' => 'PropertyInfoController@index']);
    Route::get('/{province}', ['as' => 'provincia', 'uses' => 'SearchController@actionProvince']);
    Route::get('/{province}/{poblacion}', ['as' => 'poblacion', 'uses' => 'SearchController@actionLocation']);
    Route::get('/estate', function () {return view('estate');});
});

Route::get('/cookies', ['as' => 'cookies', 'uses' => 'SearchController@rute']);
//Route::get('/cookies', function () 
//{  return view('cookies')->with('controller', $this);});

/**
 * URLs en Español
 * @author Edwinlopezve@gmail.com e. López
 * @since V-1.0
 */

Route::group(array('prefix' => 'es'), function() {
Route::get('/', ['as' => 'main', 'uses' => 'IndexController@index']);
Route::get('/{province}/{poblacion}/{propiedad}', ['as' => 'propertyInfo', 'uses' => 'PropertyInfoController@index']);
Route::get('/{province}', ['as' => 'provincia', 'uses' => 'SearchController@actionProvince']);
Route::get('/{province}/{poblacion}', ['as' => 'poblacion', 'uses' => 'SearchController@actionLocation']);
	

});
