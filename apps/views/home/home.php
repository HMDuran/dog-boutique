<title>Home</title>
<link rel="stylesheet" href='/public/styles/home/home.css'>

<?php
      include $_SERVER['DOCUMENT_ROOT'] . '/components/navbar/navbar.php';
?>

<main>
   <div class="banner">
      <div class="left">
         <h2>Take Better Care of <span>Your Dog.</span></h2>
         <p>Discover tail-wagging fashion and purr-fect style for your best friend 
            through our online shopping. Explore a great selection of clothes, 
            cozy beds, playful toys, stylish collars, and more!</p>
         <button onclick="location.href='/apps/views/auth/login.php'">
               <img src="/public/assets/img/icons/ion_paw-outline.png" alt="">
               Shop Now
         </button>
      </div>

      <div class="right">
         <img src="/public/assets/img/dogs/dogs.png">
      </div>
   </div>

   <div id="productContainer">
      <h1>Products</h1>
      <div id="product-slider">
            <button id="left-button" class="nav-button"><</button>
            <div id="products-container">
               <div id="products"></div>
            </div>
            <button id="right-button" class="nav-button">></button>
      </div>
   </div>

   <div class="banner-two">
         <img src="/public/assets/img/dogs/dog_2.png" alt="">
      <div class="right-banner">
         <p class="p-one">AFFORDABLE FASHION</p>
         <h2>For our best friend OOTD</h2>
         <p class="p-two">Elevate your furry friend's style with our curated collection of trendy and budget-friendly outfits. 
            From casual chic to special occasions, find the perfect OOTD for your pet. 
            Dress your pet in style and let their personality shine – because fashion isn't just for humans, 
            it's for our best friends too!
         </p>
         <button onclick="location.href='/apps/views/auth/login.php'">
               <img src="/public/assets/img/icons/ion_paw-outline.png" alt="">
               Shop Now
         </button>
      </div>
   </div>

   <div class="banner-three">
      <div class="banner-card">
         <img src="/public/assets/img/dogs/dog_3.png" alt="">
         <div class="card-right">
            <h4>High Quality Products</h4>
            <p>We are dedicated to sourcing and offering only the highest quality products, 
               ensuring the well-being, safety, and happiness of every pet.</p>
         </div>
      </div>
      <div class="banner-card">
         <img src="/public/assets/img/dogs/dog_4.png" alt="">
         <div class="card-right">
            <h4>Affordability</h4>
            <p>We carefully curate budget-friendly options without compromising excellence, 
               so every tail wags with joy without burdening your budget.</p>
         </div>
      </div>
      <div class="banner-card">
         <img src="/public/assets/img/dogs/dog_5.png" alt="">
         <div class="card-right">
            <h4>Distinctive Variety</h4>
            <p>We pride ourselves on offering a distinctive variety, 
               ensuring you'll find unique and specialized items that 
               cater to every aspect of your pet's happiness and well-being.</p>
         </div>
      </div>
   </div>
</main>

<?php 
      include $_SERVER['DOCUMENT_ROOT'] . '/components/footer/footer.php';
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="/public/js/home.js"></script>