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

    function addSeller($sellerFirstName,$sellerLastName,$sellerEmail,$sellerContactNumber,$sellerContactNumber1,$sellerImage,$sellerAddress)
    {
        if (isset($_COOKIE['token'])) 
        {
            $tokenCookie = $_COOKIE['token'];
        }
        $header[]= "Content-Type:multipart/form-data";
        $header[] = "token: $tokenCookie";
        if (isset($sellerImage) && !empty($sellerImage['tmp_name']))
        {
            if ($sellerImage['type']=="image/png" || $sellerImage['type']=="image/jpg" || $sellerImage['type']=="image/jpeg") 
            {
                $sellerImage = $sellerImage['tmp_name'];
                $sellerImage = new CURLFile($sellerImage,'image/png', 'filename.png');
            }
            else
                $sellerImage = "";
        }
        else
            $sellerImage = "";
        $postField = array('sellerFirstName'=>$sellerFirstName,'sellerLastName'=>$sellerLastName,'sellerEmail'=>$sellerEmail,'sellerContactNumber'=>$sellerContactNumber,'sellerContactNumber1'=>$sellerContactNumber1,'sellerImage'=>$sellerImage,'sellerAddress'=>$sellerAddress);
        $endPoint = 'seller/add';
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
        return $response;
    }

    function getUser()
    {
        return $this->getMethodApi("user");
    }

    function getProductById($productId)
    {
        return $this->getMethodApi("product/".$productId);
    }

    function getProducts()
    {
        return $this->getMethodApi("products");
    }

    function getProductsRecord()
    {
        return $this->getMethodApi("products/records");
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

    function getNoticeProductsCount()
    {
        return $this->getMethodApi("counts/products/notice");
    }

    function getExpiringProductsCount()
    {
        return $this->getMethodApi("counts/products/expiring");
    }

    function getExpiredProductsCount()
    {
        return $this->getMethodApi("counts/products/expired");
    }

    function getSellers()
    {
        return $this->getMethodApi("sellers");
    }

    function getInvoices()
    {
        return $this->getMethodApi("invoices");
    }

    function getInvoiceByInvoiceNumber($invoiceNumber)
    {
        return $this->getMethodApi("invoice/".$invoiceNumber);
    }

    function getInvoiceUrlByInvoiceNumber($invoiceNumber)
    {
        return $this->getMethodApi("invoice/".$invoiceNumber."/pdf");
    }

    function getPaymentsByInvoiceNumber($invoiceNumber)
    {
        return $this->getMethodApi("invoice/".$invoiceNumber."/payments");
    }

    function getSellerById($sellerId)
    {
        return $this->getMethodApi("seller/".$sellerId);
    }

    function getInvoicesBySellerId($sellerId)
    {
        return $this->getMethodApi("seller/".$sellerId."/invoice");
    }

    function getCredits()
    {
        return $this->getMethodApi("credits");
    }

    function getCreditById($creditId)
    {
        return $this->getMethodApi("credit/".$creditId);
    }

    function getPaymentsByCreditId($creditId)
    {
        return $this->getMethodApi("credit/".$creditId."/payments");
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


