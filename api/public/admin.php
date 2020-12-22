<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//use Slim\Factory\AppFactory;

require '../vendor/autoload.php';
require_once '../include/AdminDbHandler.php';
require_once '../vendor/autoload.php';
require_once '../include/JWT.php';

$JWT = new JWT;

$app = new \Slim\App;
$app = new Slim\App([

    'settings' => [
        'displayErrorDetails' => true,
        'debug'               => true,
    ]
]);


$app->post('admin/login', function(Request $request, Response $response)
{
    if(!checkEmptyParameter(array('email','password'),$request,$response))
    {
        $db = new AdminDbHandler;
        $requestParameter = $request->getParsedBody();
        $email = $requestParameter['email'];
        $password = $requestParameter['password'];
        if (!$db->isEmailValid($email)) 
        {
            $email = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($email))))));
            $email = str_replace(' ', '', $email);
            $email = $db->getEmailByUsername($email);
        }
        if (!empty($email)) 
        {
            $result = $db->login($email,$password);
            if($result ==LOGIN_SUCCESSFULL)
            {
                $user = $db->getUserByEmail($email);
                $user['token'] =getToken($user['id']);
                $responseUserDetails = array();
                $responseUserDetails['error'] = false;
                $responseUserDetails['message'] = "Login Successfull";
                $responseUserDetails['user'] = $user;
                $response->write(json_encode($responseUserDetails));
                return $response->withHeader('Content-type', 'application/json')
                         ->withStatus(200);
            }
            else if($result ==USER_NOT_FOUND)
            {
                return returnException(true,"Email Is Not Registered",$response);
            }
            else if($result ==PASSWORD_WRONG)
            {
                return returnException(true,"Wrong Password",$response);
            }
            else if($result ==UNVERIFIED_EMAIL)
            {
                return returnException(true,"Email Is Not Verified",$response);
            }
            else
            {
                return returnException(true,"Something Went Wrong",$response);
            }
        }
        else
        {
            return returnException(true,"Email or Username is Wrong",$response);
        }
    }
});

$app->get('admin/feeds', function(Request $request, Response $response)
{
    $db = new DbHandler;
    if (validateAdminToken($db,$request,$response)) 
    {
        $feeds = $db->getFeeds();
        if (!empty($feeds)) 
        {
            $responseFeedDetails = array();
            $responseFeedDetails['error'] = false;
            $responseFeedDetails['message'] = "Feed List Found";
            $responseFeedDetails['feeds'] = $feeds;
            $response->write(json_encode($responseFeedDetails));
            return $response->withHeader('Content-Type','application/json')
                            ->withStatus(200);
        }
        else
        {
            return returnException(true,"Feeds Not Found",$response);
        }
    }
});

$app->get('admin/users', function(Request $request, Response $response)
{
    $db = new AdminDbHandler;
    if (validateAdminToken($db,$request,$response)) 
    {
            $id = $db->getUserId();
            $users = $db->getUsers($id);
            if (!empty($users)) 
            {
                $responseUserDetails = array();
                $responseUserDetails['error'] = false;
                $responseUserDetails['message'] = "Users List Found";
                $responseUserDetails['users'] = $users;
                $response->write(json_encode($responseUserDetails));
                return $response->withHeader('Content-type', 'application/json')
                         ->withStatus(200);
            }
            else
            {
                return returnException(true,"No User Found",$response);
            }
    }
});

$app->get('admin/feeds/count', function(Request $request, Response $response, array $args)
{
    $db = new AdminDbHandler;
    if(validateAdminToken($db,$request,$response))
    {
        $tokenId = $db->getUserId();
        if ($db->checkUserById($tokenId)) 
        {
            $feedsCount = $db->getFeedsCount();
            $result = array();
            $result['error'] = false;
            $result['message'] = "Notifications Count Found";
            $result['feedsCount'] = $feedsCount;
            $response->write(json_encode($result));
            return $response->withHeader('Content-Type','application/json')
                            ->withStatus(200);
        }
        else
        {
            return returnException(true,"Username Not Exist",$response);
        }
    }
});

$app->get('admin/flags/count', function(Request $request, Response $response, array $args)
{
    $db = new AdminDbHandler;
    if(validateAdminToken($db,$request,$response))
    {
        $tokenId = $db->getUserId();
        if ($db->checkUserById($tokenId)) 
        {
            $feedsCount = $db->getFlagsCount();
            $result = array();
            $result['error'] = false;
            $result['message'] = "Flags Count Found";
            $result['flagsCount'] = $feedsCount;
            $response->write(json_encode($result));
            return $response->withHeader('Content-Type','application/json')
                            ->withStatus(200);
        }
        else
        {
            return returnException(true,"Username Not Exist",$response);
        }
    }
});

