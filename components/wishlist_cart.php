<?php


if(isset($_POST['add_to_cart'])){

   if($user_id == ''){
      header('location:user_login.php');
   }else{

      $productid = $_POST['productid'];
      $productid = filter_var($productid, FILTER_SANITIZE_STRING);
      $productname = $_POST['productname'];
      $productname = filter_var($productname, FILTER_SANITIZE_STRING);
      $productprice = $_POST['productprice'];
      $productprice = filter_var($productprice, FILTER_SANITIZE_STRING);
      $image = $_POST['image'];
      $image = filter_var($image, FILTER_SANITIZE_STRING);
      $qty = $_POST['qty'];
      $qty = filter_var($qty, FILTER_SANITIZE_STRING);

      $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE productname = ? AND user_id = ?");
      $check_cart_numbers->execute([$productname, $user_id]);

      if($check_cart_numbers->rowCount() > 0){
         $message[] = 'already added to cart!';
      }else{

         $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, productid, productname, productprice, quantity, image) VALUES(?,?,?,?,?,?)");
         $insert_cart->execute([$user_id, $productid, $productname, $productprice, $qty, $image]);
         $message[] = 'added to cart!';
         
      }

   }

}

?>