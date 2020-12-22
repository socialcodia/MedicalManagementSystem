<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//use Slim\Factory\AppFactory
require '../vendor/autoload.php';
require_once '../include/DbHandler.php';
require_once '../include/AdminDbHandler.php';
require_once '../vendor/autoload.php';
require_once '../include/JWT.php';

$JWT = new JWT;

$app = new \Slim\App;;

$app = new Slim\App([

    'settings' => [
        'displayErrorDetails' => true,
        'debug'               => true,
    ]
]);


$app->post('/register', function(Request $request, Response $response)
{
    if(!checkEmptyParameter(array('name','email','password'),$request,$response))
    {
        $db = new DbHandler();
        $requestParameter = $request->getParsedBody();
        $email = $requestParameter['email'];
        $password = $requestParameter['password'];
        $name = $requestParameter['name'];
        if (strlen($name)>30)
            return returnException(true,NAME_GRETER,$response);
        if (strlen($name)<4)
            return returnException(true,NAME_LOWER,$response);
        $name = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($name))))));
        $result = $db->createUser($name,$email,$password);
        if($result == USER_CREATION_FAILED)
            return returnException(true,USER_CREATION_FAILED,$response);
        else if($result == EMAIL_EXIST)
            return returnException(true,EMAIL_EXIST,$response);
        else if($result == USERNAME_EXIST)
            return returnException(true,USERNAME_EXIST,$response);
        else if($result == USER_CREATED){
            $code = $db->getCode(1);
            if(prepareVerificationMail($name,$email,$code))
               return returnException(false,EMAIL_VERIFICATION_SENT.$email,$response);
            else
               return returnException(true,EMAIL_VERIFICATION_SENT_FAILED,$response);
        }
        else if($result == VERIFICATION_EMAIL_SENT_FAILED)
            return returnException(true,EMAIL_VERIFICATION_SENT_FAILED,$response);
        else if($result == EMAIL_NOT_VALID)
            return returnException(true,EMAIL_NOT_VALID,$response);
    }
});

$app->get('/demo',function(Request $request, Response $response,array $args )
{
    $db = new DbHandler;
    $db->setUserId(190);
    // $users = array();
        $responseG = array();
        $responseG['success'] = true;
        $responseG[ERROR] = false;
        $responseG[MESSAGE] = "Searching Users By Keywords";
        $responseG['data'] = $db->getHiddenFeeds();
        $response->write(json_encode($responseG));
        return $response->withHeader(CT,AJ)
                ->withStatus(200);
});

$app->get('/demo1',function(Request $request, Response $response,array $args )
{
    $db = new DbHandler;
    $db->setUserId(190);
    // $users = array();
        $responseG = array();
        $responseG['success'] = true;
        $responseG[ERROR] = false;
        $responseG[MESSAGE] = "Searching Users By Keywords";
        $responseG['data'] = $db->test();
        $response->write(json_encode($responseG));
        return $response->withHeader(CT,AJ)
                ->withStatus(200);
});

$app->post('/login', function(Request $request, Response $response)
{
    if(!checkEmptyParameter(array('email','password'),$request,$response))
    {
        $db = new DbHandler;
        $requestParameter = $request->getParsedBody();
        $email = $requestParameter[EMAIL];
        $password = $requestParameter['password'];
        if (!$db->isEmailValid($email)) 
        {
            return returnException(true,EMAIL_NOT_VALID,$response);
        }
        if (!empty($email)) 
        {
            $result = $db->login($email,$password);
            if($result ==LOGIN_SUCCESSFULL)
            {
                $user = $db->getUserByEmail($email);
                $user[TOKEN] = getToken($user['id']);
                $responseUserDetails = array();
                $responseUserDetails[ERROR] = false;
                $responseUserDetails[MESSAGE] = LOGIN_SUCCESSFULL;
                $responseUserDetails[USER] = $user;
                $response->write(json_encode($responseUserDetails));
                return $response->withHeader(CT, AJ)
                         ->withStatus(200);
            }
            else if($result ==USER_NOT_FOUND)
                return returnException(true,USER_NOT_FOUND,$response);
            else if($result ==PASSWORD_WRONG)
                return returnException(true,PASSWORD_WRONG,$response);
            else if($result ==UNVERIFIED_EMAIL)
                return returnException(true,UNVERIFIED_EMAIL,$response);
            else
                return returnException(true,SWW,$response);
        }
        else
            return returnException(true,USER_NOT_FOUND,$response);
    }
});

