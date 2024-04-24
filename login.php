<?php
require 'loginRegister.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujikom | Login</title>
</head>
<body>
    <style>
    .login{
        width:500px;
        height:420px;
        border:1px solid black;
    }
    input{
        width:400px;
        height:40px;
        margin-top:50px;
        font-size:25px;
    }
    p{
        font-size:20px;
        text-align:left;
        margin-left:50px;
    }
    button{
        width:400px;
        height:40px;
        font-size:20px;
    }
    </style>
    <center>
    <h1>FarhanAlbum</h1>
    <div class="login">
    <h1>Login Album</h1>
    <form action="" method="post">
    <input type="email" name="email" placeholder="Masukan Email">
    <input type="password" placeholder="Masukan Password" name="password">
    <p>Belum Punya Akun ? <a href="register.php">Register</a> Sekarang</p>
    <button type="submit" name="login">Login</button>
    </form>
    </div>
    </center>
</body>
</html>