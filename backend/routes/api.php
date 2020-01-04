<?php

use Illuminate\Http\Request;


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


Route::post('/getItem',['middleware'=>'cors',
    'uses'=>'DataController@bigFile'
]);

Route::get('/getAllCo/{code1}/{code2}',[
    'uses'=>'addCourceController@getAllCources'
]);

Route::post('/InsertNewCourseTosem',['middleware'=>'cors',
    'uses'=>'addCourceController@insertNewCourse'
]);

Route::post('/DeleteCourseFromosem',['middleware'=>'cors',
    'uses'=>'addCourceController@deleteCourse'
]);

Route::get('/getSem/{code}',[
    'uses'=>'addCourceController@getALLSelectedFiledSemesters'
]);

Route::get('/getCour/{code}',[
    'uses'=>'addCourceController@getCourceDetils'
]);
Route::get('/getselMin/{code}',[
    'uses'=>'addCourceController@getAllSelMinors'
]);

Route::post('/tt',[
    'uses'=>'addCourceController@updateCource'
]);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/getD',[
    'uses'=>'addCourceController@getAllDataFromDepartment'
]);
Route::post('/temp',[
    'uses'=>'studentRegistrationController@uploadResultCSV'
]);

Route::get('/getNewBatchYear',[
    'uses'=>'studentRegistrationController@getNewBatcName'
]);

Route::post('/registerNewStudents',[
    'uses'=>'studentRegistrationController@UpdateNewStudents'
]);


Route::post('/uploadingResults',[
    'uses'=>'resultController@uploadResult'
]);

Route::get('/getCourwithRes/{code}/{year}',[
    'uses'=>'resultController@getCourceDetails'
]);

//getSubjectResult
//updateResult

Route::post('/getSubjectResult',[
    'uses'=>'resultController@getSubjectResult'
]);
Route::post('/updateResult',[
    'uses'=>'resultController@updateResult'
]);

//getCourceDetailsWithREsults

Route::get('/getCourceDetailsWithREsults/{code}/{year}/{index}',[
    'uses'=>'resultController@getCourceDetailsWithREsults'
]);

Route::get('/getAllRepeatedSubjects/{index}',[
    'uses'=>'resultController@getAllRepeatedSubjects'
]);

Route::get('/gettotalGPA/{index}',[
    'uses'=>'resultController@getAllGPAforSubject'
]);


Route::post('userLogin','UserController@userLogin');

// Route::post('userLogin','UserController@studentLogin');


Route::post('studentLogin','UserController@studentLogin');
Route::get('setAllUsers','UserController@setAllUsers');
Route::post('userRegistration','UserController@userRegister');
Route::post('studentRegistration','UserController@studentRegister');
Route::post('UpdatingUser','UserController@UpdatingUser');

Route::post('studentRegistration1','UserController@studentRegister');


Route::group(['middleware'=>'auth:api'],function(){
    Route::get('userDetails','UserController@userDetails');  
    Route::get('getAdminDetails','adminRegistrationController@getAdminDetails');  
});

Route::get('getallYears','studentRegistrationController@getAllBatchs');  


// adminRegistrationController@getAdminDetails
