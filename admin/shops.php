<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_shop'])){

   $shopid = $_POST['shopid'];
   $shopid = filter_var($shopid, FILTER_SANITIZE_STRING);
   $shopname = $_POST['shopname'];
   $shopname = filter_var($shopname, FILTER_SANITIZE_STRING);
   $shopdetails = $_POST['shopdetails'];
   $shopdetails = filter_var($shopdetails, FILTER_SANITIZE_STRING);

   $image_01 = $_FILES['image_01']['name'];
   $image_01 = filter_var($image_01, FILTER_SANITIZE_STRING);
   $image_size_01 = $_FILES['image_01']['size'];
   $image_tmp_name_01 = $_FILES['image_01']['tmp_name'];
   $image_folder_01 = '../uploaded_img/'.$image_01;

   $image_02 = $_FILES['image_02']['name'];
   $image_02 = filter_var($image_02, FILTER_SANITIZE_STRING);
   $image_size_02 = $_FILES['image_02']['size'];
   $image_tmp_name_02 = $_FILES['image_02']['tmp_name'];
   $image_folder_02 = '../uploaded_img/'.$image_02;

   $image_03 = $_FILES['image_03']['name'];
   $image_03 = filter_var($image_03, FILTER_SANITIZE_STRING);
   $image_size_03 = $_FILES['image_03']['size'];
   $image_tmp_name_03 = $_FILES['image_03']['tmp_name'];
   $image_folder_03 = '../uploaded_img/'.$image_03;

   $select_shops = $conn->prepare("SELECT * FROM `shops` WHERE shopname = ?");
   $select_shops->execute([$shopname]);

   if($select_shops->rowCount() > 0){
      $message[] = 'shop name already exist!';
   }else{

      $insert_shop = $conn->prepare("INSERT INTO `shops`(shopid, shopname, shopdetails, image_01, image_02, image_03) VALUES(?,?,?,?,?,?)");
      $insert_shop->execute([$shopid, $shopname, $shopdetails, $image_01, $image_02, $image_03]);

      if($insert_shop){
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'new shop added!';
         }

      }

   }  

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_shop_image = $conn->prepare("SELECT * FROM `shops` WHERE shopid = ?");
   $delete_shop_image->execute([$delete_id]);
   $fetch_delete_image = $delete_shop_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
   $delete_shop = $conn->prepare("DELETE FROM `shops` WHERE shopid = ?");
   $delete_shop->execute([$delete_id]);
   header('location:shops.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shops</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">add shops</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>shop id (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter shop id" name="shopid">
         </div>
         <div class="inputBox">
            <span>shop name (required)</span>
            <input type="text" class="box" required max="100" placeholder="enter shop name" name="shopname">
         </div>
        <div class="inputBox">
            <span>image 01 (required)</span>
            <input type="file" name="image_01" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>image 02 (required)</span>
            <input type="file" name="image_02" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
        <div class="inputBox">
            <span>image 03 (required)</span>
            <input type="file" name="image_03" accept="image/jpg, image/jpeg, image/png, image/webp" class="box" required>
        </div>
         <div class="inputBox">
            <span>shop category (required)</span>
            <textarea name="shopdetails" placeholder="enter shop category" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
      </div>
      
      <input type="submit" value="add shop" class="btn" name="add_shop">
   </form>

</section>

<section class="show-products">

   <h1 class="heading">shop added</h1>

   <div class="box-container">

   <?php
      $select_shops = $conn->prepare("SELECT * FROM `shops`");
      $select_shops->execute();
      if($select_shops->rowCount() > 0){
         while($fetch_shops = $select_shops->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_shops['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_shops['shopid']; ?></div>
      <div class="name"><span><?= $fetch_shops['shopname']; ?></span></div>
      <div class="price"><span><?= $fetch_shops['shopdetails']; ?></span></div>
      <div class="flex-btn">
         <a href="update_shop.php?update=<?= $fetch_shops['shopid']; ?>" class="option-btn">update</a>
         <a href="shops.php?delete=<?= $fetch_shops['shopid']; ?>" class="delete-btn" onclick="return confirm('delete this shop?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no shops added yet!</p>';
      }
   ?>
   
   </div>

</section>








<script src="../js/admin_script.js"></script>
   
</body>
</html>