$app->get('admin/contacts/count', function(Request $request, Response $response, array $args)
{
    $db = new AdminDbHandler;
    if(validateAdminToken($db,$request,$response))
    {
        $tokenId = $db->getUserId();
        if ($db->checkUserById($tokenId)) 
        {
            $contactsCount = $db->getContactsCount();
            $result = array();
            $result['error'] = false;
            $result['message'] = "Contacts Count Found";
            $result['contactsCount'] = $contactsCount;
            $response->write(json_encode($result));
            return $response->withHeader('Content-Type','application/json')
                            ->withStatus(200);
        }
        else
        {
            return returnException(true,"Username Not Exist",$response);
        }
    }
});

$app->get('admin/feedbacks/count', function(Request $request, Response $response, array $args)
{
    $db = new AdminDbHandler;
    if(validateAdminToken($db,$request,$response))
    {
        $tokenId = $db->getUserId();
        if ($db->checkUserById($tokenId)) 
        {
            $feedbacksCount = $db->getFeedbacksCount();
            $result = array();
            $result['error'] = false;
            $result['message'] = "Feedback Count Found";
            $result['feedbacksCount'] = $feedbacksCount;
            $response->write(json_encode($result));
            return $response->withHeader('Content-Type','application/json')
                            ->withStatus(200);
        }
        else
        {
            return returnException(true,"Username Not Exist",$response);
        }
    }
});

$app->get('admin/requests/count', function(Request $request, Response $response, array $args)
{
    $db = new AdminDbHandler;
    if(validateAdminToken($db,$request,$response))
    {
        $tokenId = $db->getUserId();
        if ($db->checkUserById($tokenId)) 
        {
            $requestsCount = $db->getRequestsCount();
            $result = array();
            $result['error'] = false;
            $result['message'] = "Request Count Found";
            $result['requestsCount'] = $requestsCount;
            $response->write(json_encode($result));
            return $response->withHeader('Content-Type','application/json')
                            ->withStatus(200);
        }
        else
        {
            return returnException(true,"Username Not Exist",$response);
        }
    }
});

$app->get('admin/users/count', function(Request $request, Response $response, array $args)
{
    $db = new AdminDbHandler;
    if(validateAdminToken($db,$request,$response))
    {
        $tokenId = $db->getUserId();
        if ($db->checkUserById($tokenId)) 
        {
            $usersCount = $db->getUsersCount();
            $result = array();
            $result['error'] = false;
            $result['message'] = "Users Count Found";
            $result['usersCount'] = $usersCount;
            $response->write(json_encode($result));
            return $response->withHeader('Content-Type','application/json')
                            ->withStatus(200);
        }
        else
        {
            return returnException(true,"Username Not Exist",$response);
        }
    }
});

$app->get('admin/user', function(Request $request, Response $response, array $args)
{
    $db = new AdminDbHandler;
    if(validateAdminToken($db,$request,$response))
    {
        $tokenId = $db->getUserId();
        if ($db->checkUserById($tokenId)) 
        {
            $user = $db->getUserById($tokenId);
            $responseUserDetails = array();
            $responseUserDetails['error'] = false;
            $responseUserDetails['message'] = "User Found";
            $responseUserDetails['user'] = $user;
            $response->write(json_encode($responseUserDetails));
            return $response->withHeader('Content-Type','application/json')
                            ->withStatus(200);
        }
        else
        {
            return returnException(true,"Username Not Exist",$response);
        }
    }
});


function encrypt($data)
{
    $email = openssl_encrypt($data,"AES-128-ECB",null);
    $email = str_replace('/','socialcodia',$email);
    $email = str_replace('+','mufazmi',$email);
    return $email; 
}

function decrypt($data)
{
    $mufazmi = str_replace('mufazmi','+',$data);
    $email = str_replace('socialcodia','/',$mufazmi);
    $email = openssl_decrypt($email,"AES-128-ECB",null);
    return $email; 
}

function returnException($error,$message,$response)
{
    $errorDetails = array();
    $errorDetails['error'] = $error;
    $errorDetails['message'] = $message;
    $response->write(json_encode($errorDetails));
    return $response->withHeader('Content-Type','application/json')
                    ->withStatus(200);
}

function getToken($userId)
{
    $key = JWT_SECRET_KEY;
    $payload = array(
        "iss" => "http://cpanel.famblah.cf",
        "iat" => time(),
        "user_id" => $userId
    );
    $token =JWT::encode($payload,$key);
    return $token;
}

function validateAdminToken($db,$request,$response)
{
    $error = false;
    $header =$request->getHeaders();
    if (!empty($header['HTTP_TOKEN'][0])) 
    {
        $token = $header['HTTP_TOKEN'][0];
        $result = $db->validateToken($token);
        if (!$result == JWT_TOKEN_FINE)
            $error = true;
        else if($result == JWT_TOKEN_ERROR || $result==JWT_USER_NOT_FOUND)
        {
            $error = true;
        }
    }

    else
    {
        $error = true;
    }
    if ($error)
        return false;
    else
        return true;
}

$app->run();