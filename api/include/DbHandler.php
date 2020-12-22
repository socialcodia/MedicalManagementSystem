<?php

require_once dirname(__FILE__).'/JWT.php';

    $JWT = new JWT;


class DbHandler
{
    private $con;
    private $userId;
    private $videoId;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbCon.php';
        $db = new DbCon;
        $this->con =  $db->Connect();
    }

    //Getter Setter For User Id Only

    function setUserId($userId)
    {
        $this->userId = $userId;
    }

    function getUserId()
    {
        return $this->userId;
    }

    function setVideoId($videoId)
    {
        $this->videoId = $videoId;
    }

    function getVideoId()
    {
        return $this->videoId;
    }

    function login($email,$password)
    {
        if($this->isEmailValid($email))
        {
            if($this->isEmailExist($email))
            {
                $hashPass = $this->getPasswordByEmail($email);
                if(password_verify($password,$hashPass))
                {
                    return LOGIN_SUCCESSFULL;
                }
                else
                    return PASSWORD_WRONG;
            }
            else
                return USER_NOT_FOUND;
        }
        else
            return EMAIL_NOT_VALID;
    }

    function verifyPassword($password)
    {
        $hashPass = $this->getPasswordById($this->getUserId());
        if (password_verify($password,$hashPass))
            return true;
        else
            return false;
    }

    function addProduct($productName)
    {
        $query = "INSERT INTO products (product_name) VALUES(?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$productName);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    function addBrand($brandName)
    {
        $query = "INSERT INTO brands (brand_name) VALUES(?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$brandName);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    function addSize($sizeName)
    {
        $query = "INSERT INTO sizes (size_name) VALUES(?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$sizeName);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    function addCategory($categoryName)
    {
        $query = "INSERT INTO categories (category_name) VALUES(?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$categoryName);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    function addLocation($locationName)
    {
        $query = "INSERT INTO locations (location_name) VALUES(?)";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param("s",$locationName);
        if ($stmt->execute())
            return true;
        else
            return false;
    }

    function isEmailExist($email)
    {
        $query = "SELECT id FROM admin WHERE email=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->store_result();
        return $stmt->num_rows>0 ;
    }

    function getBrands()
    {
        $brands = array();
        $query = "SELECT brand_id,brand_name FROM brands";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($brandId,$brandName);
        while ($stmt->fetch())
        {
            $brand['brandId'] = $brandId;
            $brand['brandName'] = $brandName;
            array_push($brands, $brand);
        }
        return $brands;
    }

    function getSizes()
    {
        $sizes = array();
        $query = "SELECT size_id,size_name FROM sizes";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($sizeId,$sizeName);
        while ($stmt->fetch())
        {
            $size['sizeId'] = $sizeId;
            $size['sizeName'] = $sizeName;
            array_push($sizes, $size);
        }
        return $sizes;
    }

    function getCategories()
    {
        $categories = array();
        $query = "SELECT category_id,category_name FROM categories";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($categoryId,$categoryName);
        while ($stmt->fetch())
        {
            $category['categoryId'] = $categoryId;
            $category['categoryName'] = $categoryName;
            array_push($categories, $category);
        }
        return $categories;
    }

    function getLocations()
    {
        $locations = array();
        $query = "SELECT location_id,location_name FROM locations";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($locationId,$locationName);
        while ($stmt->fetch())
        {
            $location['locationId'] = $locationId;
            $location['locationName'] = $locationName;
            array_push($locations, $location);
        }
        return $locations;
    }

    function getProducts()
    {
        $products = array();
        $query = "SELECT product_id,product_name FROM products";
        $stmt = $this->con->prepare($query);
        $stmt->execute();
        $stmt->bind_result($productId,$productName);
        while ($stmt->fetch())
        {
            $product['productId'] = $productId;
            $product['productName'] = $productName;
            array_push($products, $product);
        }
        return $products;
    }

    function checkUserById($id)
    {
        $query = "SELECT email FROM admin WHERE id=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$id);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows>0)
            return true;
        else
            return false;
    }

    function getPasswordByEmail($email)
    {
        $query = "SELECT password FROM admin WHERE email=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->bind_result($password);
        $stmt->fetch();
        return $password;
    }

    function getUserIdByEmail($email)
    {
        $query = "SELECT id FROM users WHERE email=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->bind_result($id);
        $stmt->fetch();
        return $id;
    }

    function getCode($codeType)
    {
        $tokenId = $this->getUserId();
        $query = "SELECT code FROM codes WHERE userId=? AND codeType=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('ss',$tokenId,$codeType);
        $stmt->execute();
        $stmt->bind_result($code);
        $stmt->fetch();
        return $code;
    }

    function verifyCode($code,$codeType)
    {
        $dbCode = $this->decrypt($this->getCode($codeType));
        if ($code==$dbCode)
            return true;
        else
            return false;
    }

    function getUserByEmail($email)
    {
        $query = "SELECT id,name,username,email,image,status FROM admin WHERE email=?";
        $stmt = $this->con->prepare($query);
        $stmt->bind_param('s',$email);
        $stmt->execute();
        $stmt->bind_result($id,$name,$username,$email,$image,$status);
        $stmt->fetch();
        $user = array();
        $user['id'] = $id;
        $user['name'] = $name;
        $user['username'] = $username;
        $user['email'] = $email;
        $user['status'] = $status;
        if (empty($image))
            $image = DEFAULT_USER_IMAGE;
        $user['image'] = WEBSITE_DOMAIN.$image;
        return $user;
    }

    function isEmailValid($email)
    {
        if(filter_var($email,FILTER_VALIDATE_EMAIL))
            return true;
        else
            return false;
    }

    function validateToken($token)
    {
        try 
        {
            $key = JWT_SECRET_KEY;
            $payload = JWT::decode($token,$key,['HS256']);
            $id = $payload->user_id;
            if ($this->checkUserById($id)) 
            {
                $this->setUserId($payload->user_id);
                return JWT_TOKEN_FINE;
            }
            return JWT_USER_NOT_FOUND;
        } 
        catch (Exception $e) 
        {
            return JWT_TOKEN_ERROR;    
        }
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
}