$(document).ready(function(){
  navigator.getMedia = ( navigator.getUserMedia || // use the proper vendor prefix
                       navigator.webkitGetUserMedia ||
                       navigator.mozGetUserMedia ||
                       navigator.msGetUserMedia);

navigator.getMedia({video: true}, function() {
const muteAudio = document.getElementById('muteAudio');
let connected = false;
const shareScreen = document.getElementById('share_screen');
var screenTrack;
const stopRecord = document.getElementById('stopRecord');
const startRecord = document.getElementById('startRecord');
var recordset = true;
var participantCount=0;
var galleryview=true;
let lastSpeakerSID = null; 
var whiteboardactivated=false;

/*console.log("accessToken"+accessToken);
console.log("roomName"+roomName);*/

    Twilio.Video.createLocalTracks({
       audio: true,
       video: { width: 400,height: 500 }
    }).then(function(localTracks) {
       return Twilio.Video.connect(accessToken, {
           name: roomName,
           tracks: localTracks,
           audio: { name: 'microphone' },
           RecordParticipantsOnConnect:recordset,
           dominantSpeaker: true,
           video: { width: 400,height: 500 }
       });

    }).then(function(room) {
          console.log('Successfully joined a Room nasinew: ', room);
          console.log('Successfully joined a Room: ', room.name);
          console.log('localTracks ', room.tracks);
          console.log('Successfully joined a Room sid: ', room.sid);
          /*to save room details*/
                    var URLroom = '/twilio/roomupdate';
                    $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:URLroom,
                    type: 'POST',
                    data:{roomname:roomName,roomsid:room.sid,accesstoken:accessToken},
                    success: function(response) {
                      console.log("details saved Successfully");
                    }
                    });
          /*to save room details*/


            
           
           room.participants.forEach(participantConnected);

           var previewContainer = document.getElementById(room.localParticipant.sid);
           if (!previewContainer || !previewContainer.querySelector('video')) {
               participantConnected(room.localParticipant);
           }

           room.on('participantConnected', function(participant) {
            console.log("participant"+participant);
               console.log("Joining: "+participant.identity);
               participantConnected(participant);
           });

           room.on('participantDisconnected', function(participant) {
               console.log("Disconnected:" +participant.identity);
               participantDisconnected(participant);
           });
            room.on('dominantSpeakerChanged', function(participant) {
              handleSpeakerChange(participant);
               console.log("The new dominant speaker in the Room is:" +participant.identity);
           });




  /*check status*/
          window.setInterval(function(){
                getroomstatus(room.sid);
            }, 5000);
  /*check status*/
/*screenshare - start*/
  $(document).on("click", "#share_screen", function(){  
        //handleTrackDisabled(publication.track);
        //console.log("particpant id"+participant.identity);
    if (!screenTrack) {
              navigator.mediaDevices.getDisplayMedia().then(stream => {
                  screenTrack = new Twilio.Video.LocalVideoTrack(stream.getTracks()[0]);
                  room.localParticipant.publishTrack(screenTrack);
                  var screenshareon=document.getElementById('teacher_div').getElementsByTagName("video")[1];
                  console.log("screen_share_is_on:"+screenshareon);
                  var screenshareonstudent=document.getElementById('student_div').getElementsByTagName("video")[1];

                  if (screenshareon){ 
                    screenshareon.classList.add("teacher_screen"); 
                    console.log("screenTrack teacher"+screenTrack);
                    const div1 = document.createElement('div');
                    //div1.classList.add("screenshare_view"); 
                    //div1.setAttribute("style", "width: 100px;height: 100px !important;position: absolute;bottom: 0;z-index: 9999;right: 0;");
                    document.getElementById('main_content_twilio').appendChild(div1,screenshareon);
                    screenshareon.style.display = 'none';
                  }
                
               if(screenshareonstudent){
                     screenshareonstudent.classList.add("student_screen"); 
                    console.log("screenTrack student"+screenTrack);
                    const div2 = document.createElement('div');
                    //div1.classList.add("screenshare_view"); 
                    //div1.setAttribute("style", "width: 100px;height: 100px !important;position: absolute;bottom: 0;z-index: 9999;right: 0;");
                    document.getElementById('main_content_twilio').appendChild(div2,screenshareonstudent);
                    screenshareonstudent.style.display = 'none';
                    }

                  screenTrack.mediaStreamTrack.onended = () => {
                  room.localParticipant.unpublishTrack(screenTrack);
                  screenTrack.stop();
                  screenTrack = null;
                  };
              }).catch((err) => {
              console.log("err"+err);
              });
        }
        else {
              room.localParticipant.unpublishTrack(screenTrack);
              screenTrack.stop();
              screenTrack = null;
        } 
});
/*screenshare - end*/

/*Mute audio all- start*/
$(document).on("click", "#muteall", function(){  
 room.participants.forEach(tracks=> {
console.log("muteallnew");
for (const [key, value] of Object.entries(tracks)) {
console.log(key, value);
}
    
        
 });   
  });
/*Mute audio all- stop*/

/*gallery-view*/
$(document).on("click", "#enable_gallery_view", function(){  
$("#enable_normal_view").show(); 
$('#student_div').addClass('gallery_view_enabled');
 $("#enable_gallery_view").hide();
 $("#white_board_popup").hide();
  });
$(document).on("click", "#enable_normal_view", function(){  
$("#enable_normal_view").hide();
$('#student_div').removeClass('gallery_view_enabled');
 $("#enable_gallery_view").show();
  });
/*gallery-view*/

/*Mute Video - start*/
$(document).on("click", "#muteAudio", function(){  
            room.localParticipant.audioTracks.forEach(publication => {
            publication.track.disable();
            });
            $('.custom_muteaudio_teacher').hide();
            $('.custom_unmuteaudio_teacher').show();
            room.participants.forEach(participant => {
            participant.tracks.forEach(publication => {
            if (publication.isSubscribed) {
            handleTrackDisabled(publication.track);
            }
            publication.on('subscribed', handleTrackDisabled);
            });
            });     
  });
/*Mute Video - start*/
/*Unmute Video - start*/
$(document).on("click", "#unmuteAudio", function(){
    console.log("unmuteAudio");
    room.localParticipant.audioTracks.forEach(publication => {
      publication.track.enable();
    });
      $('.custom_muteaudio_teacher').show();
      $('.custom_unmuteaudio_teacher').hide();
    room.participants.forEach(participant => {
    participant.tracks.forEach(publication => {
        if (publication.isSubscribed) {
        handleTrackEnabled(publication.track);
        }
        publication.on('subscribed', handleTrackEnabled);
    });
    });
 });
/*Unmute Video - end*/
/*Stop Video - start*/
$(document).on("click", "#stopVideo", function(){
      console.log("video stopped");
      room.localParticipant.videoTracks.forEach(publication => {
        publication.track.disable();
      });
      $('.custom_stopvideo_teacher').hide();
      $('.custom_startvideo_teacher').show();
      room.participants.forEach(participant => {
        participant.tracks.forEach(publication => {
          if (publication.isSubscribed) {
            handleTrackDisabled(publication.track);
          }
          publication.on('subscribed', handleTrackDisabled);
        });
      });
});
/*Stop Video - end*/
/*Start Video - start*/
$(document).on("click", "#startVideo", function(){
     room.localParticipant.videoTracks.forEach(publication => {
          publication.track.enable();
           console.log("video started");
      });
      $('.custom_stopvideo_teacher').show();
      $('.custom_startvideo_teacher').hide();
      room.participants.forEach(participant => {
      participant.tracks.forEach(publication => {
        if (publication.isSubscribed) {
          handleTrackEnabled(publication.track);
        }
        publication.on('subscribed', handleTrackEnabled);
      });
      });
});
/*Start Video - end*/

/*Record start- start*/
$(document).on("click", "#startRecord", function(){
  recordset=true;
  console.log("recordset-startRecord-"+recordset);
      $('.custom_stoprecord_teacher').show();
      $('.custom_startrecord_teacher').hide();
});
/*Record start - end*/

/*Record stop - start*/
$(document).on("click", "#stopRecord", function(){
  recordset=false;
   console.log("recordset-stopRecord-"+recordset);
      $('.custom_startrecord_teacher').show();
      $('.custom_stoprecord_teacher').hide();
});
/*Record stop - end*/
/*Teacher end class for all - start*/
$(document).on("click", "#endClass", function(){
  console.log("endclass");
 var URL1 = '/twilio/updatestatus';
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:URL1,
        type: 'POST',
        data:{roomname:roomName,roomsid:room.sid},
        success: function(result){
            //console.log("roomstatus"+result); 
            window.setTimeout('alert("Meeting Ended");window.close();', 1000);           
        }
    });
});
/*Teacher end class for all - end*/

/*$(document).on("click", "#whiteboard", function(){
  console.log("call disconnected");

});*/
/*participantremove*/
$(document).on("click", "#leaveClass", function(){
  console.log("leaveClass");
 room.localParticipant.videoTracks.forEach(track => {
        track.disable();
      });
  room.localParticipant.audioTracks.forEach(track => {
        track.disable();
      });
   window.setTimeout('alert("You  the Meeting");window.close();', 3000);
});
/*participantremove*/

/*check room status and participant status*/
function getroomstatus(roomsid){
    var URL = '/twilio/checkstatus';
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:URL,
        type: 'POST',
        data:{roomname:roomName,roomsid:roomsid},
        success: function(result){
            console.log("roomstatus"+result); 
            if(result=="completed"){
              window.setTimeout('alert("Meeting Completed");window.close();', 1000);
            }           
        }
    });
  
  var retriveparticpantstatusurl = '/twilio/retriveparticipant';
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:retriveparticpantstatusurl,
        type: 'POST',
        data:{particpantidentity:room.localParticipant.sid,roomsid:roomsid},
        success: function(result){
          console.log("particpantstatus"+result);
            if(result=="disconnected"){
              window.setTimeout('alert("Teacher Removed You from Meeting");window.close();', 1000);
            }              
        }
    });
}
/*check room status and participant status*/
function handleTrackEnabled(track) {
  track.on('enabled', () => {
    /* Hide the avatar image and show the associated <video> element. */
    //console.log('Participant "%s" enabled', participant.identity);
  });
}
function handleTrackDisabled(track) {
  track.on('disabled', () => {
    window.close();
  });
}

