<?php
require 'indexAction.php';
?>
<!DOCTYPE html>
<html lang="en" class="bg-neutral-content">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
<div class="drawer lg:drawer-open">
  <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
  <div class="drawer-content flex flex-col items-center justify-center">
    <!-- Page content here -->

  
  </div> 
  <div class="drawer-side">
    <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label> 
    <ul class="menu p-4 w-80 min-h-full bg-base-200 text-base-content">
    <?php 
    if(isset($_GET['komenid'])){
      $komenid = $_GET['komenid'];
    $globalkomen = mysqli_query(conn(),"SELECT foto.foto_id,
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
        $name = mysqli_fetch_assoc($globalUsername);?>
      <li><a><?= $name['username']?></a></li>
      <input type="text">
      <?php endwhile; }?>
    </ul>
  
  </div>
</div>

    <!-- navbar -->
<div class="navbar bg-base-200">
  <div class="drawer">
  <input id="my-drawer" type="checkbox" class="drawer-toggle" />
  <div class="drawer-content flex-1">
    <label for="my-drawer" class="btn btn-ghost text-xl drawer-button invisible md:visible"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 h-5 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg></label>
    <label class="btn btn-ghost text-xl drawer-button invisible md:visible">FarhanAlbum</label>
  </div> 
  <div class="drawer-side">
    <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
    <ul class="menu p-4 w-[60%] md:w-[30%] min-h-full bg-base-200 text-base-content fixed">
      <!-- Sidebar content here -->
      <li><a href="index.php">Home</a></li>
      <?php if(isset($_SESSION['userid'])){?>
      <li><a href="album.php">Album</a></li>
      <li><a href="settings.php">Profile</a></li>
      <li><a href="logout.php">Logout</a></a></li>
      <?php } else{?>
      <li><a href="login.php">Login</a></li>
      <li><a href="register.php">Register</a></li>
      <?php }?>
    </ul>
  </div>
</div>
    <div class="dropdown dropdown-end">
      <div tabindex="0" role="button" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img alt="Tailwind CSS Navbar component" src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" />
        </div>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
        <li>
          <a class="justify-between">
            Profile
          </a>
        </li>
        <?php $globaluser = mysqli_query(conn(),"SELECT * FROM user"); 
        while($user = mysqli_fetch_array($globaluser)):?>
        <li><a><?= $user['username']?></a></li>
        <?php endwhile;?>
      </ul>
    </div>
  </div>
</div>
<!-- endnavbar -->


<center>
  <div class="mt-8">
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

<!-- Konten -->
    <div class="card w-[300px] md:w-[400px] lg:w-[500px] xl-[700px] bg-base-100 shadow-xl p-2">
    <div class="card-actions">
        <img class="w-10 rounded-full" alt="Tailwind CSS Navbar component" src="https://daisyui.com/images/stock/photo-1534528741775-53994a69daeb.jpg" /> 
        <p class="mt-2"><?= $data['username']?></p> 
        <p class="mt-2"><?= $data['tanggal_unggah']?></p> 
    </div>
  <figure><img class="mt-2 w-full h-[200px] md:h-[350px] lg:h-[400px]" src="image/<?= $data['lokasi_file']?>" alt="Shoes" /></figure>
  <div class="inline-block mt-2">
  <form action="" id="form" method="post">
    <input type="hidden" name="fotoid" value="<?= $data['foto_id'] ?>">
  <?php
          if(isset($_SESSION['userid'])){
          $userlike = $_SESSION['userid'];
          $condlike = mysqli_query(conn(),"SELECT * FROM like_foto WHERE user_id = $userlike AND foto_id = $action");
          if(mysqli_num_rows($condlike) == 0){
        ?>
  <button name="like" class="btn btn-xs sm:btn-sm md:btn-md lg:btn-lg">Like Foto</button>
  <?php }else if(mysqli_num_rows($condlike) == 1){?>
    <button name="deletelike" class="btn btn-xs sm:btn-sm md:btn-md lg:btn-lg">Like Foto</button>
  <?php }}?>
  </form>
  
  </div>
    <h2 class="text-left mt-3">Title : <?= $data['judul_foto']?></h2>
    <p class="text-left mt-3">Deskription : <?= $data['deskripsi_foto']?></p>
    <p class="text-left mt-3">Jumlah Like : <?= $likeView['totalLike']?> Likes</p>
    <p class="text-left mt-3 mb-3">Jumlah Komentar : <?= $likeView['totalLike']?> Likes</p>
</div>
<br>
<?php endwhile;?>
</div>



<!-- Navbar bawah -->
<div class="btm-nav visible md:invisible">
  <button class="bg-pink-200 text-pink-600">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
    <a href="{{route('index')}}"><span class="btm-nav-label">Home</span></a>
  </button>
  <?php if(isset($_SESSION['userid'])){?>
  <button class="active bg-blue-200 text-blue-600 border-blue-600">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
    <a href="album.php"><span class="btm-nav-label">Album</span></a>
  </button>
  <button class="bg-teal-200 text-teal-600">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
    <span class="btm-nav-label">Profile</span>
  </button>
  <button class="bg-teal-200 text-teal-600">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
    <a href="logout.php"><span class="btm-nav-label">Logout</span></a>
  </button>
  <?php }else{?>
  <button class="bg-teal-200 text-teal-600">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
    <a href="login.php"><span class="btm-nav-label">Login</span></a>
  </button>
  <?php }?>
<!-- end navbar bawah -->

</body>
</html>