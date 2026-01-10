<?php
$path = $_SERVER['DOCUMENT_ROOT'];

// connect the database connection
require_once  $path .  '/LU-Clubs/model/connect_db.php';

class UserAuthModel {
    

    public function verify_login($email){
        global $conn;

        $email = addslashes(trim($email)); // sanitize the input

        // if this email is in the database

        $ifExistSql = "SELECT * FROM `user` WHERE `email` = '$email' LIMIT 1";
        $result = $conn->query($ifExistSql);

        if ($result->num_rows > 0) {
            // create an otp
            $otp = rand(100000, 999999);

            // save the otp in the database
            $saveOtpSql = "UPDATE `user` SET `otp` = '$otp' WHERE `email` = '$email'";
            $conn->query($saveOtpSql);
            
            // send the otp to the email   
            $to = $email;
            $subject = "Lu Clubs: OTP for login";
            $message = "Your OTP for login is: " . $otp;
            $headers = "From: admin@lu-clubs.com";

            mail($to, $subject, $message, $headers);

            return [
                'status' => 'success',
                'message' => 'OTP has been sent to your email'
            ];

        } else {
            return [
                'status' => 'error',
                'message' => 'This email does not exist'
            ];
        }
    }

    public function verify_otp($email, $otp){
        global $conn;

        $email = addslashes(trim($email)); // sanitize the input
        $otp = addslashes(trim($otp)); // sanitize the input

        // if this email is in the database

        $ifExistSql = "SELECT * FROM `user` WHERE `email` = '$email' AND `otp` = '$otp' LIMIT 1";
        $result = $conn->query($ifExistSql);

        if ($result->num_rows > 0) {
            // create a token
            $token = md5($email . time());

            // save the token in the database
            $saveTokenSql = "UPDATE `user` SET `token` = '$token' WHERE `email` = '$email'";
            $conn->query($saveTokenSql);

            return [
                'status' => 'success',
                'message' => 'OTP has been verified',
                'token' => $token
            ];

        } else {
            return [
                'status' => 'error',
                'message' => 'OTP is incorrect'
            ];
        }
    }
}


// $usrAuth = new UserAuthModel();
// print_r($usrAuth->verify_login('lipuahmedazaz79@gmail.com'));
