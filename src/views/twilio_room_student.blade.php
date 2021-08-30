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
  <!-- Asap -->
     <script type="text/javascript">
    var accessToken ={!! json_encode($accessToken) !!};
var roomName = {!! json_encode($roomName) !!};
var syncaccessToken = {!! json_encode($syncaccessToken) !!};
var studentname = {!! json_encode($username) !!};
var syncuserName = {!! json_encode($username) !!};
<?php if(isset($studentid)) {?>
var studentid ={!! json_encode($studentid) !!};
<?php } ?>
  </script>
  <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;500;600;700&family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
  <!-- twilio -->
  <link rel="stylesheet" href="{{ asset('/homepage/css/twilio.css') }}">
<style>
  .student_div_view video:nth-of-type(2){
  display: none!important;
 }
.homepage_third{margin-top:100px;}
.image video{
  height: 500px;
  width: 400px;
}
.teacher_screen{
  width: 100%;
}
/*.teacher_div_view video:last-child{
  max-width: 100%;max-height: 100%;width: 100px;height: 100px;position: absolute;
}*/
.student_div video:last-child{
  width: 100%
}
.foot2 h6{
  white-space: nowrap;
}
.teacher_div_view video {
    height: 662px !important;
    object-fit: fill;
}
/*.student_div_view p{
    position: absolute;
    color: red;
    background-color: white;
}*/
.teacher_div_view video:nth-of-type(1) {
    width: 100px !important;
    height: 100px !important;
    position: absolute;
    bottom: 0;
    z-index: 9999;
    right: 0;
}
.teacher_div_view video:nth-of-type(2) {
    width: 100%;
}
.participantZoomedTeacher video:nth-of-type(1) {
    width: 100% !important;
    height: 100% !important;
    z-index: unset;
    position: absolute;
}
.participantZoomedTeacher video:nth-of-type(2) {
    width: 100px !important;
    height: 100px !important;
    position: absolute;
    bottom: 0;
    right: 0;
}
.student_div_view{
background-color:#ebebeb;
margin-bottom: 3px;
}
.student_div_view p{
margin-bottom: 2px;
margin-left: 2px;
}
.student_screen.student_screen{
  display: none;
}
/*responsive screen*/
.student_chart_back {
    display: none;
}
@media only screen and (min-width:768px) and (max-width:991px) {
.student_img img {
    width: 58.5%;
    object-fit: cover;
}
.student_img {
    min-height: 930px;
    max-height: 930px;
}
}
@media only screen and (max-width:767px) {
.student_img img {
    width: 100%;
    object-fit: cover;
}
.student_div_view {
    width: 100%;
}
.student_img {
    min-height: 930px;
    max-height: 930px;
}
}
@media only screen and (max-width:991px) {
.student_img {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
}
section.logo a {
    width: 100%;
    display: block;
    text-align: center;
}
}
@media only screen and (min-width:992px) {
.student_img {
    max-height: 62.4%;
}
}
@media only screen and (max-width:767px) {
.footer1 {
    flex-wrap: wrap;
  display: flex;
    align-items: flex-start;
}
}
/*responsive screen*/
</style>

  <script src="{{ asset('/js/twiliojs/twilio.js') }}"></script>
   <script data-main="scripts/app" src="{{ asset('/js/twiliojs/require.js') }}"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://media.twiliocdn.com/sdk/js/sync/releases/0.12.4/twilio-sync.min.js"></script>
<script src="https://sdk.twilio.com/js/video/releases/2.15.2/twilio-video.min.js"></script>
   
<!-- <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script> -->

   </head>
   <body>
      <section class="logo">
         <div class="container">
            <a href="#"><img src="{{ asset('/images/twilioImages/logo.png') }}" alt=""></a>
         </div>
      </section>
      <!--------------------------------------------------------------------------------->
      <section class="two-sec">
         <div class="container">
            <div class="row">
               <div class="col-lg-2 col-md-12 col-sm-12 col-xs-12 pr-0">
                  <div class="student_img" >
                    <div id="student_div"> 
                     
                   </div>
                     <img src="{{ asset('/images/twilioImages/student_tw2.jpg') }}">
                     <img src="{{ asset('/images/twilioImages/student_tw3.jpg') }}">
                     <img src="{{ asset('/images/twilioImages/studnet_tw4.jpg') }}">
                     <img src="{{ asset('/images/twilioImages/student_tw5.jpg') }}">
                     <img src="{{ asset('/images/twilioImages/student_tw6.jpg') }}">
                     <img src="{{ asset('/images/twilioImages/teacher.jpeg') }}">
                     <img src="{{ asset('/images/twilioImages/teacher.jpeg') }}">
                     <img src="{{ asset('/images/twilioImages/teacher.jpeg') }}">
                     <img src="{{ asset('/images/twilioImages/teacher.jpeg') }}">
                  </div>
               </div>
               <div class="col-lg-10 col-md-12 col-sm-12 col-xs-12 hello">
                  <div class="box1">
                     <div class="bx1">
                        <div class="toggle_dasboard" id="teacher_div"> 
                                 <!--white board popup-->
                                    <div id="white_board_popup_new">
                                       <div class="content_toolbar">
                                             <canvas class="whiteboard" style="width: 591px;height: 508px;"></canvas>
                                       </div>
                                    </div>
                                  <!--End white board popup-->
                            
                                 <!-- /row --> 
                          
                        </div>
                     </div>
                  </div>
                  <div class="footer1">
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
                     <div id="leaveClass">
                     <button type="button" class="btn btn btn-outline-danger but-1" >Leave class</button>
                   </div>
                  </div>
               </div>
               <div class="col-lg-3 col-md-12 col-sm-12 col-xs-12 student_chart_back">
                     <div class="cusotm_chat_option ">
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
        $('#stopRecord').click(false);
         $(function(){
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
              $('#white_board_popup').show()
          })
          $('#white_close').click(function(){
              $('#white_board_popup').hide()
          })
      </script>
    
   </body>
</html>
      
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
              $('#white_board_popup').show()
          })
          $('#white_close').click(function(){
              $('#white_board_popup').hide()
          })
      </script>
   </body>
</html>