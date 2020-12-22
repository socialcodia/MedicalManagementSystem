<?php

///////////////////////////////////////////////////// CHANGED INFORMATION /////////////////////////////////////////////////////

//Database Connection
define('DB_NAME','azmiunanistore');   //your database username
define('DB_USER', 'root');          //your database name
define('DB_PASS', '');              //your database password
define('DB_HOST', 'localhost');     //your database host name

define('WEBSITE_DOMAIN', 'http://socialcodia.net/azmiunanistore/public/');
define('WEBSITE_EMAIL', 'socialcodia@gmail.com');                    //your email address
// define('WEBSITE_EMAIL_PASSWORD', 'PASSWORD');                        //your email password
define('WEBSITE_EMAIL_PASSWORD', 'PASSWORD');                        //your email password
define('WEBSITE_EMAIL_FROM', 'Social Codia');                        // your website name here
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', '587');
define('SMTP_SECURE', 'tls');



define('WEBSITE_NAME', 'Azmi Unani Store');                              //your website name here
define('WEBSITE_OWNER_NAME', 'Umair Farooqui');                      //your name, or anyones name, we will send this name with email verification mail.

define('DEFAULT_USER_IMAGE', 'uploads/api/user.png');

define('JWT_SECRET_KEY', 'SocialCodia');  							//your jwt secret key, Please use a very dificult secret key, which no one can guess it.
define('JWT_ADMIN_SECRET_KEY', 'SocialCodiaAdmin');  							//your jwt secret 


//Azmi unani store constant starting from her

define('EMAIL_NOT_VALID', 'Invalid Email Address');

define('USER_NOT_FOUND', "User Not Found");
define('LOGIN_SUCCESSFULL', "Login Successfull");
define('PASSWORD_WRONG', "Wrong Password");
define('UNAUTH_ACCESS', "Unauthorised Access");




define('CT', 'Content-Type');
define('AJ', 'application/json');
define('USERID', 'userId');
define('COMMENTS', 'comments');
define('USER', 'user');

define('USERS', 'users');
define('EMAIL', 'email');

define('FRIENDS', 'friends');
define('UPDATES', 'updates');
define('TOKEN', 'token');




define('FEED', 'feed');
define('FEEDS', 'feeds');
define('MESSAGE', 'message');
define('ERROR', 'error');

//////////////////////////// END WARNING DON'T CHANGE PLEASE /////////////////////////////

//For JWT 
define('JWT_TOKEN_ERROR', 402);
define('JWT_TOKEN_FINE', 403);
define('JWT_USER_NOT_FOUND', 404);


///////////////////////////////////////////////////// END DON'T TOUCH THIS /////////////////////////////////////////////////////


