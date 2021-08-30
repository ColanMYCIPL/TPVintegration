<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link rel="stylesheet" href="{{ asset('/css/twiliocss/style1.css') }}">
      <link rel="stylesheet" href="{{ asset('/css/twiliocss/bootstrap/bootstrap.min.css') }}">
      <link rel="stylesheet" href="{{ asset('/css/twiliocss/responsive.css') }}">
      <link rel="stylesheet" href="{{ asset('/css/twiliocss/jquery-ui.css') }}">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
            <link rel="stylesheet" href="{{ asset('/twiliofonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
      <link rel="icon" href="{{ asset('/public/homepage/images/sure-site-min.png') }}" width="12px" height="10px"/>
  <script src="{{ asset('/homepage/js/jquery.min.js') }}"></script>
  <script src="{{ asset('/homepage/js/popper.min.js') }}"></script>
  <script src="{{ asset('/homepage/js/bootstrap.min.js') }}"></script>
   <script type="text/javascript">
    var accessToken ={!! json_encode($accessToken) !!};
var roomName = {!! json_encode($roomName) !!};
var teachername = {!! json_encode($username) !!};
var syncaccessToken = {!! json_encode($syncaccessToken) !!};
var syncuserName = {!! json_encode($username) !!};
var className = {!! json_encode($classname) !!};
  </script>
  <script src="{{ asset('/js/twiliojs/twilio.js') }}"></script>
  <!-- Asap -->
  <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;500;600;700&family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
  <!-- owl slider -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css">
  <!--End owl slider -->
  <!-- twilio -->
  <link rel="stylesheet" href="{{ asset('/homepage/css/twilio.css') }}">
<style>
 .teacher_div_view video:nth-of-type(2){
  display: none!important;
 }
.homepage_third{margin-top:100px;}
.image video{
  max-width: 100%!important;
width: 500px!important;
}
.teacher_div_view{
  margin: center;float: left;margin: 10px;padding: 0px;margin: 0px;margin-top: 5px;
}
.foot2 h6{
  white-space: nowrap;
}
div#carousel-selector-0 {
  width: 100% !important;
  overflow-x: auto;
}
div#student_div {
  height: auto;
  overflow-x: auto;
  display: flex;
}
div#student_div .student_div_view {
  min-width: 115px;
  max-width: 115px;
  height: 130px;
  border: 1px solid #000;
  float: left;
  display: inline-block;
}
div#student_div video {
    height: 100px;
    object-fit: fill;
float: left;
}
.std_name
{
  text-align: center;
  color:#000;
  font-size: 14px;
  margin-bottom: 0;
border-top: 1px solid #444;
width: 100%;
float: left;
}
.student_div_view p{
    position: absolute;
    margin-top: 100px;
}
@media screen and (max-width:991px)
{
  .side-menu {  
    margin: auto;
    display: block;
    float: none;
}
.form-group.has-search.form-border input {
    width: 177px !important;
    font-size: 11px !important;
}

}
@media screen and (max-width:767px)
{
  .footer1 > div {
    width: 33% !important;
    min-width: 33%;
    text-align: center;
    float: left;
}
.footer1 { 
    flex-wrap: wrap;
}
}
@media screen and (max-width:576px)
{
  .user_info_profile .inner1 h4 { 
    font-size: 18px;
}
.inner2 {
    width: 66%; 
}
.inner1 {
    width: 33%; 
}
.in-row1 span {
    font-size: 11px !important;
}
}
.galleryviewstyle{
  float: right;
margin-right: 13px;
margin-top: 10px;
color: gray;
}


.gallery_view_enabled {
    flex-wrap: wrap;
    justify-content: center;
    align-content: center;
    height: 510px !important;
    overflow-x: hidden;
    overflow-y: auto !important;
    text-align: center;
    margin: auto;
    display: block !important;
}
.gallery_view_enabled .student_div_view {
    width: 170px; 
    max-width: 170px !important;
    height: 170px !important;
    margin: 4px;
float: none !important;
}
.gallery_view_enabled .student_div_view p {
    display: none;
    margin-top: 0;
}
.gallery_view_enabled .student_div_view video {
    height: 100% !important;
}
.participantHidden {
    display: none;
}
.student_div_view{
background-color:#ebebeb;
margin-bottom: 3px;
}
.student_div_view p{
margin-bottom: 2px;
margin-left: 2px;
}
.participantZoomed {
    height: 600px !important;
    min-width: 100% !important;
    max-width: 100% !important;
}
.participantZoomed p{
   display: none;
}

