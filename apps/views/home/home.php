<title>Home</title>
<link rel="stylesheet" href='/public/styles/home/home.css'>

<main>
   <?php
      include $_SERVER['DOCUMENT_ROOT'] . '/components/navbar/navbar.php';
   ?>

   <div class="banner">
      <div class="left">
         <h2>Take Better Care of <span>Your Dog.</span></h2>
         <p>Discover tail-wagging fashion and purr-fect style for your best friend 
            through our online shopping. Explore a great selection of clothes, 
            cozy beds, playful toys, stylish collars, and more!</p>
         <button>Shop Now</button>
      </div>

      <div class="right">
         <img src="/public/assets/img/dogs/dogs.png">
      </div>
   </div>

   <div id="productContainer">
      <h1>Products</h1>

      <div id="products"></div>
   </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="/public/js/home.js"></script>