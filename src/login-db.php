<?php
session_start();
require('dbconnect.php');

$errors = array();

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email) && empty($password)) {
    array_push($errors, "Please fill your Email and Password");
    $_SESSION['error'] = "Please fill your Email and Password";
    header("location:login-form.php");
    exit();
}

if (empty($email)) {
    array_push($errors, "Email is required");
    $_SESSION['error'] = "Email is required";
    header("location:login-form.php");
    exit();
}
if (empty($password)) {
    array_push($errors, "Password is required");
    $_SESSION['error'] = "Password is required";
    header("location:login-form.php");
    exit();
}

if (count($errors) == 0) {
    $user_check = "SELECT * FROM users WHERE email = '$email'";
    $sql_user_check = mysqli_query($connect, $user_check);
    $userVer = mysqli_fetch_object($sql_user_check);

    if (mysqli_num_rows($sql_user_check) == 0) {
        $_SESSION['error'] = "Email or Password is wrong. Please try again!";
        header("location:login-form.php");
        exit();
    } else {
        if (password_verify($password, $userVer->password)) {
            $_SESSION['username'] = $userVer->username;
            $_SESSION['success'] = "login successfully";
            header("location:index.php");
            exit();
        } else {
            $_SESSION['error'] = "Password is wrong";
            header("location:login-form.php");
            exit();
        }
    }
} else {
}
