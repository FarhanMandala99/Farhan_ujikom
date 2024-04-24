<?php
require 'dbConnect.php';
session_start();

function addFoto(){
    if(isset($_POST['tambahFoto']) && isset($_SESSION['userid'])){
        $judulfoto = $_POST['judulfoto'];
        $deskripsifoto = $_POST['deskripsifoto'];
        $tanggalunggah = date('Y-m-d');
        $userid = intval($_SESSION['userid']); 
        $foto = date("Y-m-d") .time() . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'],'image/'. $foto);
        mysqli_query(conn(),"INSERT INTO foto VALUES('','$judulfoto','$deskripsifoto','$tanggalunggah','$foto','$userid')");
        header('location:foto.php');
      }
}
function deletefoto(){
    if(isset($_POST['deleteButton'])){
        $id = $_POST['fotoid'];
        $view = mysqli_query(conn(),"SELECT * FROM foto WHERE foto_id = '$id'");
        $data = mysqli_fetch_assoc($view);
        unlink('image/'.$data['lokasi_file']);
        mysqli_query(conn(),"DELETE FROM foto WHERE foto_id = '$id'");
        header('location:foto.php');
    }
}
function updateFoto(){
    if(isset($_POST['updateFoto']) && isset($_SESSION['userid'])){
        $judulfoto = $_POST['judulfoto'];
        $deskripsifoto = $_POST['deskripsifoto'];
        $fotoid = $_SESSION['fotoid'];
        $updatefoto = mysqli_query(conn(),"SELECT * FROM foto WHERE foto_id = '$fotoid'");
        $data = mysqli_fetch_assoc($updatefoto);
        unlink('image/'.$data['lokasi_file']);
        $foto = date("Y-m-d") .time() . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'],'image/'. $foto);
        mysqli_query(conn(),"UPDATE foto SET judul_foto = '$judulfoto',
                                             deskripsi_foto = '$deskripsifoto',
                                             lokasi_file = '$foto'
                                             WHERE foto_id = $fotoid");
        header('location:foto.php');
      }
}
function backFoto(){
    if(isset($_POST['backFoto'])){
        header('location:foto.php');
    }else if(isset($_POST['redirectFoto'])){
        header('location:index.php');
    }
}
addFoto();
deleteFoto();
updateFoto();
backFoto();

?>