function participantConnected(participant) {
       console.log('Participant "%s" connected', participant.identity);
        var str1 = "teacher_";
        var str2 = "student_";

/*participant remove class - start*/
room.participants.forEach(participant => {
  var particsid="#student_"+participant.sid;
  var removesid="#remove_"+participant.sid;
  var mutesid="#mute_"+participant.sid;
  var unmutesid="#unmute_"+participant.sid;
  var stopvideosid="#stopvideo_"+participant.sid;
  var startvideosid="#startvideo_"+participant.sid;


$(document).on("click", particsid, function(){
  console.log("removeParticipant"+participant.identity);
  var removeparticipanturl = '/twilio/removeparticipant';
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:removeparticipanturl,
        type: 'POST',
        data:{particpantidentity:participant.sid,roomsid:room.sid},
        success: function(result){
            console.log("participant removed"); 
            $(removesid).hide();          
        }
    });
});
/*participant remove class - end*/

/*participant media options manage - start*/
$(document).on("click", mutesid, function(){
  console.log("muteparticipant"+participant.identity);
    var psid = mutesid.replace('#mute_','');
  let participantsid = psid.split(" ")[0]; 
if(room.localParticipant.sid == participantsid){
           room.localParticipant.audioTracks.forEach(track => {
            track.disable();
            });
}
$(mutesid).hide();
$(unmutesid).show();
});

$(document).on("click", stopvideosid, function(){
    var psid = stopvideosid.replace('#stopvideo_','');
  let participantsid = psid.split(" ")[0]; 
   participant.tracks.forEach(function(track) {
    if(participant.sid==participantsid){
      console.log("participantsidstopvideo"+track);
       trackRemoved(track);
    } 
   });
$(stopvideosid).hide();
$(startvideosid).show();
});

$(document).on("click", unmutesid, function(){
  console.log("muteparticipant"+participant.identity);
    var psid = unmutesid.replace('#unmute_','');
  let participantsid = psid.split(" ")[0]; 
if(room.localParticipant.sid == participantsid){
           room.localParticipant.audioTracks.forEach(track => {
            track.disable();
            });
}
$(unmutesid).hide();
$(mutesid).show();
});

$(document).on("click", startvideosid, function(){
  console.log("muteparticipant"+participant.identity);
    var psid = startvideosid.replace('#startvideo_','');
  let participantsid = stopvideosid.split(" ")[0]; 
if(room.localParticipant.sid == participantsid){
           room.localParticipant.audioTracks.forEach(track => {
            track.disable();
            });
}
$(startvideosid).hide();
$(stopvideosid).show();
});

});
/*participant media options manage - end*/

    /*Teacher connect*/
    if(participant.identity.indexOf(str1) != -1){
          console.log('teacher connected');
          const div = document.createElement('div');
           div.id = participant.sid;
           //div.setAttribute("style", "margin: center;float: left;margin: 10px;padding: 0px;margin: 0px;margin-top: 5px;");
          div.classList.add("teacher_div_view");
          div.setAttribute('class', 'teacher_div_view participantZoomedTeacher');
          //div.setAttribute('class', 'participant');
div.addEventListener('click', () => { zoomTrackTeacher(participant); });

participant.tracks.forEach(function(track) {
participant.on('trackSubscribed', track => trackSubscribed(div, track));
  participant.on('trackUnsubscribed', trackUnsubscribed);
           });
  participant.tracks.forEach(publication => {
    if (publication.isSubscribed) {
      trackSubscribed(div, publication.track);
    }
  });
   participant.tracks.forEach(publication => {
    trackPublished(publication, div);
  });

  participant.on('trackPublished', publication => {
    trackPublished(publication, div);
  });

  participant.on('trackUnpublished', publication => {
    console.log(`RemoteParticipant ${participant.identity} unpublished a RemoteTrack: ${publication}`);
  }); 
shareScreen.disabled = false;
document.getElementById('teacher_div').appendChild(div);

    }
    /*Student connect*/
    if(participant.identity.indexOf(str2) != -1){
       console.log('student connected');
      var pname1=participant.identity;
      var name1 = pname1.replace('student_','');
    $("#studentname").text(name1 +" is trying to connect room");
    $("#username_info").text(name1);
       //var participant_accepted=getparticipantstatus(roomName,name1);
       console.log("participant_accepted");
      //if(participant_accepted==1){
        participantCount++;
        $('#studentcheckmodal').modal('hide');
       const div = document.createElement('div');
          div.id = participant.sid;
          div.setAttribute("style", "float: left;");
          div.classList.add("student_div_view");
        div.addEventListener('click', () => { zoomTrack(participant); });


 participant.tracks.forEach(function(track) {
participant.on('trackSubscribed', track => trackSubscribed(div, track));
  participant.on('trackUnsubscribed', trackUnsubscribed);
           });
  participant.tracks.forEach(publication => {
    if (publication.isSubscribed) {
      trackSubscribed(div, publication.track);
    }
  });
   participant.tracks.forEach(publication => {
    trackPublished(publication, div);
  });

  participant.on('trackPublished', publication => {
    trackPublished(publication, div);
  });

  participant.on('trackUnpublished', publication => {
    console.log(`RemoteParticipant ${participant.identity} unpublished a RemoteTrack: ${publication}`);
  }); 
          shareScreen.disabled = false;
          document.getElementById('student_div').appendChild(div);


          var tag = document.createElement("p");
          var pname=participant.identity;
          var name = pname.replace('student_','');
          let fname = name.split(" ")[0]; 
          console.log(name ); 
          var text = document.createTextNode(fname);
          tag.appendChild(text);
          var element = document.getElementById(participant.sid);
          element.prepend(tag);
          $("#student_list").append("<li class='list-a' id='remove_"+participant.sid+"'><i class='fa fa-microphone' aria-hidden='true' id='mute_"+participant.sid+"' style='display: none'></i><i class='fas fa-microphone-slash' aria-hidden='true' style='display: none' id='unmute_"+participant.sid+"'></i><span class='student_lists'><i class='fa  fa-video-camera' aria-hidden='true' id='stopvideo_"+participant.sid+"' style='display: none'></i> <i class='fas fa-video-slash' aria-hidden='true' style='display: none' id='startvideo_"+participant.sid+"' style='display: none'></i>"+name+"</span><i class='float-right far fa-trash-alt' aria-hidden='true' id='student_"+participant.sid+"'></i></li> ");
            
             var updateparticipant = '/student/twilio/participantrecord';
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:updateparticipant,
        type: 'POST',
        data:{participantidentity:name,studentid:studentid,roomsid:room.sid,participantsid:participant.sid,roomname:roomName},
        success: function(result){
            console.log("participant updated"+participant.identity);           
        }
    });
     // }   
    }
     if(participantCount==1){
      $('#participantCount').text(participantCount+" participant");
    }
    else{
      $('#participantCount').text(participantCount+" participants");
    }
   
}
function trackPublished(publication, div) {
    console.log(`Published LocalTrack: ${publication.track}`);
     var trackElement = publication.track.attach();
     div.appendChild(trackElement);
           
   var video = div.getElementsByTagName("video")[0];
  
   if (video) {
     video.setAttribute('class', 'webcamvideo1');
       video.setAttribute("style", "max-width:100%;max-height:100%;width:100%");
       video.setAttribute("id", "webcamvideo");
   }

}
function trackUnpublished(publication,div) {
    console.log(`trackUnpublished LocalTrack: ${publication.track}`);
     publication.track.detach().forEach(element => {
        if (element.classList.contains('participantZoomed')) {
            zoomTrack(element);
        }
        element.remove()
    });
}
function trackSubscribed(div, track) {
    div.appendChild(track.attach());
    console.log("trackSubscribed");

};

