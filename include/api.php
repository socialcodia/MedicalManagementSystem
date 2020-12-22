<?php

require_once dirname(__FILE__).'/Constants.php';
$apiUrl = API_URL;

class Api
{
    function doLogin($email,$password)
    {
        $endPoint = '/login';
        $url = API_URL.$endPoint;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,"email=$email&password=$password");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        return $response;
    }

    function doPostFeed($content,$file,$feedPrivacy)
    {
        if (isset($_COOKIE['token'])) 
        {
            $tokenCookie = $_COOKIE['token'];
        }
        $header[]= "Content-Type:multipart/form-data";
        $header[] = "token: $tokenCookie";
        if (isset($file) && !empty($file['tmp_name']))
        {
            if ($file['type']=="image/png" || $file['type']=="image/jpg" || $file['type']=="image/jpeg") 
            {
                $file = $file['tmp_name'];
                $file = new CURLFile($file,'image/png', 'filename.png');
            }
            else if ($file['type']=="video/mp4") 
            {
                $file = $file['tmp_name'];
                $file = new CURLFile($file,'video/mp4', 'filename.mp4');
            }
            else
                $file = "";
        }
        else
            $file = "";

        if (!isset($feedPrivacy)) 
        {
            $feedPrivacy = 1;
        }
        $postField = array('file'=>$file,'content'=>$content,'feedPrivacy'=>$feedPrivacy);
        $endPoint = 'feed/post';
        $url = API_URL.$endPoint;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$postField);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response);
        // header("Refresh:0");
        return $response;
    }

    function getUser()
    {
        return $this->getMethodApi("user");
    }

    function getProducts()
    {
        return $this->getMethodApi("get/products");
    }

    function getProductsRecord()
    {
        return $this->getMethodApi("get/products/records");
    }

    function getNoticeProducts()
    {
        return $this->getMethodApi("products/notice");
    }

    function getExpiredProducts()
    {
        return $this->getMethodApi("products/expired");
    }

    function getExpiringProducts()
    {
        return $this->getMethodApi("products/expiring");
    }

    function getTodaysSalesRecord()
    {
        return $this->getMethodApi("sales/today");
    }

    function getAllSalesRecord()
    {
        return $this->getMethodApi("sales/all");
    }

    function getProductsCount()
    {
        return $this->getMethodApi("counts/product");
    }

    function getTodaysSalesCount()
    {
        return $this->getMethodApi("counts/sales/today");
    }

    function getBrandsCount()
    {
        return $this->getMethodApi("counts/brands");
    }

    function getMethodApi($endPoint)
    {
        $domain = API_URL;
        $endPoint = $endPoint;
        if (isset($_COOKIE['token'])) 
        {
            $tokenCookie = $_COOKIE['token'];
        }
        $url = $domain.$endPoint;
        $header[] = "token: $tokenCookie";
        $headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=utf-8';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response);
        return $response;
    }


}
?>


