<?php

use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Userlogin
Route::get('userlogin', 'API\UserController@userLogin');
Route::put('photo/{id}', 'API\UserController@updatePhoto');
Route::put('user/changepwd/{id}', 'API\UserController@changePwd');

// Menu Pegawai
Route::apiResources(['user' => 'API\UserController']);
Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');
Route::get('userbyunit', 'API\UserController@userByUnit');
Route::get('userbybagian', 'API\UserController@userByBagian');
Route::post('alluserbyunit', 'API\UserController@allUserByUnit');
Route::get('findUser', 'API\UserController@search');

//Menu Alamat
Route::apiResources(['alamat' => 'API\AlamatController']);
Route::apiResources(['rkk' => 'API\RkkController']);

//Meny Jadwal Shift
Route::apiResources(['schedule' => 'API\ScheduleController']);
Route::post('filterunit', 'API\ScheduleController@filterUnit');
Route::post('schedule/viewday', 'API\ScheduleController@viewDay');

// Route::get('show/{user}', 'API\UserController@show');
// Route::get('detail/{user}', 'API\UserController@show');
// Route::get('profile/{user}', 'API\UserController@show');
// Route::put('profileid', 'API\UserController@updateProfileId');
// Route::get('checkinout', 'API\UserController@checkinout');

//menu Skp
Route::apiResources(['skp' => 'API\SkpController']);
Route::get('getbylogin', 'API\SkpController@getByLogin');

//Menu Kegiatan Pegawai
Route::apiResources(['activity' => 'API\ActivitiesController']);
Route::post('activitybidper', 'API\ActivitiesController@createBidPer');
Route::put('activitybidperedit', 'API\ActivitiesController@updateBidPer');
Route::post('activity/bydate', 'API\ActivitiesController@byDate');
Route::post('activity/byuserdate', 'API\ActivitiesController@byUserDate');
Route::post('activity/getevent', 'API\ActivitiesController@getEvent');
Route::post('activity/geteventuser', 'API\ActivitiesController@getEventUser');
Route::put('activity/approve/{id}', 'API\ActivitiesController@Approve');
Route::put('activity/decline/{id}', 'API\ActivitiesController@Decline');

//Menu Master Data Jabatan
Route::get('jabatan-jfu', 'API\PositionController@showjfu');
Route::get('jabatan-jft', 'API\PositionController@showjft');
Route::apiResources(['position' => 'API\PositionController']);

//Menu Master Data Unit
Route::apiResources(['unit' => 'API\UnitController']);
Route::get('unitbybagian', 'API\UnitController@unitByBagian');

//Menu Master Data Shift
Route::apiResources(['shift' => 'API\ShiftController']);

//Menu Master Data Tupoksi JFT-JFU
Route::apiResources(['tupoksi' => 'API\TupoksiController']);
Route::post('tupoksi-jabatan', 'API\TupoksiController@filterJabatan');
Route::get('tupoksibyid/{id}', 'API\TupoksiController@tupoksiById');
Route::get('tupoksibylogin', 'API\TupoksiController@tupoksiByLogin');

// Menu Laporan Bulanan
Route::apiResources(['report' => 'API\MreportController']);
Route::post('report/getbydate', 'API\MreportController@getByDate');
Route::post('report/exec/user', 'API\MreportController@getUser');
Route::post('report/exec/userbelum', 'API\MreportController@getUserBelum');
Route::post('report/exec/usersudah', 'API\MreportController@getUserSudah');
Route::post('report/exec/getbyuserdate', 'API\MreportController@getByUserDate');
Route::post('report/exec/geteventuser', 'API\MreportController@getEventUser');
Route::post('report/exec/getallbydate', 'API\MreportController@getAllByDate');

