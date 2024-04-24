<?php
require 'loginRegister.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujikom | Register</title>
</head>
<body>
<style>
    .register{
        width:500px;
        height:930px;
        border:1px solid black;
    }
    input{
        width:400px;
        height:40px;
        margin-top:50px;
        font-size:25px;
    }
    textarea{
        width:400px;
        height:180px;
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
    <div class="register">
    <h1>Register Album</h1>
    <form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="username" placeholder="Username"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="email" name="email" placeholder="Email"><br>
    <input type="text" name="namalengkap" placeholder="Full Name"><br>
    <textarea name="alamat" id="" cols="30" rows="10">Alamat</textarea><br>
    <p>Sudah Memiliki Akun ? <a href="login.php">Login</a> Sekarang</p>
    <button type="submit" name="register">Register</button>
    </form>
    </div>
    </center>
</body>
</html>