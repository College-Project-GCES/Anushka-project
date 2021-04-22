<?php
 session_start();
?>
<!DOCTYPE html>
<html>
<title> account create garni page</title>
<style>
body {font-family: Arial, Helvetica, sans-serif;}
* {box-sizing: border-box;}

/* Full-width input fields */
input[type=text], input[type=password] {
  width: 100%;
  padding: 15px;
  margin: 5px 0 22px 0;
  display: inline-block;
  border: none;
  background: #f1f1f1;
}

/* Add a background color when the inputs get focus */
input[type=text]:focus, input[type=password]:focus {
  background-color: #ddd;
  outline: none;
}

/* Set a style for all buttons */
button {
  background-color: #4CAF50;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
  opacity: 0.9;
}

button:hover {
  opacity:1;
}

/* Extra styles for the cancel button */
.cancelbtn {
  padding: 14px 20px;
  background-color: #f44336;
}

/* Float cancel and signup buttons and add an equal width */
.cancelbtn, .signupbtn {
  float: left;
  width: 50%;
}

/* Add padding to container elements */
.container {
  padding: 16px;
}

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: #474e5d;
  padding-top: 50px;
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 5% auto 15% auto; /* 5% from the top, 15% from the bottom and centered */
  border: 1px solid #888;
  width: 80%; /* Could be more or less, depending on screen size */
}

/* Style the horizontal ruler */
hr {
  border: 1px solid #f1f1f1;
  margin-bottom: 25px;
}
 
/* The Close Button (x) */
.close {
  position: absolute;
  right: 35px;
  top: 15px;
  font-size: 40px;
  font-weight: bold;
  color: #f1f1f1;
}

.close:hover,
.close:focus {
  color: #f44336;
  cursor: pointer;
}

/* Clear floats */
.clearfix::after {
  content: "";
  clear: both;
  display: table;
}

/* Change styles for cancel button and signup button on extra small screens */
@media screen and (max-width: 300px) {
  .cancelbtn, .signupbtn {
     width: 100%;
  }
}
</style>
<body>

<?php 
include 'connection.php';
 if (isset($_POST['submit'])) {
  $nmc_no = mysqli_real_escape_string($con,$_POST['nmc_no']);
  $first_name = mysqli_real_escape_string($con,$_POST['first_name']);
  $last_name = mysqli_real_escape_string( $con,$_POST['last_name']);

  $email = mysqli_real_escape_string($con,$_POST['email']);
  $password = mysqli_real_escape_string($con,$_POST['password']);
  $confirm_password =mysqli_real_escape_string($con, $_POST['confirm_password']);
  $address = mysqli_real_escape_string($con,$_POST['address']);
  $contact_number = mysqli_real_escape_string($con,$_POST['contact_number']);


  $pass = password_hash($password, PASSWORD_BCRYPT);
  $confirm_pass = password_hash($confirm_password, PASSWORD_BCRYPT);

  $emailquery =  "select *  from doctor_registration where email = '$email' ";
      $query = mysqli_query($con , $emailquery );
      $emailcount = mysqli_num_rows($query);
      echo $emailcount;
    

      if (true){
          // echo "email already exists.";
         
           if ($password === $confirm_password) {
             $insertquery = "insert into doctor_registration(nmc_no, first_name, last_name, email, password, confirm_password, address, contact_number) VALUES ('$nmc_no','$first_name', '$last_name', '$email', '$pass' ,'$confirm_pass', '$address' ,'$contact_number')";
             $iquery = mysqli_query($con , $insertquery);
             if ($iquery) { 
            
  
                 ?>
                     <script type="text/javascript">
                  alert('Inserted Succesful');
                       </script>
                         <?php

                          } else {
                              ?>
                        <script type="text/javascript">
                         alert('No Insertion');
                             </script>
                             <?php
                             }
                           ?>
  
   
<h2>Modal Signup Form</h2>

<button onclick="document.getElementById('id01').style.display='block'" style="width:auto;"> Doctor's Sign Up Page</button>

<div id="id01" class="modal">
  <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
  <form  method= "POST"class="modal-content" action="/action_page.php">
    <div class="container">
      <h1>Sign Up</h1>

      <p>Please fill in this form to create an account.</p>
      <h4>Step 1</h4>
      <hr>
      <label> <b>NMC Lisense Number</b></label>
      <input type="text" name="nmc_no" required>
      <label for="first_name"><b>First Name</b></label>
      <input type="text" placeholder="Enter your first name" name="text" required>
     <!-- <label for="middle_name"><b>Middle Name</b></label>
      <input type="text" placeholder="Enter your middle name (optional)" name="text" > -->
      <label for="last_name"><b>Last Name</b></label>
      <input type="text" placeholder="Enter your last name" name="text" required>
      <label for="email"><b>Email</b></label>
      <input type="text" placeholder="Enter Email" name="email" required>
      <label for="password"><b>Password</b></label>
      <input type="password" placeholder="Enter Password" name="password" required>
      <label for="password"><b> Confirm Password</b></label>
      <input type="password" placeholder="Enter Password to confirm" name="confirm_password" required>

      <label>Contact Number</label>
      <input type="text" name="phone number" required>
      <br>
       
      <label>Address</label>
      <input type="text" name="address">
      
      

      <button type="reset">Reset</button>
      <button type="submit" onclick="location.href='./doctor_verification_link.php';">Submit</button>

      
        
      
    </div>
  </form>
</div>

<script>
// Get the modal
var modal = document.getElementById('id01');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>
