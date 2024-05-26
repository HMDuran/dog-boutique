<title>Home</title>
<link rel="icon" type="image/x-icon" href="/public/assets/favicon/favicon.ico">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href='/public/styles/home/homeUser.css'>

<div>
    <?php
        include $_SERVER['DOCUMENT_ROOT'] . '/components/navbarUser/navbarUser.php';
    ?>
</div>

<main>
    <div class="banner-two">
        <img src="/public/assets/img/bannerv2.png">
    </div>

    <div id="productContainer">
        <h1>Products</h1>
        
        <div id="filterButtons">
            <button class="filterBtn active" data-category="all">All</button>
        </div>

        <div id="products"></div>
    </div>

    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="productDetails">
                        <!-- Product details will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php
    include $_SERVER['DOCUMENT_ROOT'] . '/components/footer/footer.php';
?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="/public/js/homeUser.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>