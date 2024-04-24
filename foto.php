<?php 
require 'fotoFun.php';
if(!isset($_SESSION['userid'])){
    header('location:login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujikom | Albums</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<style>
.fotoprofile{
    width:200px;
    height:200px;
    border-radius:100%;
}
.album{
    width:750px;
    height:100vh;
    margin-left:350px;
}
th{
    font-size:25px;
}
td{
    text-align:center;
    font-size:20px;
}
.profile{
    border:1px solid gray;
    padding-top: 50px;
    padding-bottom: 50px;
}
.albumfoto{
    margin:10px;
    width:200px;
    height:200px;
}
.foto{
    border:1px solid gray;
    width:660px;
    display:flex;
    justify-content:flex-start;
    flex-wrap:wrap;
}
.form{
    width:660px;
    border:1px solid gray;
    padding-top: 30px;
    padding-bottom: 30px;
}
input{
    width:460px;
    height:40px;
    font-size:20px;
}
textarea{
    width:460px;
    height:350px;
    font-size:20px;
}
button{
    width:460px;
    height:30px;
    font-size:20px;
}
.navbar{
 width:350px;
 border:1px solid gray;
 display:inline-block;
 position:fixed;
 font-size:50px;
 height:100vh;
}
.navbar a{
 color:black;
 text-decoration:none;
}
#updateButton{
    width:230px;
    height:30px;
    font-size:20px;
}
#deleteButton{
    width:230px;
    height:30px;
    font-size:20px;
}
#addButton{
    width:230px;
    height:30px;
    font-size:20px;
}
#redirectButton{
    width:230px;
    height:30px;
    font-size:20px;
}
#userimage{
    width:70px;
    height:70px;
    border-radius:100%;
    margin-left:20px;
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
            <th><a style="text-decoration:none;color:black;" href="?otherid=<?= $user['user_id']?>"><ul style="font-size:30px;"><?= $user['username'];?> </ul></a></th>
        </tr>
        </table>
        <?php endwhile;?>
        </div>
    <?php
    (isset($_GET['otherid'])) ? $thisUser = $_GET['otherid'] : $thisUser = $_SESSION['userid']; 
    $viewPhoto = mysqli_query(conn(),"SELECT * FROM foto WHERE user_id = '$thisUser'");
    $totalPhoto = mysqli_query(conn(),"SELECT count(*) as fotoCount FROM foto WHERE user_id = '$thisUser'");
    $totalLike = mysqli_query(conn(),"SELECT count(*) as likeCount FROM like_foto WHERE user_id = '$thisUser'");
    $like= mysqli_fetch_assoc($totalLike);
    $photo= mysqli_fetch_assoc($totalPhoto);
    $viewUser = mysqli_query(conn(),"SELECT * FROM user WHERE user_id = '$thisUser'");
    while($profile = mysqli_fetch_array($viewUser)){
    ?>
    <div class="album">
    <center>
    <div class="profile">
    <img class="fotoprofile" src="userimage/Stock (9).jpg" alt="" srcset="">
    <h1><?= $profile['username']?></h1>
    <table>
        <?php if(isset($_GET['otherid'])){?>
        <tr>
            <th>Total Photos</th>
            <th></th>
            <th>Total Likes</th>
        </tr>
        <?php }else{?>
            <tr>
            <th>Your Photos</th>
            <th></th>
            <th>Your Likes</th>
        </tr>
        <?php }?>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td><?= $photo['fotoCount']?> Photos</td>
            <td></td>
            <td><?= $like['likeCount']?> Likes</td>
        </tr>
    </table><br><br>
    <?php }?>
    <h1>Albums</h1>
    <br>
    <div class="foto">
    <?php if($photo['fotoCount'] == 0) {?>
        <h1 style="margin-left:230px;">Photo Is Empty</h1>
    <?php }else{?>
    <?php while($album = mysqli_fetch_array($viewPhoto)): ?>
        <a href="?updateid=<?= $album["foto_id"] ?>"><img class="albumfoto" src="image/<?= $album['lokasi_file']?>" alt="" srcset=""></a>
    <?php endwhile; }?>
    </div>
    <?php 
    if(!isset($_GET['otherid'])){
    if(isset($_GET['updateid'])) {?>
    <h1>Update Photo</h1><br>
    <?php } else{?>
    <h1>Add Photo</h1><br>
    <?php } ?>
    <div class="form">
    <?php if(isset($_GET['updateid'])) {
    $fotoid = $_GET['updateid'];
    $_SESSION['fotoid'] = $fotoid;
    $update = mysqli_query(conn(),"SELECT * FROM foto WHERE foto_id = '$fotoid'");
    while($mydata = mysqli_fetch_array($update)):
     ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" value="<?= $mydata['foto_id'] ?>" name="fotoid">
        <input type="file" value="<?= $mydata['lokasi_file'] ?>" name="foto" id=""><br><br>
        <input type="text" value="<?= $mydata['judul_foto'] ?>" name="judulfoto" placeholder="Judul Foto"><br><br>
        <textarea name="deskripsifoto" id="" cols="30" rows="10"><?= $mydata['deskripsi_foto'] ?></textarea><br><br>
        <button type="submit" name="deleteButton" id="deleteButton">Hapus Foto</button></a>
        <button type="submit" id="updateButton" name="updateFoto">Update Foto</button><br><br>
        <button name="backFoto">Kembali</button>
    </form>
    <?php endwhile; } else { ?>
        <form action="" method="post" enctype="multipart/form-data">
        <input type="file"  name="foto" id=""><br><br>
        <input type="text" name="judulfoto" placeholder="Judul Foto"><br><br>
        <textarea name="deskripsifoto" id="" cols="30" rows="10">Deskripsi Foto</textarea><br><br>
        <button type="submit" id="redirectButton" name="redirectFoto">Kembali</button>
        <button type="submit" id="addButton" name="tambahFoto">Tambah Foto</button>
    </form>
    <?php }}?>
    </div>
    </div>
    </center>
    </div>
</body>
</html>