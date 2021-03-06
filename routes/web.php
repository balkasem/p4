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

Route::get('/debug', function () {

    $debug = [
        'Environment' => App::environment(),
        'Database defaultStringLength' => Illuminate\Database\Schema\Builder::$defaultStringLength,
    ];

    /*
    The following commented out line will print your MySQL credentials.
    Uncomment this line only if you're facing difficulties connecting to the
    database and you need to confirm your credentials. When you're done
    debugging, comment it back out so you don't accidentally leave it
    running on your production server, making your credentials public.
    */
    #$debug['MySQL connection config'] = config('database.connections.mysql');

    try {
        $databases = DB::select('SHOW DATABASES;');
        $debug['Database connection test'] = 'PASSED';
        $debug['Databases'] = array_column($databases, 'Database');
    } catch (Exception $e) {
        $debug['Database connection test'] = 'FAILED: '.$e->getMessage();
    }

    dump($debug);
});


Route::get('/', function () {
    return view('welcome');
});

Route::get('/Refugee/create', 'RefugeeController@create');
Route::post('/Refugees', 'RefugeeController@store');

Route::get('/Refugees', 'RefugeeController@index');


Route::get('/Refugee/{name}', 'RefugeeController@show');

Route::get('/Refugees/search', 'RefugeeController@search');


Route::get('/Refugees/{id}/edit', 'RefugeeController@edit');

Route::post('/Refugees/{id}', 'RefugeeController@update');

Route::get('/Refugees/{id}/delete', 'RefugeeController@delete');
Route::POST('/Refugees/{id}/destroy/', 'RefugeeController@destroy');