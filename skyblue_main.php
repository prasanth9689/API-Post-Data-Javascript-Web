<?php

include "s_connect.php";
include "functions.php";

// Get the raw POST data 
$json = file_get_contents('php://input');

// Decode the JSON data into a PHP array
$data = json_decode($json, true);

if (json_last_error() === JSON_ERROR_NONE) {
    $access = htmlspecialchars($data['acc']);
}

switch ($access) {

    case "cr_master_signup":
        
        $name = htmlspecialchars($data['name']);
        $email = htmlspecialchars($data['email']);
        $mobile = htmlspecialchars($data['mobile']);
        $mPassword = htmlspecialchars($data['password']);
    
        $data = [];
        
        // Check user already exists
        $check="SELECT phone_no FROM master_users WHERE phone_no = $mobile";
        $rs = mysqli_query($con,$check);
        $data1 = mysqli_fetch_array($rs, MYSQLI_NUM);
        if($data1[0] > 1) {
             array_push($data, array("access auth"=>"true" , "status"=>"2" , "message"=>"User already exits!" ));
             header("Content-Type:Application/json");
             print json_encode($data);
            return;
        }

        $response = [];
        
        //Get a unique Salt
        $salt = getSalt();
        
        //Generate a unique password Hash
        $passwordHash = password_hash(concatPasswordWithSalt($mPassword, $salt),PASSWORD_DEFAULT);
                
        $Query = "INSERT INTO master_users (name, email, phone_no , password_hash, salt) 
                             VALUES ('$name' , '$email', '$mobile' , '$passwordHash' , '$salt')";
        if (mysqli_query($con, $Query)) {
            /*
              Success. Get newely created user id and details
            */
             $Sql_Query = "SELECT id FROM master_users WHERE phone_no = '$mobile' ";
             $result = mysqli_query($con, $Sql_Query);
             
              while ($row = mysqli_fetch_assoc($result)) {
                  array_push($data, array("access auth"=>"true" , "status"=>"1" , "message"=>"Success" ,  "user_id" => $row["id"]));
              }
              header("Content-Type:Application/json");
              print json_encode($data);
        }else{
            // Failed
             array_push($data, ["status" => false]);
             header("Content-Type:Application/json");
             print json_encode($data);
        }
        
        break;
    

    default:
        echo "Wrong access key";
        break;
      
}

?>
