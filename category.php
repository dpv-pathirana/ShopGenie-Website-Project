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
   <title>Category</title>
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<section class="products">

   <h1 class="heading">category</h1>

   <div class="box-container">

   <?php
     $category = $_GET['category'];
     $select_shops = $conn->prepare("SELECT * FROM `shops` WHERE shopdetails LIKE '%{$category}%'"); 
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
   ?>

   </div>

</section>













<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>