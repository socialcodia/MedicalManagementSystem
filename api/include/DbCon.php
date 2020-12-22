<?php

class DbCon
{
    private $con;
    function Connect()
    {    
        require dirname(__FILE__) . '/Constants.php';
        $this->con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
        if(mysqli_connect_error())
        {
            echo "Failed to connect database server";
            return false;
        }
        return $this->con;
    }

}