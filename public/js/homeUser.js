$(document).ready(function() {
    function fetchAndDisplayProducts(category = 'all') {
        $.ajax({
            url: "/api/product/filter.php",
            type: "GET",
            data: { category: category },
            dataType: "json",
            success: function(response) {
                if (response.data.length > 0) {
                    $("#products").empty();

                    $.each(response.data, function(index, product) {
                        var productCard = 
                            "<div class='productCard'>" +
                                "<img src='/uploads/" + product.image + "' alt='" + product.name + "'>" +
                                "<h3>" + product.name + "</h3>" +
                                "<p>Price: ₱" + product.price + "</p>" +
                                "<div class='btns'>" +
                                    "<button class='btn viewBtn' data-toggle='modal' data-target='#productModal' data-product-id='" + product.id + "'>View</button>" +
                                    "<a class='addToCartCardBtn' data-product-id='" + product.id + "'><img src='/public/assets/img/icons/cart.png'></a>" +
                                "</div>" +
                            "</div>";

                            $("#products").append(productCard);
                    });
                    
                    $(".viewBtn").click(function() {
                        var productId = $(this).data("product-id");
                        fetchProductDetails(productId);
                    });

                    $(".addToCartCardBtn").click(function() {
                        var productId = $(this).data("product-id");
                        var quantity = parseInt($(this).closest('.productCard').find('#quantity').val()) || 1; 
                        addToCart(productId, quantity);
                    });
                } else {
                    $("#products").html("<p>No products found</p>");
                }
            }
        });
    }

    function generateCategoryButtons() {
        $.ajax({
            url: "/api/product/filter.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.data.length > 0) {
                    let categories = new Set();
                    $.each(response.data, function(index, product) {
                        categories.add(product.category_name);
                    });

                    categories.forEach(function(category) {
                        var button = "<button class='filterBtn' data-category='" + category + "'>" + category + "</button>";
                        $("#filterButtons").append(button);
                    });

                    $("#filterButtons").on("click", ".filterBtn", function() {
                        var category = $(this).data("category");
                        fetchAndDisplayProducts(category);

                        $(".filterBtn").removeClass("active");
                        $(this).addClass("active");
                    });
                }
            }
        });
    }

    function fetchProductDetails(productId) {
        $.ajax({
            url: "/api/product/read_one.php?id=" + productId,
            type: "GET",
            dataType: "json",
            success: function(product) {
                var productDetailsHTML =
                    "<img class='productImage' src='/uploads/" + product.image + "' alt='" + product.name + "'>" +
                    "<div class='details'>" +
                        "<h1>" + product.name + "</h1>" +
                        "<p class='price'>₱" + product.price + "</p>" +
                        "<p>" + product.description + "</p>" +
                        "<hr>" +
                        "<p><span>Category: </span>" + product.category_name + "</p>" +
                        "<hr>"  +

                        "<div class='quantity-container form-group mt-3'>" +
                            "<label for='quantity'><span>Quantity: </span></label>" +
                            
                            "<div class='input-group'>" +
                                "<span class='input-group-btn'>" +
                                    "<button type='button' class='btn btn-secondary shadow-none btn-quantity' data-type='minus'>-</button>" +
                                "</span>" +

                                 "<input type='number' id='quantity' class='text-center' value='1' min='1'>" +

                                "<span class='input-group-btn'>" +
                                  "<button type='button' class='btn btn-secondary shadow-none btn-quantity' data-type='plus'>+</button>" +
                                "</span>" +
                             "</div>" +
                         "</div>" +
        
                        "<p><span>Stock Available:  </span>" + product.stock + "</p>" +

                        "<div class='modal-footer'>" +
                            "<button class='btn btn-primary addToCartBtn' data-product-id='" + product.id + "'>Add to Cart</button>" + 
                            "<button class='btn btn-primary buyNowBtn' data-product-id='" + product.id + "'>Buy Now</button>" +
                        "</div>" +
                    "</div>";

                $("#productDetails").html(productDetailsHTML);
                $("#productModal").modal("show");

                $(".btn-quantity").click(function() {
                    var input = $(this).closest(".input-group").find("input[type='number']");
                    var type = $(this).data("type");
                    var currentValue = parseInt(input.val());

                    if (type === "minus") {
                        if (currentValue > 1) {
                            input.val(currentValue - 1);
                        }
                    } else if (type === "plus") {
                        input.val(currentValue + 1);
                    }
                });

                $(".addToCartBtn").click(function() {
                    var productId = $(this).data("product-id");
                    var quantity = parseInt($("#quantity").val());
                    addToCart(productId, quantity);
                });

                $(".buyNowBtn").click(function() {
                    var productId = $(this).data("product-id");
                    var quantity = parseInt($("#quantity").val(), 10);
            
                    if (!isNaN(quantity) && quantity > 0) {
                        window.location.href = "/apps/views/home/checkout.php?productId=" + productId + "&quantity=" + quantity;
                    } else {
                        alert("Please enter a valid quantity.");
                    }
                });
            }
        });
    }

    function addToCart(productId, quantity) {
        $.ajax({
            url: "/api/cart/addToCart.php",
            type: "POST",
            data: {
                product_id: productId,
                quantity: quantity
            },
            success: function(response) {
                updateCartCount();
                $('#productModal').modal('hide');
            }
        })
    }

    function updateCartCount() {
        $.ajax({
            url: "/api/cart/count.php",
            type: "GET",
            success: function(response) {
                var currentCount = parseInt(response) || 0; 
    
                localStorage.setItem("cartItemCount", currentCount);
    
                $("#cart-item-count").text(currentCount);
            }
        })
    }
    
    function getCartCount() {
      const cartCount = localStorage.getItem("cartItemCount") || 0;

      $("#cart-item-count").text(cartCount);
    }
    
    function fetchCartItems() {
        $.ajax({
            url: "/api/cart/read.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.data.length > 0) {
                    $("#cartItems").empty();

                    $.each(response.data, function(index, cartItem) {
                        var row = 
                        "<tr>" +
                            "<td><input type='checkbox' class='cart-item-checkbox' data-cart-item-id='" + cartItem.id + "'></td>" + 
                            "<td><img  class='productImage' src='/uploads/" + cartItem.image + "' alt='" + cartItem.product_name + "'></td>" +
                            "<td>" + cartItem.product_name + "</td>" +
                            "<td>" +
                                "<div class='input-group'>" +
                                    "<span class='input-group-btn'>" +
                                        "<button class='btn btn-secondary btn-minus  btn-quantity' data-type='minus' data-cart-item-id='" + cartItem.id + "'>-</button>" +
                                    "</span>" +
                                    "<input type='number' class='quantityInput' value='" + cartItem.quantity + "'>" +
                                    "<span class='input-group-btn'>" +
                                        "<button class='btn btn-secondary btn-plus  btn-quantity' data-type='plus' data-cart-item-id='" + cartItem.id + "'>+</button>" +
                                    "</span>" +
                                "</div>" +
                            "</td>" +
                            "<td>₱ " + cartItem.price + "</td>" +
                            "<td class='totalPrice'>₱ " + cartItem.total_amount.toFixed(2)  + "</td>" +
                            "<td>" + 
                                "<button class='btn btn-danger btn-sm deleteCartItemBtn' data-cart-item-id='" + cartItem.id + "'><img src='/public/assets/img/icons/trash-2.png' /></button>" +
                            "</td>" +
                            "</tr>";

                        $("#cartItems").append(row);
                    });

                    $(".btn-quantity").click(function() {
                        var input = $(this).closest(".input-group").find("input[type='number']");
                        var type = $(this).data("type");
                        var currentValue = parseInt(input.val());
                        
                        var cartItemId = $(this).data("cart-item-id"); 
                        if (type === "minus") {
                            if (currentValue > 1) {
                                var newQuantity = currentValue - 1;
                                input.val(newQuantity);
                                console.log("New quantity after decrement:", newQuantity);
                                updateCartItemQuantity(cartItemId, newQuantity); 
                            }
                        } else if (type === "plus") {
                            var newQuantity = currentValue + 1;
                            input.val(newQuantity);
                            console.log("New quantity after increment:", newQuantity);
                            updateCartItemQuantity(cartItemId, newQuantity); 
                        }
                    });

                    $(document).on('change', '.quantityInput', function() {
                        var newQuantity = parseInt($(this).val());
                        var cartItemId = $(this).closest('tr').find('.btn-quantity').data('cart-item-id');
                        updateCartItemQuantity(cartItemId, newQuantity);
                    });

                    $(document).on('keypress', '.quantityInput', function(event) {
                        if (event.which === 13) {
                            $(this).blur();
                        }
                    });

                    $(document).on('change', '.cart-item-checkbox', function() {
                        calculateTotalAmount();
                    });
                
                    $("#selectAllCheckbox").change(function() {
                        $(".cart-item-checkbox").prop('checked', $(this).prop("checked"));
                        calculateTotalAmount();
                    });

                    $(".deleteCartItemBtn").click(function() {
                        var cartItemId = $(this).data("cart-item-id");
                        deleteCartItem(cartItemId);
                    });

                } else {
                    $("#cartItems").html("<tr><td colspan='7'>No items in cart</td></tr>");
                }
            }
        });

        $(document).on('click', '#checkout', function(event) {
            event.preventDefault();

            var checkedItemIds = [];
            $(".cart-item-checkbox:checked").each(function() {
                checkedItemIds.push($(this).data("cart-item-id"));
            });

            if ($("#cartItems").html().includes("No items in cart")) {
                alert("No items in cart. Please add items to your cart before checkout.");
            } else if (checkedItemIds.length === 0) {
                alert("Please select at least one item to checkout.");
            } else {
                window.location.href = "/apps/views/home/checkout.php?cartItemIds=" + checkedItemIds.join(",");
            }
        });
        
        function deleteCartItem(cartItemId) {
            $.ajax({
                url: "/api/cart/delete.php",
                type: "POST",
                data: {
                    id: cartItemId,
                },
                dataType: "json",
                success: function(response) {
                    fetchCartItems();
                    updateCartCount();
                }
            });
        }

        function updateCartItemQuantity(cartItemId, newQuantity) {
            $.ajax({
                url: "/api/cart/updateQuantity.php",
                type: "POST",
                dataType: "json",
                data: {
                    id: cartItemId,
                    quantity: newQuantity
                },
                success: function(response) {
                    fetchCartItems(); 
                    updateCartCount();
                }
            });
        }

        function calculateTotalAmount() {
            var totalAmount = 0;
            $(".cart-item-checkbox:checked").each(function() {
                var row = $(this).closest("tr");
                var itemTotal = parseFloat(row.find(".totalPrice").text().replace("₱", ""));
                totalAmount += itemTotal;
            });
            $("#price").text("₱" + totalAmount.toFixed(2));
        }
    }

    function fetchCartItemsDetails(cartItemIds) {
        $.ajax({
            url: "/api/cart/readById.php",
            type: "GET",
            dataType: "json",
            data: { cartItemIds: cartItemIds },
            success: function(response) {
                var subtotal = 0;
                $('#details').empty();
                $.each(response.data, function(index, cartItem) {
                    var row = "<tr>" +
                        "<td><img class='productImage' src='/uploads/" + cartItem.image + "' alt='" + cartItem.name + "'data-product-id='" + cartItem.product_id + "'></td>" +
                        "<td>" + cartItem.name + "</td>" +
                        "<td>" + cartItem.quantity + "</td>" +
                        "<td>₱" + cartItem.price + "</td>" +
                        "<td class='totalPrice'>₱" + cartItem.total_amount + "</td>" +
                        "</tr>";

                    $('#details').append(row);

                    subtotal += parseFloat(cartItem.total_amount);
                });
                var subtotalHTML = "<p><span>Subtotal: </span>₱" + subtotal.toFixed(2) + "</p>";

                var shippingFee = 64;
                var shippingFeeHTML = "<p><span>Shipping Fee: </span>₱" + shippingFee.toFixed(2) + "</p>";

                var totalAmount = subtotal + shippingFee;
                var totalAmountHTML = "<p class='total-amount-checkout'>Total Amount: ₱" + totalAmount.toFixed(2) + "</p>";

                $(".oder-summary").html(subtotalHTML + shippingFeeHTML + totalAmountHTML);
            }
        });
    }

    function fetchCheckoutDetails() {
        var urlParams = new URLSearchParams(window.location.search);
        var productId = urlParams.get('productId');
        var quantity = urlParams.get('quantity');
        var cartItemIds = urlParams.get('cartItemIds');
    
        if (productId && quantity) {
            fetchProductDetailsForCheckout(productId, quantity);
        } else if (cartItemIds) {
            fetchCartItemsDetails(cartItemIds);
        } 
    }    

    function fetchProductDetailsForCheckout(productId, quantity) {
        $.ajax({
            url: "/api/product/read_one.php?id=" + productId,
            type: "GET",
            dataType: "json",
            success: function(product) {
                var row = "<tr>" +
                    "<td><img class='productImage' src='/uploads/" + product.image + "' alt='" + product.name + "' data-product-id='" + product.id + "'></td>" +
                    "<td>" + product.name + "</td>" +
                    "<td>" + quantity + "</td>" +
                    "<td>₱" + product.price + "</td>" +
                    "<td class='totalPrice'>₱" + (product.price * quantity).toFixed(2) + "</td>" +
                    "</tr>";

                $('#details').html(row);

                var subtotal = product.price * quantity;
                var shippingFee = 64;
                var totalAmount = subtotal + shippingFee;

                $(".oder-summary").html(
                    "<p><span>Subtotal: </span>₱" + subtotal.toFixed(2) + "</p>" +
                    "<p><span>Shipping Fee: </span>₱" + shippingFee.toFixed(2) + "</p>" +
                    "<p class='total-amount-checkout'>Total Amount: ₱" + totalAmount.toFixed(2) + "</p>"
                );
            }
        });
    }

    function fetchUserDetails() {
        $.ajax({
            url: "/api/user/details.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                var userName = response.first_name + " " + response.last_name;
                var deliveryAddress = response.delivery_address;
                var phoneNumber = response.phone_number;

                $(".user-details").html("<p><span>Ship To:</span> " + userName + "</p><p><span>Phone Number: </span>" + phoneNumber + "</p><p><span>Delivery Address: </span>" + deliveryAddress + "</p>");
            }
        });
    }

    $(document).on('click', '#placeOrderBtn', function(event) {
        event.preventDefault();
    
        var orderItems = [];
    
        $('#details tr').each(function(index, row) {
            var product_id = $(row).find('.productImage').data('product-id'); 
            var quantity = $(row).find('td:nth-child(3)').text();
            var totalPrice = $(row).find('.totalPrice').text().replace('₱', ''); 
        
            orderItems.push({
                product_id: product_id,
                quantity: quantity,
                total_price: totalPrice
            });
        });
        console.log(orderItems);
       
        var totalAmount = parseFloat($(".total-amount-checkout").text().replace("Total Amount: ₱", ""));
    
        $.ajax({
            url: "/api/orders/placeOrder.php",
            type: "POST",
            dataType: "json",
            data: {
                total_amount: totalAmount,
                orderItems: orderItems,
                cartItemIds: getUrlParameter("cartItemIds")
            },
            success: function(response) {
                if (response.success) {
                    removeCartItems(getUrlParameter("cartItemIds"));
                } else {
                    alert("Failed to place order. Please try again.");
                }
            }
        });
    });

    function removeCartItems(cartItemIds) {
        $.ajax({
            url: "/api/cart/removeItem.php",
            type: "POST",
            dataType: "json",
            data: {
                cartItemIds: cartItemIds
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = "/apps/views/home/placeOrder.php";
                } else {
                    alert("Failed to remove cart items. Please try again.");
                }
            }
        });
    }

    function getUrlParameter(name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    }

    function fetchPlaceOrderDetails() {
        $.ajax({
            url: '/api/orders/details.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.records.length > 0) {
                    var latestOrder = response.records.reduce(function(prevOrder, currentOrder) {
                        return (prevOrder.id > currentOrder.id) ? prevOrder : currentOrder;
                    });
    
                    var firstName = latestOrder.first_name;
                    var lastName = latestOrder.last_name;
    
                    var userGreeting = 'Hey FurrParent, <b>' + firstName + '</b> <b>' + lastName + '</b>,';
                    $('#user-greeting').html(userGreeting);
    
                    $('#order-number').text('Your order number: ' + latestOrder.id);
                } else {
                    $('#user-greeting').text('Hey FurrParent,');
                    $('#order-number').text('No orders found.');
                }
            }
        });
    }
    
    fetchPlaceOrderDetails();
    fetchUserDetails();
    fetchCheckoutDetails();
    updateCartCount(); 
    getCartCount();
    generateCategoryButtons();
    fetchAndDisplayProducts();
    fetchCartItems();
});