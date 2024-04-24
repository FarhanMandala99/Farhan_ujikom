<?php
require 'dbConnect.php';    
session_start();
function like(){
    if(isset($_POST['like'])){
        if(isset($_SESSION['userid'])){
        $date = date("Y-m-d");
        $user = intval($_SESSION['userid']);
        $fotoid = $_POST['fotoid'];
        $check = mysqli_query(conn(),"SELECT * FROM like_foto WHERE user_id = $user AND foto_id = $fotoid");
        if(mysqli_num_rows($check) == 0){
        mysqli_query(conn(),"INSERT INTO like_foto VALUES('','$fotoid','$user','$date')");
        }
    }
}

}
function anonymous(){
    if(isset($_POST['anony'])){
        header('location:login.php');
    }
}
function deletelike(){
    if(isset($_POST['deletelike'])){
        $date = date("Y-m-d");
           $user = intval($_SESSION['userid']);
        $fotoid = $_POST['fotoid'];
        mysqli_query(conn(),"DELETE FROM like_foto WHERE user_id = $user AND foto_id = $fotoid");
    }
}
function comentar(){
    if(isset($_POST['komentar'])){
        $fotoid = $_POST['komenfotoid'];
        $komentar = $_POST['isikomentar'];
        $date = date("Y-m-d");
        $user = intval($_SESSION['userid']);
        mysqli_query(conn(),"INSERT INTO komentar_foto VALUES('','$fotoid','$user','$komentar','$date')");
    }
}
function deletecomentar(){
    if(isset($_GET['deletekomen'])){
        $id = $_GET['deletekomen'];
        mysqli_query(conn(),"DELETE FROM komentar_foto WHERE komentar_id = $id");
    }
}
function updatecomentar(){
    if(isset($_POST['editkomentar'])){
        $id = $_POST['updateid'];
        $komentar = $_POST['isikomentar'];
        mysqli_query(conn(),"UPDATE komentar_foto SET isi_komentar = '$komentar' WHERE komentar_id = $id ");
    }
}
function closeButton(){
    if(isset($_POST['closeButton'])){
        header('location:index.php');
    }
}

like();
deletelike();
comentar();
deletecomentar();
updatecomentar();
closeButton();
anonymous();

?>