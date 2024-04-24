<?php
require 'indexAction.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujikom | Home</title>

    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <style>
.comment{
 background-image: url('image/komentar.png');
 background-size:contain;
 background-repeat:no-repeat;
 background-position:center;
 background-color:white;
 height:40px;
 width:298px;
 display:inline-block;
}
.deletelike{
 background-image: url('image/like2.png');
 background-size:contain;
 background-repeat:no-repeat;
 background-position:center;
 background-color:gray;
 height:40px;
 width:298px;
 display:inline-block;
}
.like{
 background-image: url('image/like2.png');
 background-size:contain;
 background-repeat:no-repeat;
 background-position:center;
 background-color:white;
 height:40px;
 width:298px;
display:inline-block;
}
#userimage{
    width:70px;
    height:70px;
    border-radius:100%;
    margin-left:20px;
}
.commentSection{
    height:560px;
    margin-left:20px;
    overflow-y:auto;
}
.commentForm{
    margin-top:20px;
    margin-left:20px;
}
.editButton{
 height:30px;
 width:70px;
 display:inline-block;
 background-color:blue;
 color:white;
 border:none;
}



    </style>
    <div>
        <div class="navbar">
            <ul>FarhanAlbum</ul>
            <a href="index.php"><ul>Home</ul></a>
            <?php if(isset($_SESSION['userid'])){?>
            <a href="foto.php"><ul>Albums</ul></a>
            <a href="settings.php"><ul>Settings</ul></a>
            <?php }?>
            <?php
            if(isset($_SESSION['userid'])){
            $loginId = $_SESSION['userid'];
            $loginLogout = mysqli_query(conn(),"SELECT * FROM user WHERE user_id = $loginId");
            $thisLoginid = mysqli_fetch_assoc($loginLogout);
            ?>
            <?php if(isset($loginId) && $loginId == $thisLoginid['user_id'] ){ ?>
            <a href="logout.php"><ul>Logout</ul></a>
            <?php }else{?>
                <a href="login.php"><ul>Login</ul></a>
            <?php }
              }else {?>
            <a href="login.php"><ul>Login</ul></a>
            <?php }?>
        </div>
        <div class="section">
        <?php if(isset($_GET['komen'])){ $komenid = $_GET['komen'];?>
        <div class="commentSection">
        <form action="" method="post">
        <button class="closeComment" name="closeButton">X</button>
        </form>
        <h1 style="margin-bottom:50px;">Commentar</h1>
        <?php $globalkomen = mysqli_query(conn(),"SELECT foto.foto_id,
                                                         komentar_foto.isi_komentar,
                                                         komentar_foto.tanggal_komentar,
                                                         komentar_foto.komentar_id,
                                                         komentar_foto.user_id FROM user INNER JOIN foto ON user.user_id = foto.user_id
                                                                             INNER JOIN komentar_foto ON foto.foto_id = komentar_foto.foto_id
                                                                             WHERE foto.foto_id = $komenid
                                                                             ORDER BY komentar_foto.komentar_id DESC");
        while($komentar = mysqli_fetch_array($globalkomen)):
        $globalname = $komentar['user_id'];
        $globalUsername = mysqli_query(conn(),"SELECT username FROM user WHERE user_id = $globalname");
        $name = mysqli_fetch_assoc($globalUsername);
        ?>
        <p><span style="font-size:20px;"><b><?= $name['username']?></b></span><span style="float:right;margin-right:10px;"><?= $komentar['tanggal_komentar']?></span></p>
        <p style="word-wrap:break-word"><?= $komentar['isi_komentar']?>
        <span style="float:right;margin-right:10px;">
        <?php if(isset($_SESSION['userid']) && $_SESSION['userid'] == $komentar['user_id']){ ?>
            <a style="text-decoration:none;color:black;" href="?deletekomen=<?= $komentar['komentar_id']?>&komen=<?= $komenid?>">Delete</a> 
            <?php if(isset($_GET['editid']) && $komentar['komentar_id'] == $_GET['editid']){?>
             <a style="text-decoration:none;color:black;" href="?komen=<?= $komenid?>">Cancel</a></span></p>
            <?php }else{?>
            <a style="text-decoration:none;color:black;" href="?editid=<?= $komentar['komentar_id']?>&komen=<?= $komenid?>">Edit</a></span></p>
            <?php }?>
        <?php }
            ?>
        </span></p>
        <?php endwhile;?>
        </div>
        <div class="commentForm">
        <form action="" method="post">
        <?php if(isset($_GET['editid'])){
            $editid = $_GET['editid'];
            $editkomen = mysqli_query(conn(),"SELECT * FROM komentar_foto WHERE komentar_id = $editid");
            while($edit = mysqli_fetch_array($editkomen)){
        ?>
        <input type="hidden" value="<?= $edit['komentar_id']; ?>" name="updateid">
        <input type="text" value="<?= $edit['isi_komentar']; ?>" name="isikomentar" placeholder="Edit Komentar " class="commentInput">
        <button class="editButton" name="editkomentar">Edit</button><br><br>
        <?php }?>
        </form>
        <?php }else{?>
        <form action="" method="post">
        <input type="hidden" value="<?= $komenid; ?>" name="komenfotoid">
        <input type="text" name="isikomentar" placeholder="Isi Komentar" class="commentInput">
        <?php if(isset($_SESSION['userid'])){?>
        <button class="commentButton" name="komentar">Kirim</button><br><br>
        <?php }else{?>
            <button class="commentButton" name="anony">Kirim</button><br><br>
            <?php }?>
        <?php }?>
        </div>
        <?php } else {?>

        <div class="userSection">
        <h1 style="margin-left:20px;margin-bottom:50px;">Global User</h1>
        <?php $globaluser = mysqli_query(conn(),"SELECT * FROM user"); 
        while($user = mysqli_fetch_array($globaluser)):?>
        <table>
        <tr>
            <th><a href="foto.php?otherid=<?= $user['user_id']?>"><img id="userimage" src="userimage/Stock (9).jpg"alt="" srcset=""></th></a>
            <th><a style="text-decoration:none;color:black;" href="foto.php?otherid=<?= $user['user_id']?>"><ul style="font-size:30px;"><?= $user['username'];?> </ul></a></th>
        </tr>
        </table>
        <?php endwhile;?>
        </div>

        <?php } ?>
       </div>
    <div>
    <?php 
    $view = mysqli_query(conn(),"SELECT foto.deskripsi_foto,
                                        foto.tanggal_unggah,
                                        foto.judul_foto,
                                        foto.foto_id,
                                        user.username,
                                        foto.user_id,
                                        foto.lokasi_file FROM user INNER JOIN foto ON user.user_id = foto.user_id
                                        ORDER BY foto.foto_id DESC");
    while($data = mysqli_fetch_array($view)):
    $action = $data['foto_id'];
    $likeView = mysqli_fetch_assoc((mysqli_query(conn(),"SELECT count(*) AS totalLike FROM like_foto WHERE foto_id = $action")));
    $commentView = mysqli_fetch_assoc((mysqli_query(conn(),"SELECT count(*) AS totalComment FROM komentar_foto WHERE foto_id = $action")));
    ?>
    <center>
    <div class="content" id="<?= $contentId; ?>">
        <img class="contentImage" src="userimage/Stock (9).jpg" alt="" srcset="">
        <p style="float:left;margin-left:10px;font-size:20px;"><b><?= $data['username']?></b></p>
        <a href=""><img src="image/<?= $data['lokasi_file'] ?>" alt="" style="width:600px;height:500px;margin-top:10px;"></a>

    <form action="" id="form" method="post">
        <input type="hidden" name="fotoid" value="<?= $data['foto_id'] ?>">

        <?php
          if(isset($_SESSION['userid'])){
          $userlike = $_SESSION['userid'];
          $condlike = mysqli_query(conn(),"SELECT * FROM like_foto WHERE user_id = $userlike AND foto_id = $action");
          if(mysqli_num_rows($condlike) == 0){
        ?>

        <button class="like" type="submit" name="like"></button>

        <?php }else if(mysqli_num_rows($condlike) == 1){?>

        <button class="deletelike" type="submit" name="deletelike"></button>

        <?php }}else{?>
            <button class="like" type="submit" name="anony"></button>
            <button class="comment" type="submit" name="anony"></button>
        <?php }?>
        </form>
        <?php
        if(isset($_SESSION['userid'])){
        ?>
        <a style="display:inline-block;" href="?komen=<?= $data['foto_id'] ?>"><button id="comment" class="comment" name="comment"></button></a>
        <?php }?>
        <p style="text-align:left"><b>Title : </b><?= $data['judul_foto']?></p>
        <p style="text-align:left"><b>Deskription : </b><?= $data['deskripsi_foto']?></p>
        <p style="text-align:left"><b>Likes : </b><?= $likeView['totalLike']?> likes</p>
        <p style="text-align:left"><b>Comments : </b><?= $commentView['totalComment']?> comments</p>
        <p style="text-align:left">Tanggal Unggah : <?= $data['tanggal_unggah']?></p>
    </div>
</div>
    </center>
    </div>
    <?php endwhile; ?>
<script>
</script>
</body>
</html>