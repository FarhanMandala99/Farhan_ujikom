<?php
require 'dbConnect.php';
session_start();
function loginRegister(){
  if(isset($_SESSION['userid'])){
  session_destroy();
  }
  if(isset($_POST['login']) || isset($_POST['register'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $namalengkap = $_POST['namalengkap'];
    $alamat = $_POST['alamat'];

    if(isset($_POST['login'])){
      $verify = mysqli_query(conn(),"SELECT * FROM user WHERE email = '$email' AND password = '$password'");
      $sessionId = mysqli_fetch_assoc($verify);
      $_SESSION['userid'] = $sessionId['user_id'];
      (mysqli_num_rows($verify) == 1) ? header('location:index.php') : header('location:login.php');
    }else if(isset($_POST['register'])){
      mysqli_query(conn(),"INSERT INTO user VALUES('','$username','$password','$email','$namalengkap','$alamat')");
      header('location:index.php');
    }
  }
}
loginRegister();
?>