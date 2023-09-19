<?php
require 'config.php';
$message = '';

if(isset($_POST["submit"])){
    $email = $_POST["email"]; 
    $password = $_POST["password"];
    
    // Check if the provided email and password match a user in the user table
    $user_query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $user_result = mysqli_query($conn, $user_query);

    // Check if the provided email and password match a head in the head table
    $head_query = "SELECT * FROM head WHERE head_email = '$email' AND head_password = '$password'";
    $head_result = mysqli_query($conn, $head_query);

    if(mysqli_num_rows($user_result) == 1){
        // Login successful for user
        // Set a session for the user role and email
        session_start();
        $_SESSION['role'] = 'user';
        $_SESSION['email'] = $email;
        
        echo "<script> alert('Login Successful'); </script>";
        header('Location: userhome.php');
    }
    elseif(mysqli_num_rows($head_result) == 1){
        // Login successful for head
        // Set a session for the head role and email
        session_start();
        $_SESSION['role'] = 'head';
        $_SESSION['head_email'] = $email;
        
        echo "<script> alert('Login Successful'); </script>";
        header('Location: home.php');
    }
    else{
        // Login failed
        echo "<script> alert('Login Failed. Please check your email and password.'); </script>";
        echo "MySQL Error: " . mysqli_error($conn); // Add this line to check for database errors
    }
}
?>









<!DOCTYPE html>
<html>
<head>
<title>Creative Colorlib SignUp Form</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Custom Theme files -->
<link href="login.css" rel="stylesheet" type="text/css" media="all" />
<!-- //Custom Theme files -->
<!-- web font -->
<link href="//fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,700,700i" rel="stylesheet">
<!-- //web font -->
</head>
<body>
	<!-- main -->
	<div class="main-w3layouts wrapper">
		<h1>SRM Event Connect</h1>
		<div class="main-agileinfo">
			<div class="agileits-top">
				<form action="" method="post">
					<input class="text email" type="text" name="email" placeholder="Email" required="">
					<input class="text" type="password" name="password" placeholder="Password" required="">
					<input type="submit" name = "submit" value="login">
				</form>
				<p>Don't have an Account? <a href="signup.php"> SignUp Now!</a></p>
			</div>
		</div>
</body>
</html>