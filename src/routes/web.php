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
Route::namespace('ColanMYCIPL\TPVintegration\Http\Controllers')->group(function () {
    // Controllers Within The "App\Http\Controllers\Admin" Namespace
    /*twilio*/
Route::get('/tpvrecordings/test', 'VideoRoomsController@index');
Route::get('/tpvrecordings/csrftoken', 'VideoRoomsController@getCsrfToken');
Route::get('/twiliosynccreate', 'VideoRoomsController@twilioSyncCreate');
Route::post('/tpvrecordings/getallofroom', 'VideoRoomsController@getAllRecordingsOfRoom');
Route::post('/twilio/checkstatus', 'VideoRoomsController@twilioCheckStatus');
Route::post('/twilio/updatestatus', 'VideoRoomsController@completeRoom');
Route::post('tpvrecordings/createcomposition/teacherscreenview', 'VideoRoomsController@createCompositionTeacherScreenView');
/*Route::post('tpvrecordings/createcomposition/gridview', 'VideoRoomsController@createCompositionGridView');*/
Route::post('tpvrecordings/createcomposition/getmedia', 'VideoRoomsController@createCompositionGetMedia');
Route::post('/twilio/retriveparticipant', 'VideoRoomsController@retriveParticipant');
Route::post('/twilio/removeparticipant', 'VideoRoomsController@removeParticipant');
Route::get('/twilio/downloadrecordings/{id}', 'VideoRoomsController@DownloadRecordings')->name('tpvdownloadrecording');
Route::get('/twilio/getcompstatus/{id}', 'VideoRoomsController@getCompositionStatus');
Route::get('/twilio/checkrecording/{id}', 'VideoRoomsController@checkRecordingAvailability');
Route::post('/twilio/getparticipantacceptance', 'VideoRoomsController@getParticipantAcceptance');
Route::post('/twilio/muteallparticipants', 'VideoRoomsController@muteAllParticipants');
Route::post('/twilio/fetchparticipantsrule', 'VideoRoomsController@fetchParticipantRules');
Route::get('/twilio/twilioSyncTokenGenerationJson/{roomname}/{identity}', 'VideoRoomsController@twilioSyncTokenGenerationJson');
Route::get('/twilio/synctoken/{id}', 'VideoRoomsController@twilioSyncToken');
Route::get('/twilio/downloadstudentrecord/{classid}/{studentid}', 'VideoRoomsController@DownloadStudentRecordings')->name('tpvdownloadstudentrecording');
/*twilio*/


/*twilio class_join Teacher*/
Route::get('/teacher/join/twilioroom/{id}/{username}/{classname}', 'VideoRoomsController@teacherJoinRoom')->name('twilioroomteacher');
Route::post('/teacher/twilio/admitstudent', 'VideoRoomsController@twilioAdmitStudent')->name('twilioadmitstudent');
Route::post('/teacher/twilio/cancelstudent', 'VideoRoomsController@twilioCancelStudent')->name('twiliocancelstudent');
Route::post('/teacher/twilio/checkstudents', 'VideoRoomsController@twilioCheckStudent')->name('twiliocheckstudents');
/*twilio class_join Teacher*/

/*both teacher and student*/
Route::post('/twilio/roomupdate', 'VideoRoomsController@twilioRoomUpdate')->name('twilioupdate');
 /*both teacher and student*/

 /*twilio class_join Student*/
Route::get('/student/join/twilioroom/{id}/{username}/{studentid}', 'VideoRoomsController@studentJoinRoom')->name('twilioroomstudent');
Route::post('/student/twilio/checkstudentstatus', 'VideoRoomsController@checkStudentStatus')->name('twiliocheckstudent');
Route::post('/student/twilio/checkteststatus', 'VideoRoomsController@checkTestStatus')->name('twiliocheckteststatus');/*used to check proctor allowed the student to access twilio*/
Route::post('/student/twilio/participantrecord', 'VideoRoomsController@participantRecordUpdate')->name('twilioparticipantrecord');
 /*twilio class_join Student*/
});