<title>Checkout</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href='/public/styles/home/checkout.css'>

<div>
   <?php
      include $_SERVER['DOCUMENT_ROOT'] .  '/components/navbarUser/navbarUser.php';
   ?>
</div>

<main>
<div class="checkout-container">
    <h3>Order Details</h3>
    
    <div class="order-container">
        <div id="orderDetails">
            <table>
                <tr>
                    <th>Image</th>
                    <th class="checkout-name">Name</th>
                    <th>Quantity</th>
                    <th class="checkout-price">Price</th>
                    <th>Total Price</th>
                </tr>

                <tbody id='details'></tbody>
            </table>

            <div class="payment-method">
                <h4>Payment Method</h4>
                <p>We are currently only accepting Cash on Delivery (COD)</p>
                <div class="payment-box">
                    <p class="green"><span>&#x2713;</span> Cash on Delivery</p>
                    <p class="red"><span>&#1093;</span> Debit/Credit Card</p>
                </div>
            </div>
        </div>

        <div class="vertical-line"></div>

        <div class='summary'>
            <h4>Order Summary</h4>
            <hr>
            <div class="oder-summary">
                <p>Subtotal: </p>
                <p>Shipping Fee: </p>
                <p>Total Amount:</p>
            </div>

            <hr>
            <div class="user-details">
                <p>Ship To: </p>
                <p>Phone Number: </p>
                <p>Delivery Address: </p>
            </div>

            <button id="placeOrderBtn">Place Order</button>
        </div>
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