$app->post('/password/forgot', function(Request $request, Response $response)
{
    if(!checkEmptyParameter(array('email'),$request,$response))
    {
        $db = new DbHandler;
        $requestParameter = $request->getParsedBody();
        $email= $requestParameter['email'];
        $result = $db->forgotPassword($email);
        if($result == CODE_UPDATED)
        {
            $name = $db->getNameByEmail($email);
            $codeForForgotPassword = 2;
            $code = decrypt($db->getCode($codeForForgotPassword));
            if(prepareForgotPasswordMail($name,$email,$code))
                return returnException(false,EMAIL_OTP_SENT,$response);
            else
              return returnException(true,EMAIL_OTP_SEND_FAILED,$response);
        }
        else if($result == EMAIL_NOT_VALID)
            return returnException(true,EMAIL_NOT_VALID,$response);
        else if($result ==USER_NOT_FOUND)
            return returnException(true,EMAIL_NOT_EXIST,$response);
        else if($result ==EMAIL_NOT_VERIFIED)
            return returnException(true,EMAIL_NOT_VERIFIED,response);
        else if($result ==CODE_UPDATE_FAILED)
            return returnException(true,SWW,$response);
        else
            return returnException(true,SWW,$response);
    }
});


$app->post('/add/product',function(Request $request, Response $response)
{
    $db = new DbHandler;
    if (validateToken($db,$request,$response)) 
    {
        if(!checkEmptyParameter(array('productName'),$request,$response))
            {
                $requestParameter = $request->getParsedBody();
                $productName = $requestParameter['productName'];
                if($db->addProduct($productName))
                    return returnException(true,"Product Added",$response);
                else
                    return returnException(true,"Failed To Add Product",$response);
            }
    }
    else
        return returnException(true,UNAUTH_ACCESS,$response);
});

$app->post('/add/brand',function(Request $request, Response $response)
{
    $db = new DbHandler;
    if (validateToken($db,$request,$response)) 
    {
        if(!checkEmptyParameter(array('brandName'),$request,$response))
            {
                $requestParameter = $request->getParsedBody();
                $brandName = $requestParameter['brandName'];
                if($db->addBrand($brandName))
                    return returnException(true,"Brand Added",$response);
                else
                    return returnException(true,"Failed To Add Brand",$response);
            }
    }
    else
        return returnException(true,UNAUTH_ACCESS,$response);
});

$app->get('/get/brands',function(Request $request, Response $response)
{
    $db = new DbHandler;
    if (validateToken($db,$request,$response)) 
    {
        $brands = $db->getBrands();
        if(!empty($brands))
        {
            $resp = array();
            $resp['error'] = false;
            $resp['message'] = "Brand List Found";
            $resp['brands'] = $brands;
            $response->write(json_encode($resp));
            return $response->withHeader(CT,AJ)
                            ->withStatus(200);
        }
        else
            return returnException(true,"No Brands Found",$response);
    }
    else
        return returnException(true,UNAUTH_ACCESS,$response);
});

$app->get('/get/sizes',function(Request $request, Response $response)
{
    $db = new DbHandler;
    if (validateToken($db,$request,$response)) 
    {
        $sizes = $db->getSizes();
        if(!empty($sizes))
        {
            $resp = array();
            $resp['error'] = false;
            $resp['message'] = "Size List Found";
            $resp['sizes'] = $sizes;
            $response->write(json_encode($resp));
            return $response->withHeader(CT,AJ)
                            ->withStatus(200);
        }
        else
            return returnException(true,"No Size Found",$response);
    }
    else
        return returnException(true,UNAUTH_ACCESS,$response);
});

$app->get('/get/categories',function(Request $request, Response $response)
{
    $db = new DbHandler;
    if (validateToken($db,$request,$response)) 
    {
        $categories = $db->getCategories();
        if(!empty($categories))
        {
            $resp = array();
            $resp['error'] = false;
            $resp['message'] = "Categories List Found";
            $resp['categories'] = $categories;
            $response->write(json_encode($resp));
            return $response->withHeader(CT,AJ)
                            ->withStatus(200);
        }
        else
            return returnException(true,"No Categories Found",$response);
    }
    else
        return returnException(true,UNAUTH_ACCESS,$response);
});

