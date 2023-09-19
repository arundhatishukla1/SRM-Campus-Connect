<?php
require 'config.php';
$message = '';
if(isset($_POST["submit"])){
    $name = $_POST["name"];
    $email = $_POST["email"]; 
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirmpassword"];
    $duplicate = mysqli_query($conn, "SELECT * FROM user WHERE name = '$name' OR email = '$email'");
    if(mysqli_num_rows($duplicate) > 0){
        echo
        "<script> alert('Username or Email has Already Taken'); </script> ";
    }
    else{
        if($password == $confirmpassword){
            $query = "INSERT INTO user (name, email, password) VALUES('$name', '$email', '$password')";
            if (mysqli_query($conn, $query)){
                echo
                "<script> alert('Signup Successful'); </script> ";
                header('Location: login.php');
            } 
            else{
                    $message = 'Error: ' . mysqli_error($conn);
            }

            
        }
        else{
            echo
            "<script> alert('Password does not  match'); </script> ";
        }
    }
}
?>
<!--
<!DOCTYPE html>
<HTML LANG ="en" dir = "ltr">
    <head>
        <meta charset = "utf-8">
        <title>Registration</title>
    </head>
    <body>
        <h2>Registration</h2>
        <form class= "" action = "" method = "post" autocomplete = "off">
            <label for = "name">Name: </label>
            <input type = "text" name = "name" id = "name" required value = ""> <br>
            <label for = "email">Email: </label>
            <input type = "text" name = "email" id = "email" required value = ""> <br>
            <label for = "password">Password: </label>
            <input type = "password" name = "password" id = "password" required value = ""> <br>
            <label for = "confirmpassword">Name: </label>
            <input type = "password" name = "confirmpassword" id = "confirmpassword" required value = ""> <br>
            <button type = "submit" name = "submit">Register</button>
</form>
</body>
</html>
-->

<!--
Author: Colorlib
Author URL: https://colorlib.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<html>
<head>
<title>Creative Colorlib SignUp Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Custom Theme files -->
<link href="signup.css" rel="stylesheet" type="text/css" media="all" />
<!-- //Custom Theme files -->
<!-- web font -->
<link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
<!-- //web font -->
</head>
<body>
	<!-- main -->
	<div class="main-w3layouts wrapper">
		<h1>Campus Event Management</h1>
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form action="" method="post">
					<input class="text" type="text" name="name" placeholder="name" required="">
					<input class="text email" type="text" name="email" placeholder="Email" required="">
					<input class="text" type="password" name="password" placeholder="Password" required="">
					<input class="text w3lpass" type="password" name="confirmpassword" placeholder="Confirm Password" required="">
					<div class="wthree-text">
						<label class="anim">
							<input type="checkbox" class="checkbox" required="">
							<span>I Agree To The Terms & Conditions</span>
						</label>
						<div class="clear"> </div>
					</div>
					<input type="submit" name = "submit" value="submit" >
				</form>
				<p>Already have an Account? <a href="login.php"> Login Now!</a></p>
			</div>
		</div>
</body>
</html>