function trackUnsubscribed(track) {
   track.detach().forEach(element => {
        if (element.classList.contains('participantZoomed')) {
            zoomTrack(element);
        }
        element.remove()
    });
}
function participantDisconnected(participant) {

/*if(screenTrack){
room.localParticipant.unpublishTrack(screenTrack);
      screenTrack.stop();
      screenTrack = null;
}*/
 var removestyles="#remove_"+participant.sid;
$(removestyles).hide();
    console.log('Participant "%s" disconnected new', participant.identity);
    participant.tracks.forEach(trackUnsubscribed);
    document.getElementById(participant.sid).remove();
    --participantCount;
    if(participantCount==1){
      $('#participantCount').text(participantCount+" participant");
    }
    else{
      $('#participantCount').text(participantCount+" participants");
    }
    
}
/*"trackAdded" event is no longer emitted.1.x to 2.x*/
function trackAdded(div, track) {
   console.log(`Participant added ${track.kind} Track ${track.id}`);

     var trackElement = track.attach();
     div.appendChild(trackElement);
           
   var video = div.getElementsByTagName("video")[0];
  
   if (video) {
     video.setAttribute('class', 'webcamvideo1');
       video.setAttribute("style", "max-width:100%;max-height:100%;width:100%");
       video.setAttribute("id", "webcamvideo");
   }
}
/*"trackRemoved" event is no longer emitted.1.x to 2.x*/
function trackRemoved(track) {
  track.detach().forEach(element => {
        if (element.classList.contains('participantZoomed')) {
            zoomTrack(element);
        }
        element.remove()
    });
}
function removeParticipant(roomsid,participantidenty){
var removeparticipanturl = '/twilio/removeparticipant';
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:removeparticipanturl,
        type: 'POST',
        data:{particpantidentity:participantidenty,roomsid:roomsid},
        success: function(result){
            console.log("participant removed");            
        }
    });
}
function getparticipantstatus(roomname,participantidenty){
    var removeparticipanturl = '/twilio/getparticipantacceptance';
    $.ajax({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        url:removeparticipanturl,
        type: 'POST',
        data:{username:participantidenty,roomname:roomname},
        success: function(result){
          console.log("getparticipantstatus"+result);
            return result;            
        }
    });
}
function setLabelColor(label, color) {
    if (label !== null) {
        label.style.backgroundColor = color;
    }
}

