<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <link rel="shortcut icon" type="x-icon" href="images/icon.png">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>ShopGenie</title>

   <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
   
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css?v=2">

</head>
<body>
   
<?php include 'components/user_header.php'; ?>

<img class="home-bg" width="1920" height="600">

<section class="category">

   <h1 class="heading">shop by category</h1>

   <div class="swiper category-slider">

   <div class="swiper-wrapper">

   <a href="category.php?category=Apparel" class="swiper-slide slide">
      <img src="images/apparel_and_accessories.png" alt="">
      <h3>Apparel</h3>
   </a>

   <a href="category.php?category=Electronics" class="swiper-slide slide">
      <img src="images/consumer_electronics.png" alt="">
      <h3>Electronics</h3>
   </a>

   <a href="category.php?category=Health & Beauty" class="swiper-slide slide">
      <img src="images/health_personal_care_and_beauty.png" alt="">
      <h3>Health & Beauty</h3>
   </a>

   <a href="category.php?category=Food & Beverage" class="swiper-slide slide">
      <img src="images/food_and_beverage.png" alt="">
      <h3>Food & Beverage</h3>
   </a>

   <a href="category.php?category=Furniture" class="swiper-slide slide">
      <img src="images/house_decoration.png" alt="">
      <h3>Furniture</h3>

   </a>
      <a href="category.php?category=Auto & Parts" class="swiper-slide slide">
      <img src="images/auto_and_parts.png" alt="">
      <h3>Auto & Parts</h3>
   </a>

   </div>

   <div class="swiper-pagination"></div>

   </div>

</section>



<?php include 'components/footer.php'; ?>

<script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>

<script src="js/script.js"></script>

<script>

var swiper = new Swiper(".home-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
    },
});

 var swiper = new Swiper(".category-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      0: {
         slidesPerView: 2,
       },
      650: {
        slidesPerView: 3,
      },
      768: {
        slidesPerView: 4,
      },
      1024: {
        slidesPerView: 5,
      },
   },
});

var swiper = new Swiper(".products-slider", {
   loop:true,
   spaceBetween: 20,
   pagination: {
      el: ".swiper-pagination",
      clickable:true,
   },
   breakpoints: {
      550: {
        slidesPerView: 2,
      },
      768: {
        slidesPerView: 2,
      },
      1024: {
        slidesPerView: 3,
      },
   },
});

</script>

</body>
</html>