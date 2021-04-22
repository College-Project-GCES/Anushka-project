<?php



function protect($data){
    return trim(strip_tags(addslashes($data)));
}

function encryptData($data, $key, $str){
    $encryption_key = base64_decode($key);
    $ivlength = substr(md5($str."users"),1, 16);
    $encryptedData = openssl_encrypt($data, "aes-256-cbc", $encryption_key, 0, $ivlength);

    return base64_encode($encryptedData.'::'.$ivlength);
}

if(isset($_POST['signup'])){

    // data from the signup form
    $nmc_no = protect($_POST['nmc_no']);
    $first_name = protect($_POST['first_name']);
    $last_name = protect($_POST['last_name']);
    $email = protect($_POST['email']);
    $password =  protect($_POST['password']);
    $confirmpassword =  protect($_POST['confirm_password']);
    $phonenumber =  protect($_POST['phoneNumber']);
    $address = protect($_POST['address']);
    $contact_number = protect($_POST['contact_number']);
    $activationCode = md5(rand());

    

    // checking if the password's match or not 
    if($password == $confirmpassword){
        require "./connection.php";

        $str = "/6G6F;WvK7;s{au/6G6F;WvK7;s{au";
        $key = md5($str);

        $EncryptedEmail = encryptData($email, $key, $str);
        $EncryptedPhonenumber = encryptData($phonenumber, $key, $str);

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql_email_check = "SELECT * FROM doctor_registration WHERE $email_column = '$EncryptedEmail';";
        $sql_phn_check = "SELECT * FROM doctor_registration WHERE $phoneNumber_column = '$EncryptedPhonenumber';";

            $query_email_check = mysqli_query($con, $sql_email_check);
            $query_phn_check = mysqli_query($con, $sql_phn_check);
            // checking if the email is already used
            
            if(mysqli_num_rows($query_email_check) > 0 ){
                header("location: ./doctor_signup.php?inputError=AlreadyUserEmail&infoBack=noEmail&first_nameB=$first_name&$last_nameB=$last_name&phoneB=$phonenumber&addressB=$address");
            }
            // checking if the phone number already exits
            else if(mysqli_num_rows($query_phn_check) > 0){
                header("location: ./doctor_signup.php?inputError=AlreadyUserEmail&infoBack=noEmail&first_nameB=$first_name&$last_nameB=$last_name&phoneB=$phonenumber&addressB=$address");
            }

            else{
            
                $sql = 
                    "INSERT INTO doctor_registration($first_name_column,$last_name_column, $email_column, $password_column, $activation_column, $emailVerification_column, $contact_number_column, $address_column) VALUES('$first_name','$last_name', '$EncryptedEmail', '$hashedPassword', '$activationCode', 'not verified', '$EncryptedPhonenumber','$address')";

                mysqli_query($con, $sql);

            }
    }else{
        header("location: ./doctor_signup.php?inputError=PasswordNotSame&infoBack=full&first_nameB=$first_name&last_nameB=$last_name&phoneB=$phonenumber&emailB=$email&addressB=$address");
    }
}else{
    header("location:./doctor_signup.php?error=IllegalWay");
}

?>