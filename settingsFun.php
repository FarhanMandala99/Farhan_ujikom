<?php
require 'dbConnect.php';
session_start();

function edit(){
    if(isset($_POST['editButton'])){
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $namalengkap = $_POST['namalengkap'];
        $alamat = $_POST['alamat'];
        $myid = mysqli_query(conn(),"SELECT * FROM user WHERE user_id = $id");
        $thisid = mysqli_fetch_assoc($myid);
        mysqli_query(conn(),"UPDATE user SET username = '$username',
                                             password = '$password',
                                             email = '$email',
                                             nama_lengkap = '$namalengkap',
                                             alamat = '$alamat'
                                             WHERE user_id = $id");
        header('location:settings.php');
    }
}
function delete(){
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        mysqli_query(conn(),"DELETE FROM user WHERE user_id = $id");
        header('location:login.php');
    }
}
delete();
edit();
?>