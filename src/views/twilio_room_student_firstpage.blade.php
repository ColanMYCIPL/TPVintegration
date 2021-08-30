<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Document</title>
      <link rel="stylesheet" href="{{ asset('/css/twiliocss/bootstrap/bootstrap.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('/css/twiliocss/jquery-ui.css') }}">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
            <link rel="stylesheet" href="{{ asset('/twiliofonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
      <link rel="icon" href="{{ asset('/public/homepage/images/sure-site-min.png') }}" width="12px" height="10px"/>
  <script src="{{ asset('/homepage/js/jquery.min.js') }}"></script>
  <!-- Asap -->
  <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;500;600;700&family=Nunito:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
   <script type="text/javascript">
    <?php if(isset($username)) {?>
    var username ={!! json_encode($username) !!};
    <?php } ?>
    <?php if(isset($roomName)) {?>
var roomName = {!! json_encode($roomName) !!};
<?php } ?>
<?php if(isset($accessToken)) {?>
var accessToken ={!! json_encode($accessToken) !!};
<?php } ?>
<?php if(isset($studentid)) {?>
var studentid ={!! json_encode($studentid) !!};
<?php } ?>

  </script>
  <script src="{{ asset('/js/twiliojs/twilio.js') }}"></script>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://sdk.twilio.com/js/video/releases/2.15.2/twilio-video.min.js"></script>
<!-- <script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script> -->

<style>
.center {
   position: absolute;
width: 200px;
height: 500px;
top: 50%;
left: 50%;
margin-left: -187px;
margin-top: -25px;
color: white;
text-transform: uppercase;
white-space: nowrap;
width: 100px;
height: 50px;
font-size: 20px;
font-weight: 600;
 
}​

</style>
<script type="text/javascript">
    /*check status*/
          window.setInterval(function(){
                getstudentstatus(roomName ,username);
            }, 5000);
  /*check status*/
  function getstudentstatus(roomName,username){
    var URLroom1 = '/student/twilio/checkstudentstatus';
              //var roomname=$('#roomname').text();
                //var username=$('#username').text();
                    $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url:URLroom1,
                    type: 'POST',
                    data:{roomname:roomName,username:username,studentid:studentid},
                    success: function(response) {
                      console.log("details saved Successfully"+response);
                      if(response==1){
                        window.location = "/student/join/twilioroom/"+roomName+"/"+username;
                      }
                    }
                    });
  }
</script>
</head>
<body style=" background-color: black;">
<div class='fullscreenDiv'>
    <div class="center">Please wait for the host to admit you</div>
</div>​
</body>
</html>
