<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
};

if(isset($_POST['add_product'])){

   $productid = $_POST['productid'];
   $productid = filter_var($productid, FILTER_SANITIZE_STRING);
   $shopid = $_POST['shopid'];
   $shopid = filter_var($shopid, FILTER_SANITIZE_STRING);
   $productname = $_POST['productname'];
   $productname = filter_var($productname, FILTER_SANITIZE_STRING);
   $productprice = $_POST['productprice'];
   $productprice = filter_var($productprice, FILTER_SANITIZE_STRING);
   $productdetails = $_POST['productdetails'];
   $productdetails = filter_var($productdetails, FILTER_SANITIZE_STRING);

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

   $select_products = $conn->prepare("SELECT * FROM `products` WHERE productname = ?");
   $select_products->execute([$productname]);

   if($select_products->rowCount() > 0){
      $message[] = 'product name already exist!';
   }else{

      $insert_products = $conn->prepare("INSERT INTO `products`(productid, shopid, productname, productdetails, productprice, image_01, image_02, image_03) VALUES(?,?,?,?,?,?,?,?)");
      $insert_products->execute([$productid, $shopid, $productname, $productdetails, $productprice, $image_01, $image_02, $image_03]);

      if($insert_products){
         if($image_size_01 > 2000000 OR $image_size_02 > 2000000 OR $image_size_03 > 2000000){
            $message[] = 'image size is too large!';
         }else{
            move_uploaded_file($image_tmp_name_01, $image_folder_01);
            move_uploaded_file($image_tmp_name_02, $image_folder_02);
            move_uploaded_file($image_tmp_name_03, $image_folder_03);
            $message[] = 'new product added!';
         }

      }

   }  

};

if(isset($_GET['delete'])){

   $delete_id = $_GET['delete'];
   $delete_product_image = $conn->prepare("SELECT * FROM `products` WHERE productid = ?");
   $delete_product_image->execute([$delete_id]);
   $fetch_delete_image = $delete_product_image->fetch(PDO::FETCH_ASSOC);
   unlink('../uploaded_img/'.$fetch_delete_image['image_01']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_02']);
   unlink('../uploaded_img/'.$fetch_delete_image['image_03']);
   $delete_product = $conn->prepare("DELETE FROM `products` WHERE productid = ?");
   $delete_product->execute([$delete_id]);
   $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE productid = ?");
   $delete_cart->execute([$delete_id]);
   header('location:products.php');
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Products</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="add-products">

   <h1 class="heading">add product</h1>

   <form action="" method="post" enctype="multipart/form-data">
      <div class="flex">
         <div class="inputBox">
            <span>product id (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product id" name="productid">
         </div>
         <div class="inputBox">
            <span>shop id (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter shop id" name="shopid">
         </div>
         <div class="inputBox">
            <span>product name (required)</span>
            <input type="text" class="box" required maxlength="100" placeholder="enter product name" name="productname">
         </div>
         <div class="inputBox">
            <span>product price (required)</span>
            <input type="number" min="0" class="box" required max="9999999999" placeholder="enter product price" onkeypress="if(this.value.length == 10) return false;" name="productprice">
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
            <span>product details (required)</span>
            <textarea name="productdetails" placeholder="enter product details" class="box" required maxlength="500" cols="30" rows="10"></textarea>
         </div>
      </div>
      
      <input type="submit" value="add product" class="btn" name="add_product">
   </form>

</section>

<section class="show-products">

   <h1 class="heading">products added</h1>

   <div class="box-container">

   <?php
      $select_products = $conn->prepare("SELECT * FROM `products`");
      $select_products->execute();
      if($select_products->rowCount() > 0){
         while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){ 
   ?>
   <div class="box">
      <img src="../uploaded_img/<?= $fetch_products['image_01']; ?>" alt="">
      <div class="name"><?= $fetch_products['productname']; ?></div>
      <div class="price">$<span><?= $fetch_products['productprice']; ?></span>/-</div>
      <div class="details"><span><?= $fetch_products['productdetails']; ?></span></div>
      <div class="flex-btn">
         <a href="update_product.php?update=<?= $fetch_products['productid']; ?>" class="option-btn">update</a>
         <a href="products.php?delete=<?= $fetch_products['productid']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
   </div>
   <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
   ?>
   
   </div>

</section>








<script src="../js/admin_script.js"></script>
   
</body>
</html>