$app->get('/get/locations',function(Request $request, Response $response)
{
    $db = new DbHandler;
    if (validateToken($db,$request,$response)) 
    {
        $locations = $db->getLocations();
        if(!empty($locations))
        {
            $resp = array();
            $resp['error'] = false;
            $resp['message'] = "Locations List Found";
            $resp['locations'] = $locations;
            $response->write(json_encode($resp));
            return $response->withHeader(CT,AJ)
                            ->withStatus(200);
        }
        else
            return returnException(true,"No Locations Found",$response);
    }
    else
        return returnException(true,UNAUTH_ACCESS,$response);
});

$app->get('/get/products',function(Request $request, Response $response)
{
    $db = new DbHandler;
    if (validateToken($db,$request,$response)) 
    {
        $products = $db->getProducts();
        if(!empty($products))
        {
            $resp = array();
            $resp['error'] = false;
            $resp['message'] = "products List Found";
            $resp['products'] = $products;
            $response->write(json_encode($resp));
            return $response->withHeader(CT,AJ)
                            ->withStatus(200);
        }
        else
            return returnException(true,"No Products Found",$response);
    }
    else
        return returnException(true,UNAUTH_ACCESS,$response);
});


$app->post('/add/size',function(Request $request, Response $response)
{
    $db = new DbHandler;
    if (validateToken($db,$request,$response)) 
    {
        if(!checkEmptyParameter(array('sizeName'),$request,$response))
            {
                $requestParameter = $request->getParsedBody();
                $sizeName = $requestParameter['sizeName'];
                if($db->addSize($sizeName))
                    return returnException(true,"Size Added",$response);
                else
                    return returnException(true,"Failed To Add Size",$response);
            }
    }
    else
        return returnException(true,UNAUTH_ACCESS,$response);
});

$app->post('/add/category',function(Request $request, Response $response)
{
    $db = new DbHandler;
    if (validateToken($db,$request,$response)) 
    {
        if(!checkEmptyParameter(array('categoryName'),$request,$response))
            {
                $requestParameter = $request->getParsedBody();
                $categoryName = $requestParameter['categoryName'];
                if($db->addCategory($categoryName))
                    return returnException(true,"Category Added",$response);
                else
                    return returnException(true,"Failed To Add Category",$response);
            }
    }
    else
        return returnException(true,UNAUTH_ACCESS,$response);
});

$app->post('/add/location',function(Request $request, Response $response)
{
    $db = new DbHandler;
    if (validateToken($db,$request,$response)) 
    {
        if(!checkEmptyParameter(array('locationName'),$request,$response))
            {
                $requestParameter = $request->getParsedBody();
                $locationName = $requestParameter['locationName'];
                if($db->addLocation($locationName))
                    return returnException(true,"Location Added",$response);
                else
                    return returnException(true,"Failed To Add Location",$response);
            }
    }
    else
        return returnException(true,UNAUTH_ACCESS,$response);
});

function checkEmptyParameter($requiredParameter,$request,$response)
{
    $result = array();
    $error = false;
    $errorParam = '';
    $requestParameter = $request->getParsedBody();
    foreach($requiredParameter as $param)
    {
        if(!isset($requestParameter[$param]) || strlen($requestParameter[$param])<1)
        {
            $error = true;
            $errorParam .= $param.', ';
        }
    }
    if($error)
        return returnException(true,"Required Parameter ".substr($errorParam,0,-2)." is missing",$response);
    return $error;
}

function prepareForgotPasswordMail($name,$email,$code)
{
    $websiteDomain = WEBSITE_DOMAIN;
    $websiteName = WEBSITE_NAME;
    $websiteEmail = WEBSITE_EMAIL;
    $websiteOwnerName = WEBSITE_OWNER_NAME;
    $ipAddress = "(".$_SERVER['REMOTE_ADDR'].")";
    $mailSubject = "Recover your $websiteName password";
    $mailBody= <<<HERE
    <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <!-- HIDDEN PREHEADER TEXT -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td bgcolor="#FFA73B" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#FFA73B" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">Welcome!</h1><img src=" https://img.icons8.com/clouds/100/000000/handshake.png" width="125" height="120" style="display: block; border: 0px;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">You told us you forgot your password, If you really did, Use this OTP (One Time Password) to choose a new one.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="border-radius: 3px;" bgcolor="#FFA73B"><b style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #FFA73B; display: inline-block;">$code</b></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">For security, this request was recieved from ip address $ipAddress. <br> If you didn't make this request, you can safely ignore this email :)</p>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 400; line-height: 25px;">
                           <br> <p style="margin: 0;">If you have any questions, just reply to this email—we're always happy to help out.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">$websiteOwnerName,<br>$websiteName Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#FFECD1" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Need more help?</h2>
                            <p style="margin: 0;"><a href="$websiteDomain" target="_blank" style="color: #FFA73B;">We&rsquo;re here to help you out</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    HERE;;

    if(sendMail($name,$email,$mailSubject,$mailBody))
        return true;
    return false;
}

