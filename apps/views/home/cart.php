<title>Cart</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="/public/styles/home/cart.css"></link>

<div>
    <?php
        include $_SERVER['DOCUMENT_ROOT'] .  '/components/navbarUser/navbarUser.php';
    ?>
</div>

<main>
    <div class="shopping-cart-container">
        <h3>Shopping Cart</h3>
        <table id='cartTable'>
            <thead>
            <tr>
                <th class="selectAll">
                    <input type="checkbox" id="selectAllCheckbox"> Select All
                </th>
                <th class="images">Image</th>
                <th>Name</th>
                <th class="quantity-btn">Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="cartItems"></tbody> 
        </table>

        <div id="totalPrice">
            <div>
                <h3>Total Amount:   <span id="price"> ₱ 0.00</span></h3>
            </div>
            <button id="checkout">Checkout</button>
        </div>
    </div>
</main>


<?php
    include $_SERVER['DOCUMENT_ROOT'] .  '/components/footer/footer.php';
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="/public/js/homeUser.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>