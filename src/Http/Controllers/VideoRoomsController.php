<?php 

namespace ColanMYCIPL\TPVintegration\Http\Controllers;

use App\Http\Controllers\Controller;
use Twilio\Rest\Client;
use Twilio\Jwt\AccessToken;
use Twilio\Jwt\Grants\VideoGrant;
use Twilio\Jwt\Grants\SyncGrant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TwilioRoom;
use App\Models\TwilioConnectedRoom;
use App\Models\TwilioConnectedParticipant;
use App\Models\TwilioParticipantRecord;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use League\Flysystem\ZipArchive\ZipArchiveAdapter;
use Illuminate\Support\Facades\Redirect;

class VideoRoomsController extends Controller
{
protected $sid;
protected $token;
protected $key;
protected $secret;
public $bucket;

public function __construct()
{
   $this->sid = config('twilioservices.twilio.sid');
   $this->token = config('twilioservices.twilio.token');
   $this->key = config('twilioservices.twilio.key');
   $this->secret = config('twilioservices.twilio.secret');
   $this->syncsid = config('twilioservices.twilio.syncsid');
   $this->bucket = Config('twilioservices.ses.aws_bucket_name');
}
  public function index()
{
  echo "Test Page";
   /*$rooms = [];
   try {

       $client = new Client($this->sid, $this->token);
       $allRooms = $client->video->rooms->read([]);

        $rooms = array_map(function($room) {
           return $room->uniqueName;
        }, $allRooms);

   } catch (Exception $e) {
       echo "Error: " . $e->getMessage();
   }
   return view('twilioindex', ['rooms' => $rooms]);*/
}
public function createRoom(Request $request)
{
   $client = new Client($this->sid, $this->token);

   $exists = $client->video->rooms->read([ 'uniqueName' => $request->roomName]);

   if (empty($exists)) {
       $response=$client->video->rooms->create([
           'uniqueName' => $request->roomName,
           'type' => 'group',
           'recordParticipantsOnConnect' => true
       ]);

       \Log::debug("created new room: ".$request->roomName);
   }

   return $response;
}

public function joinRoom($roomName,$identity)
{
 
//$identity = $username;
   \Log::debug("joined with identity: $identity");
   $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);

   $videoGrant = new VideoGrant();
   $videoGrant->setRoom($roomName);

   $token->addGrant($videoGrant);
   $array["accessToken"] = $token->toJWT();
        $array["roomName"] = $roomName;
return $array;
//return true;
   //return view('room', [ 'accessToken' => $token->toJWT(), 'roomName' => $roomName ]);
}

/*Teacher Functionalities*/
  /*twilio - TPV*/
    public function teacherJoinRoom($roomName,$username,$classname){
    $room= new VideoRoomsController();
    //$username=\Auth::guard('teacher')->user()->f_name . " " . \Auth::guard('teacher')->user()->l_name;
    $identity='teacher_'.$username;
    $response=$room->joinRoom($roomName,$identity);
    $prefix_room = explode ("\_", $roomName);
    //$room1=Classes::where('id',$prefix_room[0])->first();
    $syncresponse=$room->twilioSyncTokenGeneration($roomName,$identity);
  return view('twilio_room_teacher', [ 'accessToken' => $response['accessToken'],'syncaccessToken' => $syncresponse['syncaccessToken'], 'roomName' => $response['roomName'],'username' => $username,'classname' => $classname //$room1->class_name
]);
    //dd($response['accessToken']);
    }
    public function twilioRoomUpdate(Request $request){
       $tpvroom = TwilioConnectedRoom::where('room_sid',$request->roomsid)->first();
       $class = TwilioRoom::where('room_name',$request->roomname)->first();
       if(empty($tpvroom->id)){
        $tpvnewroom= new TwilioConnectedRoom();
        $tpvnewroom->room_sid=$request->roomsid;
        $tpvnewroom->class_id=$class->class_id;
        $tpvnewroom->access_token=$request->accesstoken;
        $tpvnewroom->room_name=$request->roomname;
        $tpvnewroom->save();
       }
       return 1;
    }
    public function twilioAdmitStudent(Request $request){
      $tpv=TwilioConnectedParticipant::where('participant_identity',$request->username)->where('room_name',$request->roomname)->first();
      if(!empty($tpv)){
        $tpvupdate=TwilioConnectedParticipant::find($tpv->id);
        $tpvupdate->teacher_accepted=1;
        $tpvupdate->save();
      }
      return $request->username." particpant accepted";
    }
    public function twilioCancelStudent(Request $request){
      $tpv=TwilioConnectedParticipant::where('participant_identity',$request->username)->where('room_name',$request->roomname)->first();
      if(!empty($tpv)){
        $tpvupdate=TwilioConnectedParticipant::find($tpv->id);
        $tpvupdate->teacher_accepted=0;
        $tpvupdate->save();
      }
      return $request->username." particpant rejected";
    }
    public function  twilioCheckStudent(Request $request){
      $tpv=TwilioConnectedParticipant::where('teacher_accepted',null)->where('room_name',$request->roomname)->first();
      if(!empty($tpv)){
       return $tpv->participant_identity;
      }
      else{
        return 0;
      }
      
    }
     /*twilio - TPV*/