.participantZoomed video {
    height: 100% !important;
    object-fit: fill !important;
}
.participantZoommaindiv .student_div_view.participantZoomed {
    display: block !important;
}
.participantZoommaindiv .student_div_view {
    display: none !important;
}
.student_div_view video:nth-of-type(2) {
    position: absolute;
    height: 100px !important;
    object-fit: fill !important;
    float: left !important;
    left: 0%;
    width: 115px;
}
.participantZoomedStudent video:nth-of-type(2) {
    width: 100% !important;
    height: 100% !important;
    z-index: unset;
    position: absolute;
    object-fit: fill;
}
.tips {
    position: fixed;
    left: 0;
    top: 0;
}
#white_board_popup_new{
display:none;
}
@media only screen and (min-width:1201px) {
.image video {
    height: 315px;
    object-fit: cover;
} 
}


.teacher_div_view {
    width: 100%;
}

</style>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://sdk.twilio.com/js/video/releases/2.15.2/twilio-video.min.js"></script>
<!--   <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script> -->

  <script src="{{ asset('/js/twiliojs/twiliowhiteboard.js') }}"></script>
   </head>
   <body>
<!-- Modal -->

 <div class="modal fade" id="studentcheckmodal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-body">
          <p id="studentname"></p>
          <p id="username_info" style="display: none;"></p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="admitstudent">Admit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cancelstudent">Cancel</button>
      </div>
      </div>
      
    </div>
  </div>
  <!-- Modal -->
      <section class="logo">
         <div class="container">
            <a href="#"><img src="{{ asset('/images/twilioImages/logo.png') }}" alt=""></a>
         </div>
      </section>
      <!--------------------------------------------------------------------------------->
      <section class="two-sec">
         <div class="container">
            <div class="row">
               <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12">
                  <div class="side-menu">
                     <div class="box">
                        <div class="container">
                           <div class="row header">
                              <div class="head1">
                                 <h5>{{ $username }}</h5>
                              </div>
                              <div class="ml-auto">
                                 <a class="custom_video">
                                  <i class="fa fa-2x fa-microphone right custom_muteaudio_teacher" aria-hidden="true" id="muteAudio" ></i>
                                  <i class="fas fa-2x fa-microphone-slash right custom_unmuteaudio_teacher" aria-hidden="true" style="display: none" id="unmuteAudio" ></i>
                                </a>
                                 <a class="custom_video">
                                <i class="fa fa-2x fa-video-camera custom_stopvideo_teacher" aria-hidden="true" id="stopVideo"></i>
                                <i class="fas fa-2x fa-video-slash custom_startvideo_teacher" aria-hidden="true" style="display: none" id="startVideo"></i>
                                </a>
                              </div>
                           </div>
                        </div>
                       <!--  <div class="image">
                           <img src="{{ asset('/twilioImages/teacher.jpeg') }}" alt="" width= "399px";height="200px">
                        </div> -->
                        <div class="image" id="teacher_div">
                                      <!--   <img src="{{ asset('/homepage/images/twilio/teacher.jpeg') }}"alt="" width= "399px";height="200px"> -->
                         
                                 </div>
                        <div class="footer">
                           <div class="foot1">
                              <a href="#"><i class="fa fa-2x fa-users" aria-hidden="true"></i></a>
                              <h6><span id="participantCount"></span></h6>
                           </div>
                           <div class="foot1"  id="my-button_hidden">
                              <i class="fa fa-2x fa-comments" aria-hidden="true"><sup class="sup-col">3</sup></i>
                              <h6 >chat</h6>
                           </div>
                           <div class="foot1" id="toggleWhiteBoard" style="cursor:pointer;">
                             <i class="white float-right fa  fa-2x fa-pencil-square-o" aria-hidden="true" style="cursor:pointer;"></i>
                              <h6  >White board</h6>
                           </div>
                        </div>
                     </div>
                     <div class="user_info_profile">
                        <div class="inner pt-2">
                           <div class="inner1">
                              <h4>{{ $classname }}</h4>
                           </div>
                           <div class="inner2">
                              <div class="in-row1">
                                <div id="muteall" style="cursor:pointer;margin-right: 15px;display: none;"><i class="fa fa-microphone-slash" aria-hidden="true" style="margin-right:5px;"></i><span style="font-size:12px;">MUTE ALL</span></div>
                                <div id="unmuteall" style="cursor:pointer;margin-right: 15px;display: none;"><i class="fa fa-microphone-slash" aria-hidden="true" style="margin-right:5px;"></i><span style="font-size:12px;">UNMUTE ALL</span></div>
                              </div>
                              <div class="in-row2"> 
                                 <span class="form-group has-search form-border">
                                 <span class="fa fa-search form-control-feedback"></span>
                                 <input type="text" class="form-control" placeholder="Search students">
                                 </span>
                              </div>
                           </div>
                        </div>
                        <div class="user_info d-flex">
                           <div class="col-12 p-0">
                              <div class="list">
                                 <ul id="student_list">
                                                                       
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-lg-7 col-md-12 col-sm-12 col-xs-12 hello">
                  <div class="box1">
                     <div class="bx1">
                        <div class="toggle_dasboard" id="main_content_twilio">
                        <p id="enable_gallery_view" class="galleryviewstyle"><i class="fas fa-2x fa-th"></i></p>
                        <p id="enable_normal_view" style="display: none" class="galleryviewstyle"><i class="far fa-2x fa-square"></i></p>  
                                  <!--white board popup-->
                                      <div id="white_board_popup_new">
                                       <div class="header_toolbar">
                                           <div class="float-right">
                                               <span id="white_close" class="tool"><img src="{{ asset('/images/twilioImages/cancel.png') }}" alt=""></span>
                                              
                                           </div> 
                                       </div>
                                       <div class="content_toolbar">
                                             <canvas class="whiteboard" style="width: 591px;height: 508px;"></canvas>
                                          <div class="buttons">
                                          <button id="color-btn" class="btn">Change Color</button>
                                          <button id="clear-btn" class="btn">Clear</button>
                                          </div>
                                       </div>
                                    </div>
                                  <!--End white board popup-->
                                 <div class="carousel-container position-relative" id="normal_view">
                                    <!-- Carousel Navigation -->
                                    <div id="carousel-thumbs" class="carousel slide" data-ride="carousel">
                                       <div class="carousel-inner">
                                          <div class="carousel-item active">
                                             <div id="carousel-selector-0">
                                              <div id="student_div" class="galleryview">       
                                                </div>                                               
                                             </div>
                                          </div>
                                          
                                       </div>
                                        
                                      
                                    </div>
                                 </div>
                                 <!-- /row --> 
                          
                        </div>
                     </div>
                  </div>
                  <div class="footer1" >
                     <div class="foot2">
                        <i class="fa fa-3x fa-microphone right custom_muteaudio_teacher" aria-hidden="true" id="muteAudio" ></i>
                        <h6 class="custom_muteaudio_teacher">MUTE AUDIO</h6>
                        <i class="fas fa-3x fa-microphone-slash right custom_unmuteaudio_teacher" aria-hidden="true" style="display: none" id="unmuteAudio" ></i>
                        <h6 class="custom_unmuteaudio_teacher" style="display: none">UNMUTE AUDIO</h6>
                     </div>
                     <div class="foot2">
                        <i class="fa fa-3x fa-video-camera custom_stopvideo_teacher" aria-hidden="true" id="stopVideo"></i>
                        <h6 class="custom_stopvideo_teacher">STOP VIDEO</h6>
                        <i class="fas fa-3x fa-video-slash custom_startvideo_teacher" aria-hidden="true" style="display: none" id="startVideo"></i>
                        <h6 class="custom_startvideo_teacher" style="display: none">START VIDEO</h6>
                     </div>
                     <div class="foot2">
                        <i class="fa fa-3x fa-share-square-o" aria-hidden="true" id="share_screen"></i>
                        <h6>SHARE SCREEN</h6>
                     </div>
                     <div class="foot2">
                        <i class="fa fa-stop-circle-o fa-3x custom_stoprecord_teacher" aria-hidden="true" id="stopRecord" style="color: red"></i>
                        <h6 class="custom_stoprecord_teacher">RECORDING...</h6>
                        <i class="fas fa-pause-circle fa-3x custom_startrecord_teacher" aria-hidden="true" style="display: none" id="startRecord"></i>
                        <h6 class="custom_startrecord_teacher" style="display: none">START RECORD</h6>
                     </div>
                     <div id="endClass">
                     <button type="button" class="btn btn btn-outline-danger but-1" >End class</button>
                   </div>
                  </div>
               </div>


               <!--chat window popup-->
               <div id="window" >
                   <div class="cusotm_chat_option">
                       <h6>Chat</h6>
                       <div class="chat_descp">
                           <ul class="p-0">
                               <li><span class="mine">Me to</span> <span class="towhom">EveryOne</span><p>Hi EveryOne</p> </li>
                               <li><span class="mine">Me to</span> <span class="towhom">EveryOne</span><p>  I will answer your question at the end of class</p> </li>
                           </ul> 
                       </div>
                       <div class="input_chat_Window">
                           <div class="flex_groupform">
                               <div class="form-group">
                                   <label for="">To</label>
                                   <select name="" id="">
                                       <option value="">Host Only</option>
                                       <option value="">Student 1</option>
                                       <option value="">Student 2</option>
                                       <option value="">Student 3</option>
                                       <option value="">Student 4</option>
                                       <option value="">Student 5</option>
                                       <option value="">Student 6</option>
                                   </select> 
                               </div>
                               <div class="form-group"> 
                                <select name="" id="">
                                    <option value="">More</option> 
                                </select> 
                            </div>
                           </div>
                           <div class="chat_box">
                               <textarea name="" placeholder="Type Chat message here" id=""  ></textarea>
                           </div>
                       </div>
                   </div>
               </div>
               <!--End chat window popup-->


               
            </div>
         </div>
      </section>
      <script src="{{ asset('/js/twiliojs/jquery-3.5.1.min.js') }}"></script>
      <script src="{{ asset('/js/twiliojs/jquery.js') }}"></script>
      <script src="{{ asset('/js/twiliojs/bootstrap.min.js') }}"></script>
      <script src="{{ asset('/js/twiliojs/jquery-ui.js.js') }}"></script>
      <script type="text/javascript" src="{{ asset('/js/twiliojs/jquery.dialogextend.js') }}"></script>
      <script type="text/javascript" src="{{ asset('/js/twiliojs/jquery.dialogextend.min.js') }}"></script>
      <!--- mizimize and maximize dialog-->
      <script>
        $( document ).ready(function() {
     window.setInterval(function(){
                twilioCheckStudents();
            }, 1000);
      function twilioCheckStudents(){
      var participanturl = '/teacher/twilio/checkstudents';
      $.ajax({
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url:participanturl,
          type: 'POST',
          data:{teachername:teachername,roomname:roomName},
          success: function(result){
            if(result!=0){
            $("#studentname").text(result +" is trying to connect room");
            $("#username_info").text(result);
            $('#studentcheckmodal').modal('show');

            }
              //return result;            
          }
      });
      }

});
         $(function(){
          $(document).on("click", "#admitstudent", function(){ 
           $('#studentcheckmodal').modal('hide'); 
             var URLroom1 = '/teacher/twilio/admitstudent';
             var userName=$('#username_info').text();
                    $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:URLroom1,
                    type: 'POST',
                    data:{roomname:roomName,username:userName},
                    success: function(response) {
                      console.log("details saved Successfully"+response);
                    }
                    });
          });
          $(document).on("click", "#cancelstudent", function(){ 
           $('#studentcheckmodal').modal('hide'); 
            var userName=$('#username_info').text();
               var URLroom2 = '/teacher/twilio/cancelstudent';
                    $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:URLroom2,
                    type: 'POST',
                    data:{roomname:roomName,username:userName},
                    success: function(response) {
                     
                      console.log("details saved Successfully"+response);
                    }
                    });
          });

         $("#my-button").click(function(){
         $("#window")
         .dialog({
         "title" : "Title",
         "buttons" : { "OK" : function(){ $(this).dialog("close"); } }
         })
         .dialogExtend({
         "closable" : true, // enable/disable close button
         "maximizable" : true, // enable/disable maximize button
         "minimizable" : true, // enable/disable minimize button
         "collapsable" : true, // enable/disable collapse button
         "dblclick" : "collapse", // set action on double click. false, 'maximize', 'minimize', 'collapse'
         "titlebar" : "transparent", // false, 'none', 'transparent'
         "minimizeLocation" : "right", // sets alignment of minimized dialogues
         "icons" : { // jQuery UI icon class
         "close" : "ui-icon-circle-close",
         "maximize" : "ui-icon-circle-plus",
         "minimize" : "ui-icon-circle-minus",
         "collapse" : "ui-icon-triangle-1-s",
         "restore" : "ui-icon-bullet"
         },
         
            });
         });
         });
      </script>
      <!---End  mizimize and maximize dialog-->
      <!--Slider-->
      <script>
         $('#myCarousel').carousel({
         interval: false
         });
         $('#carousel-thumbs').carousel({
         interval: false
         });
         
         $('[id^=carousel-selector-]').click(function() {
         var id_selector = $(this).attr('id');
         var id = parseInt( id_selector.substr(id_selector.lastIndexOf('-') + 1) );
         $('#myCarousel').carousel(id);
         });
         // Only display 3 items in nav on mobile.
         if ($(window).width() < 575) {
         $('#carousel-thumbs .row div:nth-child(4)').each(function() {
         var rowBoundary = $(this);
         $('<div class="row mx-0">').insertAfter(rowBoundary.parent()).append(rowBoundary.nextAll().addBack());
         });
         $('#carousel-thumbs .carousel-item .row:nth-child(even)').each(function() {
         var boundary = $(this);
         $('<div class="carousel-item">').insertAfter(boundary.parent()).append(boundary.nextAll().addBack());
         });
         }
         // Hide slide arrows if too few items.
         if ($('#carousel-thumbs .carousel-item').length < 2) {
         $('#carousel-thumbs [class^=carousel-control-]').remove();
         $('.machine-carousel-container #carousel-thumbs').css('padding','0 5px');
         }
         // when the carousel slides, auto update
         $('#myCarousel').on('slide.bs.carousel', function(e) {
         var id = parseInt( $(e.relatedTarget).attr('data-slide-number') );
         $('[id^=carousel-selector-]').removeClass('selected');
         $('[id=carousel-selector-'+id+']').addClass('selected');
         });
         // when user swipes, go next or previous
         $('#myCarousel').swipe({
         fallbackToMouseEvents: true,
         swipeLeft: function(e) {
         $('#myCarousel').carousel('next');
         },
         swipeRight: function(e) {
         $('#myCarousel').carousel('prev');
         },
         allowPageScroll: 'vertical',
         preventDefaultEvents: false,
         threshold: 75
         });
         /*
         $(document).on('click', '[data-toggle="lightbox"]', function(event) {
         event.preventDefault();
         $(this).ekkoLightbox();
         });
         */
         
         $('#myCarousel .carousel-item img').on('click', function(e) {
         var src = $(e.target).attr('data-remote');
         if (src) $(this).ekkoLightbox();
         });
      </script>
      <!--End Slider-->


      <!--whiteboardtoggle-->
      <script>
         $('#toggleWhiteBoard').click(function(){
console.log("click");
              $('#white_board_popup_new').show();
              $('#normal_view').hide();
              $('#enable_normal_view').hide();
              $('#enable_gallery_view').hide();
          })
          $('#white_close').click(function(){
              $('#white_board_popup_new').hide();
              $('#normal_view').show();
              $('#enable_normal_view').hide();
              $('#enable_gallery_view').show();
          })
      </script>
      <script type="text/javascript" src="//media.twiliocdn.com/sdk/js/sync/v1.0/twilio-sync.min.js"></script>
   
   </body>
</html>