function prepareDeleteAccountVerificationMail($name,$email,$code)
{
    $websiteDomain = WEBSITE_DOMAIN;
    $websiteName = WEBSITE_NAME;
    $websiteEmail = WEBSITE_EMAIL;
    $websiteOwnerName = WEBSITE_OWNER_NAME;
    $ipAddress = "(".$_SERVER['REMOTE_ADDR'].")";
    $mailSubject = "$websiteName Deletion Confirmation";
    $mailBody= <<<HERE
    <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <!-- HIDDEN PREHEADER TEXT -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td bgcolor="#FFA73B" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#FFA73B" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">Welcome!</h1><img src=" https://img.icons8.com/cute-clipart/64/000000/delete-forever.png" width="125" height="120" style="display: block; border: 0px;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">You told us to permanetly delete your $websiteName account., If you really did, Use this OTP (One Time Password) to permanently delete your account.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="border-radius: 3px;" bgcolor="#FFA73B"><b style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #FFA73B; display: inline-block;">$code</b></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">For security, this request was recieved from ip address $ipAddress. <br> If you didn't make this request, you can safely ignore this email :)</p>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 400; line-height: 25px;">
                           <br> <p style="margin: 0;">If you have any questions, just reply to this email—we're always happy to help out.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">$websiteOwnerName,<br>$websiteName Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#FFECD1" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Need more help?</h2>
                            <p style="margin: 0;"><a href="$websiteDomain" target="_blank" style="color: #FFA73B;">We&rsquo;re here to help you out</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    HERE;;

    if(sendMail($name,$email,$mailSubject,$mailBody))
        return true;
    return false;
}

function prepareVerificationMail($name,$email,$code)
{
    $emailEncrypted = encrypt($email);
    $websiteDomain = WEBSITE_DOMAIN;
    $websiteName = WEBSITE_NAME;
    $websiteEmail = WEBSITE_EMAIL;
    $websiteOwnerName = WEBSITE_OWNER_NAME;
    $endPoint = "/verifyEmail/";
    $mailSubject="Verify Your Email Address For $websiteName";
    $mailBody= <<<HERE
    <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <!-- HIDDEN PREHEADER TEXT -->
    <div style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;"> We're thrilled to have you here! Get ready to dive into your new account. </div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td bgcolor="#FFA73B" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#FFA73B" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">Welcome!</h1><img src=" https://img.icons8.com/clouds/100/000000/handshake.png" width="125" height="120" style="display: block; border: 0px;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">We're excited to have you get started. First, you need to confirm your account. Just press the button below.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td bgcolor="#ffffff" align="center" style="padding: 20px 30px 60px 30px;">
                                        <table border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td align="center" style="border-radius: 3px;" bgcolor="#FFA73B"><a href="$websiteDomain$endPoint$emailEncrypted/$code" target="_blank" style="font-size: 20px; font-family: Helvetica, Arial, sans-serif; color: #ffffff; text-decoration: none; color: #ffffff; text-decoration: none; padding: 15px 25px; border-radius: 2px; border: 1px solid #FFA73B; display: inline-block;">Confirm Account</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">If that doesn't work, copy and paste the following link in your browser:</p>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;"><a href="#" target="_blank" style="color: #FFA73B;">$websiteDomain$endPoint$emailEncrypted/$code</a></p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">If you have any questions, just reply to this email—we're always happy to help out.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">$websiteOwnerName,<br>$websiteName Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#FFECD1" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Need more help?</h2>
                            <p style="margin: 0;"><a href="$websiteDomain" target="_blank" style="color: #FFA73B;">We&rsquo;re here to help you out</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    HERE;;
    if(sendMail($name,$email,$mailSubject,$mailBody))
        return true;
    return false;
}