/*teacher*/

/*Student Functionalities*/
    /*twilio -Tpv*/
public function studentJoinRoom($roomName,$username,$studentid){
//$username=\Auth::guard('student')->user()->f_name . " " . \Auth::guard('student')->user()->l_name;
$tpv=TwilioConnectedParticipant::where('participant_identity',$username)->where('room_name',$roomName)->first();
if(empty($tpv)){
    $tpvsave=new TwilioConnectedParticipant();
    $tpvsave->participant_identity=$username;
    $tpvsave->room_name=$roomName;
    $tpvsave->save();
    return view('twilio_room_student_firstpage', ['roomName' => $roomName,'username' => $username,'studentid'=>$studentid]);
}
if(!empty($tpv) && (($tpv->teacher_accepted==0)  || ($tpv->teacher_accepted==null))){
return view('twilio_room_student_firstpage', ['roomName' => $roomName,'username' => $username,'studentid'=>$studentid]);
}
else{
   $room= new VideoRoomsController();
$identity='student_'.$username;
$response=$room->joinRoom($roomName,$identity);
$syncresponse=$room->twilioSyncTokenGeneration($roomName,$identity);
return view('twilio_room_student', [ 'accessToken' => $response['accessToken'],'syncaccessToken' => $syncresponse['syncaccessToken'], 'roomName' => $response['roomName'],'username' => $username,'studentid'=>$studentid]);
//dd($response['accessToken']); 
}
}
public function checkStudentStatus(Request $request){
    $tpv=TwilioConnectedParticipant::where('participant_identity',$request->username)->where('room_name',$request->roomname)->first();
    if(empty($tpv)){
    $tpvsave=new TwilioConnectedParticipant();
    $tpvsave->participant_identity=$request->username;
    $tpvsave->room_name=$request->roomname;
    //$tpvsave->student_id=Auth::guard('student')->user()->id;
    $tpvsave->student_id=$request->studentid;
    $tpvsave->save();
    return view('twilio_room_student_firstpage', ['roomName' => $request->roomname,'username' => $request->username ]);
   } 
   else{
    return $tpv->teacher_accepted;
   }
}
/*used to check proctor allowed the student to access twilio*/
public function checkTestStatus(Request $request){
  //$tpvzoom=ClassStudent::with('student')->where('class_id',$request->classid)->where('student_id',Auth::guard('student')->user()->id)->where('allowzoom_reload',0)->where('allowzoom',1)->first();
    $tpvzoom=ClassStudent::with('student')->where('class_id',$request->classid)->where('student_id',$request->studentid)->where('allowzoom_reload',0)->where('allowzoom',1)->first();
$room=TwilioRoom::where('class_id',$request->classid)->first();
    if(!empty($tpvzoom)){
            if($tpvzoom->allowzoom==1){
             $update_classstudent=ClassStudent::where('id',$tpvzoom->id)->first();
             $update_classstudent->allowzoom_reload=1;
             $update_classstudent->save();
             return 1;
           }
    }
     //$tpvtest=ClassStudent::with('student')->where('class_id',$request->classid)->where('student_id',Auth::guard('student')->user()->id)->where('allowtest_reload',0)->where('allowtest',1)->first(); 
    $tpvtest=ClassStudent::with('student')->where('class_id',$request->classid)->where('student_id',$request->studentid)->where('allowtest_reload',0)->where('allowtest',1)->first();
    if(!empty($tpvtest)){
        if($tpvtest->allowtest==1){
            $update_classstudent=ClassStudent::where('id',$tpvtest->id)->first();
             $update_classstudent->allowtest_reload=1;
             $update_classstudent->save();
             return 1;     
        }
    }


}
/*used to check proctor allowed the student to access twilio*/


