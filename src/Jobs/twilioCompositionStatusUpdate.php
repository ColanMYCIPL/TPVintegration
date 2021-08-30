<?php

namespace App\Jobs;

use App\Models\Classes;
use App\Models\Settings;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\VideoRoomsController;
use App\TwilioRoom;
use App\TwilioConnectedRoom;
use App\TwilioConnectedParticipant;
use App\TwilioParticipantRecord;

class twilioCompositionStatusUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        \Log::info("twilio room recording status update cron executed");
        $classes = Classes::with('twilio_room','teacher','twilio_connected_room')->where('status',1)->where(\DB::raw("CONCAT(`schedule_date`,' ',`schedule_to_time`)"),'<', Carbon::now())->get();
        foreach($classes as $class){
            try{
             if(!empty($class->twilio_room)){
                \Log::info("twilio class ".$class->id);
               $tpvrooms = TwilioConnectedRoom::where('class_id',$class->id)->groupBy('room_sid')->get();
                 $twilioroom=TwilioRoom::where('class_id',$class->id)->first();
                 
                  /*check room have recordings*/
  $check_tpvrooms_record = TwilioConnectedRoom::where('class_id',$class->id)->first();
 
                if(isset($check_tpvrooms_record) && !empty($check_tpvrooms_record->room_sid)){
                                         \Log::info("twilio room sid check".$check_tpvrooms_record->room_sid);
                    $record_check=new VideoRoomsController();
                    $record_available=$record_check->checkRecordingAvailability($check_tpvrooms_record->room_sid);
                    }

            if(!empty($record_available)){
              /*twilio participants recordings*/
        $tpvparticipantrecords = TwilioParticipantRecord::where('class_id',$class->id)->get();
            /*twilio participants recordings*/
                  foreach ($tpvparticipantrecords as $partrecord) {
                   if(empty($partrecord->comp_sid)){
                     \Log::info("twilio create comp participant ".$partrecord->student_id);
                              $part_comp_create=new VideoRoomsController();
                              $part_compsid=$part_comp_create->createCompositionStudentsRecordings($partrecord->room_sid,$partrecord->participant_sid);
                              if(!empty($part_compsid)){
                                TwilioParticipantRecord::where('room_sid',$partrecord->room_sid)->where('participant_sid',$partrecord->participant_sid)->update([ 'comp_sid' => $part_compsid]);
                              }
                            }
                        else{
                               $part_compsid=$partrecord->comp_sid;
                            }
                    \Log::info("twilio create comp status nasi ".$partrecord->comp_status);
                      if(!empty($part_compsid) && ($partrecord->comp_status!="completed")){
                                \Log::info("twilio class comp_status ".$class->id);
                                $comp_update_part=new VideoRoomsController();
                                $compstatus_part=$comp_update_part->getCompositionStatus($part_compsid);
                                TwilioParticipantRecord::where('room_sid',$partrecord->room_sid)->where('comp_sid',$part_compsid)->where('participant_sid',$partrecord->participant_sid)->update([ 'comp_status' => $compstatus_part]);
                              \Log::info("twilio participant studentid".$partrecord->student_id);
                              \Log::info("twilio participant comp status".$compstatus_part);
                              if($compstatus_part=="completed"){
                                $record_up_s3=new VideoRoomsController();
                                $record_comp=$record_up_s3->MoveStudentRecordingS3($class->id,$partrecord->student_id);
                              }
                            }
                  } /*participant foreach*/
              /*twilio participants recordings*/
              /*twilio room recording*/
                 \Log::info("twilio class recordavailable ".$class->id);
                 foreach ($tpvrooms as $tpvroom) {
                           if(empty($tpvroom->comp_sid)){
                              $comp_create=new VideoRoomsController();
                              $compsid=$comp_create->createCompositionGridView($tpvroom->room_sid);
                              if(!empty($compsid)){
                                TwilioConnectedRoom::where('room_sid',$tpvroom->room_sid)->update([ 'comp_sid' => $compsid]);
                              }
                            }
                            else{
                               $compsid=$tpvroom->comp_sid;
                            }
                            if(!empty($compsid) && ($tpvroom->comp_status!="completed")){
                                \Log::info("twilio class comp_status ".$class->id);
                                $comp_update=new VideoRoomsController();
                                $compstatus=$comp_update->getCompositionStatus($compsid);
                                TwilioConnectedRoom::where('room_sid',$tpvroom->room_sid)->where('comp_sid',$compsid)->update([ 'comp_status' => $compstatus]);
                              \Log::info("twilio class comp_status value ".$compstatus);
                              $tpvcheck=TwilioConnectedRoom::where('room_sid',$tpvroom->room_sid)->where('comp_status', '!=' , 'completed')->first();

                              $tpv_participant_check=TwilioParticipantRecord::where('class_id',$class->id)->where('comp_status','completed')->get();
                              
                              $tpv_participant_check2=TwilioParticipantRecord::where('class_id',$class->id)->get();

                              $count1 = $tpv_participant_check->count();
                              $count2 = $tpv_participant_check2->count();
                            if(empty($tpvcheck->id) && ($compstatus=='completed') && ($count1==$count2)){
                                \Log::info("twilio class tpvcheck ".$class->id);
                                $updateclass= Classes::find($class->id);
                               $updateclass->status = 2;
                                  $updateclass->save(); 

                                  $tpvroomupdate=TwilioRoom::find($twilioroom->id);
                                  $tpvroomupdate->comp_status="completed";
                                  $tpvroomupdate->save();

                            }

                            }
                        
                  }
                  /*twilio room recording*/
            }
            else{
                    $updateclass= Classes::find($class->id);
                    $updateclass->status = 2;
                    $updateclass->save(); 
            }
             }
            }
            catch (Exception $e) {
              \Log::info("twilioCompositionStatusUpdate error".$e);
            }
        }
    }
}
