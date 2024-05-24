<title>Dashboard</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css">
<link rel="stylesheet" href="/public/styles/dashboard/dashboard.css"></link>
<link rel="icon" type="image/x-icon" href="/public/assets/favicon/favicon.ico">

<main>
    <div class="container-dashboard">
        <div class="left">
            <img src='/public/assets/img/logo/logov2.svg' class="logo">

            <div class="admin">
                <p>Hello, Admin</p>
            </div>

            <div class="links">
                <a href="#dashboard" onclick="showDashboard()">Dashboard</a>
                <a href="#products" onclick="showProductItems()">Products</a>
                <a href="#category" onclick="showCategory()">Category</a>
                <a href="#orders" onclick="showOrders()">Orders</a>
                <div class="logout">
                    <a href="/apps/views/home/home.php">
                        <img src='/public/assets/img/icons/log-out.png'>
                        Sign Out
                    </a>
                </div>
            </div>
        </div>
        <div class="right" id="contents">
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="/public/js/ajaxWork.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>