public function participantRecordUpdate(Request $request){

$twilioroom=TwilioRoom::where('room_name',$request->roomname)->first();

    $tpvsave=new TwilioParticipantRecord();
    $tpvsave->participant_identity=$request->participantidentity;
    $tpvsave->room_name=$request->roomname;
    $tpvsave->room_sid=$request->roomsid;
    $tpvsave->student_id=$request->studentid;
    //$tpvsave->student_id=Auth::guard('student')->user()->id;
    $tpvsave->class_id=$twilioroom->class_id;
    $tpvsave->participant_sid=$request->participantsid;
    $tpvsave->save();
    return 1;
}
/*twilio - TPV*/
/*student Functionalities*/



public function completeRoom(Request $request){
  $twilioroom=TwilioRoom::where('room_name',$request->roomname)->first();
  $client = new Client($this->sid, $this->token);
  $room = $client->video->v1->rooms($request->roomsid)
                      ->update("completed");
/*    $twilioupdate = TwilioRoom::find($twilioroom->id);
    $twilioupdate->status = 'completed';
    $twilioupdate->save();*/
return $room->status;
}
public function twilioCheckStatus(Request $request){

  $client = new Client($this->sid, $this->token);
  $room = $client->video->v1->rooms($request->roomsid)
                          ->fetch();
  return $room->status;
}
/*Recordings*/
public function getAllRecordingsOfRoom(Request $request){
  $client = new Client($this->sid, $this->token);
/*$recordings = $client->video->v1->recordings
                                ->read([
                                           "groupingSid" => ["RMb1fe371d7b16c61f5c88f70967c0b546"]
                                       ],
                                       20
                                );

foreach ($recordings as $record) {
    print($record->sid);
}*/
$recordings = $client->video->v1->rooms($request->roomsid)
                                ->recordings
                                ->read([], 20);

foreach ($recordings as $record) {
    print($record->sid);
}
}
public function getCsrfToken(){
  return csrf_token(); 
}
public function listAllCompositions(){
  $client = new Client($this->sid, $this->token);
  $compositions = $client->video->compositions
    ->read([
      'status' => 'completed'
    ]);
    foreach ($compositions as $c) {
    echo $c->sid;
}
}

public function createComposition(Request $request){
 $client = new Client($this->sid, $this->token);
 $composition = $client->video->compositions->create($request->roomsid, [
    'audioSources' => '*',
    'videoLayout' =>  array(
                        'main' => array (
                            'z_pos' => 1,
                            'video_sources' => array('teacher-screen-video')
                        ),
                        'row' => array(
                            'z_pos' => 2,
                            'x_pos' => 10,
                            'y_pos' => 530,
                            'width' => 1260,
                            'height' => 160,
                            'max_rows' => 1,
                            'video_sources' => array('*'),
                            'video_sources_excluded' => array('teacher-screen-video')
                        )
                      ),
    'statusCallback' => 'http://my.server.org/callbacks',
    'resolution' => '1280x720',
    'format' => 'mp4'
]);

}
public function createCompositionGridView($roomsid){
   $client = new Client($this->sid, $this->token);
   $composition = $client->video->compositions->create($roomsid, [
    'audioSources' => '*',
    'videoLayout' =>  array(
                        'grid' => array (
                          'video_sources' => array('*')
                        )
                      ),
    'statusCallback' => 'http://my.server.org/callbacks',
    'format' => 'mp4'
]);

return $composition->sid;
}
public function createCompositionStudentsRecordings($roomsid,$partid){
$client = new Client($this->sid, $this->token);
$composition = $client->video->compositions->create($roomsid, [
    'audioSources' => '*',
    'videoLayout' =>  array(
                        'single' => array (
                          'video_sources' => array($partid)
                        )
                      ),
    'statusCallback' => 'http://my.server.org/callbacks',
    'format' => 'mp4'
]);
return $composition->sid;
}
public function createCompositionGetMedia(Request $request){
$client = new Client($this->sid, $this->token);
$compositionSid = $request->compsid;
$uri = "https://video.twilio.com/v1/Compositions/".$request->compsid."/Media?Ttl=3600";
$response = $client->request("GET", $uri);
$mediaLocation = $response->getContent()["redirect_to"];
echo $mediaLocation; 
}

