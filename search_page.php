<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Search page</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search_box" placeholder="search here..." maxlength="100" class="box" required>
      <button type="submit" class="fas fa-search" name="search_btn"></button>
   </form>
</section>

<section class="products" style="padding-top: 0; min-height:100vh;">

   <div class="box-container">

   <?php
     if(isset($_POST['search_box']) OR isset($_POST['search_btn'])){
     $search_box = $_POST['search_box'];
     $select_shops = $conn->prepare("SELECT * FROM `shops` WHERE shopname LIKE '%{$search_box}%'"); 
     $select_shops->execute();
     if($select_shops->rowCount() > 0){
      while($fetch_shop = $select_shops->fetch(PDO::FETCH_ASSOC)){
   ?>
   <form action="" method="post" class="box">
      <input type="hidden" name="shopid" value="<?= $fetch_shop['shopid']; ?>">
      <input type="hidden" name="shopname" value="<?= $fetch_shop['shopname']; ?>">
      <input type="hidden" name="shopdetails" value="<?= $fetch_shop['shopdetails']; ?>">
      <input type="hidden" name="image" value="<?= $fetch_shop['image_01']; ?>">
      <a href="products.php?shopid=<?= $fetch_shop['shopid']; ?>" class="fas fa-eye"></a>
      <img src="uploaded_img/<?= $fetch_shop['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_shop['shopname']; ?></div>
      <div class="flex">
         <div class="price"><span></span><?= $fetch_shop['shopdetails']; ?><span></span></div>
      </div>
      <a href="products.php?shopid=<?= $fetch_shop['shopid']; ?>" class="btn">SHOP NOW</a>
   </form>
   <?php
         }
      }else{
         echo '<p class="empty">no products found!</p>';
      }
   }
   ?>

   </div>

</section>












<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>