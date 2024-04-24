<?php
require 'settingsFun.php';
if(!isset($_SESSION['userid'])){
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujikom | Settings</title>
</head>
<body>
<style>
.navbar a{
 color:black;
 text-decoration:none;
}
#userimage{
    width:70px;
    height:70px;
    border-radius:100%;
    margin-left:20px;
}
.navbar{
 width:350px;
 border:1px solid gray;
 display:inline-block;
 position:fixed;
 font-size:50px;
 height:100vh;
}
.userSection{
 width:360px;
 border:1px solid gray;
 height:100vh;
 margin-left:1100px;
 display:block;
 position:fixed;
 overflow:scroll;
}
.profil{
        width:500px;
        height:auto;
        border:1px solid black;
        padding-bottom:30px;
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
        width:200px;
        height:40px;
        font-size:20px;
        display:inline-block;
        color:white;
        border:none;
}
</style>
<div class="navbar">
            <ul>FarhanAlbum</ul>
            <a href="index.php"><ul>Home</ul></a>
            <a href="foto.php"><ul>Albums</ul></a>
            <a href="settings.php"><ul>Settings</ul></a>
            <a href="logout.php"><ul>Logout</ul></a>
</div>
<div class="userSection">
        <h1 style="margin-left:20px;margin-bottom:50px;">Global User</h1>
        <?php $globaluser = mysqli_query(conn(),"SELECT * FROM user"); 
        while($user = mysqli_fetch_array($globaluser)):?>
        <table>
        <tr>
            <th><a href="?otherid=<?= $user['user_id']?>"></a><img id="userimage" src="userimage/Stock (9).jpg"alt="" srcset=""></th>
            <th><a style="text-decoration:none;color:black;" href="foto.php?otherid=<?= $user['user_id']?>"><ul style="font-size:30px;"><?= $user['username'];?> </ul></a></th>
        </tr>
        </table>
        <?php endwhile;?>
        </div>
        <center>
    <div class="profil">
    <?php 
    $userid = $_SESSION['userid'];
    $user = mysqli_query(conn(),"SELECT * FROM user WHERE user_id = $userid");
    $userEdit = mysqli_query(conn(),"SELECT * FROM user WHERE user_id = $userid");
    $userProfile = mysqli_query(conn(),"SELECT * FROM user WHERE user_id = $userid");
    $userAction = mysqli_query(conn(),"SELECT * FROM user WHERE user_id = $userid");
    while($fotoprofile = mysqli_fetch_array($user)):
    ?>
    <img style="width:200px;height:200px;border-radius:100%;margin-top:20px;border:3px solid purple;" src="userimage/Stock (9).jpg" alt="" srcset="">
    <?php endwhile;?>
    <br><br><br>
    <?php while($profileAction = mysqli_fetch_array($userAction)){?>
    <a href="?delete=<?= $profileAction['user_id']?>"><button name="delete" style="background-color:red;">Delete</button></a>
    <a href="?edit=<?= $profileAction['user_id']?>"><button name="edit"  style="background-color:blue;">Edit</button></a>
    <?php }?>
    <?php 
    if(!isset($_GET['edit'])){
    while($profile = mysqli_fetch_array($userProfile)){?>
    <input type="text" value="<?= $profile['username']?>" readonly><br>
    <input type="text" value="<?= $profile['nama_lengkap']?>" readonly><br>
    <input type="text" value="<?= $profile['email']?>" readonly><br>
    <textarea name="alamat" id="" cols="30" rows="10" readonly><?= $profile['alamat']?></textarea><br>
    <?php }}else{?>
    <form action="" method="post" enctype="multipart/form-data">
    <?php while($profileEdit = mysqli_fetch_array($userEdit)){?>
    <input type="hidden" name="id" value="<?= $profileEdit['user_id']?>"><br>
    <input type="text" name="username" value="<?= $profileEdit['username']?>"><br>
    <input type="text" name="password" value="<?= $profileEdit['password']?>"><br>
    <input type="text" name="namalengkap"  value="<?= $profileEdit['nama_lengkap']?>"><br>
    <input type="text" name="email" value="<?= $profileEdit['email']?>"><br>
    <textarea name="alamat" id="" cols="30" rows="10"><?= $profileEdit['alamat']?></textarea><br><br><br>
    <button style="width:200px; height:40px; background-color:red;color:white;" name="cancelButton">Batal</button>
    <button style="width:200px; height:40px; background-color:green;color:white;" name="editButton">Edit</button>
    <?php }}?>
    </form>
    </div>
    </center>
</body>
</html>