public function DownloadRecordings($classid){
$client = new Client($this->sid, $this->token);
$tpvrooms = TwilioConnectedRoom::where('class_id',$classid)->groupBy('room_sid')
                 ->get();
if(file_exists(public_path('recordings.zip'))){
    unlink(public_path('recordings.zip'));
}
$zip = new Filesystem(new ZipArchiveAdapter(public_path('recordings.zip')));
$clientnew = new \GuzzleHttp\Client();
foreach ($tpvrooms as $tpvroom) {
if(!empty($tpvroom->comp_sid) && ($tpvroom->comp_status == "completed")){
$uri = "https://video.twilio.com/v1/Compositions/".$tpvroom->comp_sid."/Media?Ttl=3600";
$response = $client->request("GET", $uri);
$mediaLocation = $response->getContent()["redirect_to"];
//$generate_url = $request->getUri();
$responsenew = $clientnew->get($mediaLocation);
$content = $responsenew->getBody();
$filename=$tpvroom->comp_sid.'.mp4';
$zip->put($filename,$content);
}
}
$zip->getAdapter()->getArchive()->close();
return response()->download(public_path('recordings.zip'));  
}
public function DownloadStudentRecordings($classid,$studentid){
$disk = \Storage::disk('s3');
$filename='Testfiles_classid_'.$classid.'/studentrecordings/'.('studentrecordings_'.$studentid.'.zip');
if ($disk->exists($filename))
{
return \Storage::disk('s3')->download($filename);
}
else{
return Redirect::back()->with('message','Recording Not Found');
}
}
public function MoveStudentRecordingS3($classid,$studentid){
  $client = new Client($this->sid, $this->token);
  $tpvparticipantrecords_comp = TwilioParticipantRecord::where('class_id',$classid)->where('comp_status','completed')->where('student_id',$studentid)->get();
  $zip = new Filesystem(new ZipArchiveAdapter(storage_path('app/public/').'Testfiles_classid_'.$classid.'/studentrecordings/'.('studentrecordings_'.$studentid.'.zip')));
$clientnew = new \GuzzleHttp\Client();
  foreach ($tpvparticipantrecords_comp as $tp_comp) {
$uri = "https://video.twilio.com/v1/Compositions/".$tp_comp->comp_sid."/Media?Ttl=3600";
$response = $client->request("GET", $uri);
$mediaLocation = $response->getContent()["redirect_to"];
//$generate_url = $request->getUri();
$responsenew = $clientnew->get($mediaLocation);
$content = $responsenew->getBody();
$filename='studentid_'.$studentid.'_'.$tp_comp->comp_sid.'.mp4';
$zip->put($filename,$content);
}
$zip->getAdapter()->getArchive()->close();

$filepath=storage_path('app/public/').'Testfiles_classid_'.$classid.'/studentrecordings/';
$zipfilename='studentrecordings_'.$studentid.'.zip';
$file = $filepath.$zipfilename;
//file_put_contents ($file, $content);
Storage::disk('s3')->put('Testfiles_classid_'.$classid.'/studentrecordings/'.$zipfilename, fopen($file, 'r+'));
unlink($file);
return 1;
}

