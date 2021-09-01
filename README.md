TPV - Twilio Programmable Video
==

[![GitHub issues](https://img.shields.io/github/issues/ColanMYCIPL/TPVintegration)](https://github.com/ColanMYCIPL/TPVintegration)
[![GitHub Forks](https://img.shields.io/github/forks/ColanMYCIPL/TPVintegration)](https://packagist.org/packages/nesbot/carbon)
[![GitHub stars](https://img.shields.io/github/stars/ColanMYCIPL/TPVintegration)](https://github.com/ColanMYCIPL/TPVintegration)
[![GitHub license](https://img.shields.io/github/license/ColanMYCIPL/TPVintegration)](https://github.com/ColanMYCIPL/TPVintegration)

# Integrate Twilio Programmable video with added features in laravel 5.8

## Installing via Composer

The recommended way is to install the php-cron-scheduler is through [Composer](https://getcomposer.org/).
Please refer to [Getting Started](https://getcomposer.org/doc/00-intro.md) on how to download and install Composer.

After you have downloaded/installed Composer, run in your project

`composer require colanmycipl/tpvintegration`


- `other installations` - after adding the package need to run laravel commands. 


- `php artisan vendor:publish`
- `php artisan migrate`

Add following line in config/app.php

ColanMYCIPL\TPVintegration\TPVintegrationServiceProvider::class,

*Following credentials are need to be add in  **.env** file of root path*

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=
AWS_IAM_USER_KEY_ID=
AWS_IAM_USER_SECRET_ACCESS_KEY=


TWILIO_ACCOUNT_SID=
TWILIO_AUTH_TOKEN=
TWILIO_API_KEY=
TWILIO_API_SECRET=
TWILIO_SYNC_SERVICE_SID=
TWILIO_FROM_NUMBER=



### How it works

There are api's you can use it for 

- `Create Room`
- `Join Room`
- `Create Composition for indivdual participants and group room`
- `Update composition status`
- `Preview Recording`
- `Download recording of room/participant in zip file`
- `Moving recording to s3`

### Join Room

Required parameters for Teacher(GET method)
`/teacher/join/twilioroom/{id}/{username}/{classname}`
1)Roomname
2)Username
3)Classname

Required parameters for student(GET method)
`/teacher/join/twilioroom/{id}/{username}/{studentid}`
1)Roomname
2)Username
3)Studentid



### Scheduling jobs
**Sample file** will be available in app/Jobs/twilioCompositionStatusUpdate
Need to change as per your requirement.
***Separate api's available for updating and creation composition.***


  