function removeDominantSpeaker(){
    let speakerNameLabel;
    speakerNameLabel = document.getElementById(lastSpeakerSID);
    setLabelColor(speakerNameLabel, "#ebebeb"); // default color
}
function assignDominantSpeaker(participant){
    let domSpeakerNameLabel;
    lastSpeakerSID = participant.sid;
    domSpeakerNameLabel = document.getElementById(lastSpeakerSID); 
    setLabelColor(domSpeakerNameLabel, "#b5e7a0"); // green color
}
function handleSpeakerChange(participant){
    removeDominantSpeaker();
    if (participant !== null)
        assignDominantSpeaker(participant);
}
function zoomTrack(participant) {
console.log("participantzoomTrack-"+participant.sid);
 $('#'+participant.sid).toggleClass('participantZoomed');
$('#'+participant.sid).toggleClass('participantZoomedStudent');
 $('#student_div').toggleClass('participantZoommaindiv');
$("#enable_normal_view").hide();
$('#student_div').removeClass('gallery_view_enabled');
 $("#enable_gallery_view").show();
}
function zoomTrackTeacher(participant) {
console.log("zoomTrackTeacher-"+participant.sid);
 $('#'+participant.sid).toggleClass('participantZoomedTeacher');
 $('#student_div').toggleClass('participantZoommaindiv');
$("#enable_normal_view").hide();
$('#student_div').removeClass('gallery_view_enabled');
 $("#enable_gallery_view").show();
}
  });
}, function() {
alert("Unable to detect video source.Try Again!");
 window.close();
 });

 });