public function previewTPVRecording($classid){
  $tpvrooms = TwilioConnectedRoom::where('class_id',$classid)->groupBy('room_sid')
             ->get();
  $client = new Client($this->sid, $this->token);
    $preview = [];
    foreach ($tpvrooms as $tpvroom) {
      if(!empty($tpvroom->comp_sid) && ($tpvroom->comp_status=="completed")){
            $uri = "https://video.twilio.com/v1/Compositions/".$tpvroom->comp_sid."/Media?Ttl=3600";
            $response = $client->request("GET", $uri);
             $mediaLocation = $response->getContent()["redirect_to"];
             //$compurl=$mediaLocation->getUri();
            array_push($preview, $mediaLocation);
      }
    }
    return $preview;
}
public function checkRecordingAvailability($roomsid){
  $client = new Client($this->sid, $this->token);
  $recordings = $client->video->v1->rooms($roomsid)
                                ->recordings
                                ->read([], 20);

foreach ($recordings as $record) {
    return $record->sid;
}
}
/*Recordings-end*/
/*particpant*/
public function retriveParticipant(Request $request){
$client = new Client($this->sid, $this->token);
$participant = $client->video->rooms($request->roomsid)
      ->participants($request->particpantidentity)
      ->fetch();

return $participant->status;
}
public function removeParticipant(Request $request){
  $client = new Client($this->sid, $this->token);
  $participant = $client->video->rooms($request->roomsid)
    ->participants($request->particpantidentity)
    ->update(array("status" => "disconnected"));

return $participant->status;
}
public function getCompositionStatus($compsid){
$client = new Client($this->sid, $this->token);
$composition = $client->video->compositions($compsid)
    ->fetch();

return $composition->status;
}
public function getParticipantAcceptance(Request $request){
  $tpv=TwilioConnectedParticipant::where('participant_identity',$request->username)->where('room_name',$request->roomname)->first();
   if(empty($tpv) || ($tpv->teacher_acceptance==null)){
    return 0;
   }
   else
   {
    return 1;
   }
}
/*particpant*/
/*twilio sync*/
/*twilio sync*/
public function twilioSyncTokenGeneration($roomName,$identity){
$token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);

$syncGrant = new SyncGrant();
$syncGrant->setServiceSid($this->syncsid);
$token->addGrant($syncGrant);
$array1["syncaccessToken"] = $token->toJWT();
return $array1;
}
public function twilioSyncToken($identity){

$token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);
$syncGrant = new SyncGrant();
$syncGrant->setServiceSid($this->syncsid);
$token->addGrant($syncGrant);
$arr = array('syncaccessToken' => $token->toJWT(), 'identity' => $identity);
return json_encode($arr);
}

/*twilio sync*/
/*Muteall and Unmuteall remote participants - still in development*/
public function muteAllParticipants(Request $request){
  $client = new Client($this->sid, $this->token);
  $participant = $client->video->rooms($request->roomsid)->participants($request->participantsid)->subscribeRules->update(["rules" => [["type" => "include", "all" => true],["type" => "exclude", "kind" => "video"]]]);

echo 'Subscribe Rules updated successfully';
}
public function fetchParticipantRules(Request $request){
  $client = new Client($this->sid, $this->token);
$subscribeRules = $client->video->rooms($request->roomsid)->participants($request->participantsid)->subscribeRules->fetch();

foreach ($subscribeRules->rules as $rule) {
    echo "Read rule with type = " . $rule["type"];
}
}
public function twilioSyncCreate(){
  $client = new Client($this->sid, $this->token);
  $service = $client->sync->v1->services
                            ->create();

print($service->sid);
}

public function unmuteAllparticipants(Request $request){
  $tpv=TwilioConnectedParticipant::where('participant_identity',$request->username)->where('room_name',$request->roomname)->first();
   if(empty($tpv) || ($tpv->teacher_acceptance==null)){
    return 0;
   }
   else
   {
    return 1;
   }
}
/*Muteall and Unmuteall remote participants - still in development*/
}