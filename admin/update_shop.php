<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

if(isset($_POST['update'])){

   $shopid = $_POST['shopid'];
   $shopname = $_POST['shopname'];
   $shopname = filter_var($shopname, FILTER_SANITIZE_STRING);
   $shopdetails = $_POST['shopdetails'];
   $shopdetails = filter_var($shopdetails, FILTER_SANITIZE_STRING);

   $update_shop = $conn->prepare("UPDATE `shops` SET shopname = ?, shopdetails = ? WHERE shopid = ?");
   $update_shop->execute([$shopname, $shopdetails, $shopid]);

   $message[] = 'shop updated successfully!';

   $old_image_01 = $_POST['old_image_01'];
   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   if(!empty($image_01)){
      if($image_size_01 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_01 = $conn->prepare("UPDATE `shops` SET image_01 = ? WHERE shopid = ?");
         $update_image_01->execute([$image_01, $shopid]);
         move_uploaded_file($image_tmp_name_01, $image_folder_01);
         unlink('../uploaded_img/'.$old_image_01);
         $message[] = 'image 01 updated successfully!';
      }
   }

   $old_image_02 = $_POST['old_image_02'];
   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   if(!empty($image_02)){
      if($image_size_02 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_02 = $conn->prepare("UPDATE `shops` SET image_02 = ? WHERE shopid = ?");
         $update_image_02->execute([$image_02, $shopid]);
         move_uploaded_file($image_tmp_name_02, $image_folder_02);
         unlink('../uploaded_img/'.$old_image_02);
         $message[] = 'image 02 updated successfully!';
      }
   }

   $old_image_03 = $_POST['old_image_03'];
   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   if(!empty($image_03)){
      if($image_size_03 > 2000000){
         $message[] = 'image size is too large!';
      }else{
         $update_image_03 = $conn->prepare("UPDATE `shops` SET image_03 = ? WHERE shopid = ?");
         $update_image_03->execute([$image_03, $shopid]);
         move_uploaded_file($image_tmp_name_03, $image_folder_03);
         unlink('../uploaded_img/'.$old_image_03);
         $message[] = 'image 03 updated successfully!';
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Update shops</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="update-product">

   <h1 class="heading">update shop</h1>

   <?php
      $update_id = $_GET['update'];
      $select_shop = $conn->prepare("SELECT * FROM `shops` WHERE shopid = ?");
      $select_shop->execute([$update_id]);
      if($select_shop->rowCount() > 0){
         while($fetch_shop = $select_shop->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="shopid" value="<?= $fetch_shop['shopid']; ?>">
      <input type="hidden" name="old_image_01" value="<?= $fetch_shop['image_01']; ?>">
      <input type="hidden" name="old_image_02" value="<?= $fetch_shop['image_02']; ?>">
      <input type="hidden" name="old_image_03" value="<?= $fetch_shop['image_03']; ?>">
      <div class="image-container">
         <div class="main-image">
            <img src="../uploaded_img/<?= $fetch_shop['image_01']; ?>" alt="">
         </div>
         <div class="sub-image">
            <img src="../uploaded_img/<?= $fetch_shop['image_01']; ?>" alt="">
            <img src="../uploaded_img/<?= $fetch_shop['image_02']; ?>" alt="">
            <img src="../uploaded_img/<?= $fetch_shop['image_03']; ?>" alt="">
         </div>
      </div>
      <span>update name</span>
      <input type="text" name="shopname" required class="box" maxlength="100" placeholder="enter shop name" value="<?= $fetch_shop['shopname']; ?>">
      <span>update details</span>
      <textarea name="shopdetails" class="box" required cols="30" rows="10"><?= $fetch_shop['shopdetails']; ?></textarea>
      <span>update image 01</span>
      <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <span>update image 02</span>
      <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <span>update image 03</span>
      <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box">
      <div class="flex-btn">
         <input type="submit" name="update" class="btn" value="update">
         <a href="shops.php" class="option-btn">go back</a>
      </div>
   </form>
   
   <?php
         }
      }else{
         echo '<p class="empty">no shops found!</p>';
      }
   ?>

</section>












<script src="../js/admin_script.js"></script>
   
</body>
</html>