function preparePasswordChangedMail($name,$email)
{
    $websiteDomain = WEBSITE_DOMAIN;
    $websiteName = WEBSITE_NAME;
    $websiteEmail = WEBSITE_EMAIL;
    $websiteOwnerName = WEBSITE_OWNER_NAME;
    $ipAddress = "(".$_SERVER['REMOTE_ADDR'].")";
    date_default_timezone_set('Asia/Kolkata');
    $currentDate = date('d');
    $currentMonth =  DateTime::createFromFormat('!m',date('m'));
    $currentMonth = $currentMonth->format('F');
    $currentYear = date('yy');
    $currentTime = date('h:i a');
    $mailSubject = "Your password has been changed.";
    $mailBody = <<<HERE
    <body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <!-- HIDDEN PREHEADER TEXT -->
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td bgcolor="#FFA73B" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#FFA73B" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top" style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">Welcome!</h1><img src=" https://img.icons8.com/clouds/100/000000/handshake.png" width="125" height="120" style="display: block; border: 0px;" />
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 20px 30px 40px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">This is a confirmation that your password was changed at $currentTime on $currentDate $currentMonth $currentYear</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 0px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">For security, The password was changed from the Ip Address $ipAddress. If this was you, then you can safely ignore this email :)</p>
                        </td>
                    </tr> <!-- COPY -->
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 20px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 15px; font-weight: 400; line-height: 25px;">
                           <br> <p style="margin: 0;">If you have any questions, just reply to this email—we're always happy to help out.</p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding: 0px 30px 40px 30px; border-radius: 0px 0px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <p style="margin: 0;">$websiteOwnerName,<br>$websiteName Team</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#FFECD1" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <h2 style="font-size: 20px; font-weight: 400; color: #111111; margin: 0;">Need more help?</h2>
                            <p style="margin: 0;"><a href="$websiteDomain" target="_blank" style="color: #FFA73B;">We&rsquo;re here to help you out</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    </body>
    HERE;;
    sendMail($name,$email,$mailSubject,$mailBody);
}

function sendMail($name,$email,$mailSubject,$mailBody)
{
    $websiteEmail = WEBSITE_EMAIL;
    $websiteEmailPassword = WEBSITE_EMAIL_PASSWORD;
    $websiteName = WEBSITE_NAME;
    $websiteOwnerName = WEBSITE_OWNER_NAME;
    $mail = new PHPMailer;
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host=SMTP_HOST;
    $mail->Port=SMTP_PORT;
    $mail->SMPTSecure=SMTP_SECURE;
    $mail->SMTPAuth=true;
    $mail->SMTPOptions = array(
    // 'ssl' => array(
    //     'verify_peer' => false,
    //     'verify_peer_name' => false,
    //     'allow_self_signed' => true
    // )
);
    $mail->Username = $websiteEmail;
    $mail->Password = $websiteEmailPassword;
    $mail->addAddress($email,$name);
    $mail->isHTML();
    $mail->Subject=$mailSubject;
    $mail->Body=$mailBody;
    $mail->From=$websiteEmail;
    $mail->FromName=$websiteName;
    if($mail->send())
    {
        return true;
    }
    return false;
}

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
    return $response->withHeader('Content-type','Application/json')
                    ->withStatus(200);
}

function returnResponse($error,$message,$response,$data)
{
    $responseDetails = array();
    $responseDetails[ERROR] = $error;
    $responseDetails[MESSAGE] = $message;
    $responseDetails[MESSAGE] = $data;
    $response->write(json_encode($responseDetails));
    return $response->withHeader(CT,AJ)
                    ->withStatus(200);
}

function getToken($userId)
{
    $key = JWT_SECRET_KEY;
    $payload = array(
        "iss" => "socialcodia.com",
        "iat" => time(),
        "user_id" => $userId
    );
    $token =JWT::encode($payload,$key);
    return $token;
}

function getAdminToken($userId)
{
    $key = JWT_ADMIN_SECRET_KEY;
    $payload = array(
        "iss" => "http://cpanel.famblah.cf",
        "iat" => time(),
        "user_id" => $userId
    );
    $token =JWT::encode($payload,$key);
    return $token;
}

function validateToken($db,$request,$response)
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

function validateAdminToken($db,$request,$response)
{
    $error = false;
    $header =$request->getHeaders();
    if (!empty($header['HTTP_TOKEN'][0])) 
    {
        $token = $header['HTTP_TOKEN'][0];
        $result = $db->validateAdminToken($token);
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