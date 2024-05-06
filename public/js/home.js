$(document).ready(function() {
    function fetchAndDisplayProducts() {
        $.ajax({
            url: "/api/product/read.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                console.log(response);
                if (response.data.length > 0) {
                    $("#products").empty();

                    $.each(response.data, function(index, product) {
                        var productCard = 
                            "<div class='productCard'>" +
                                "<img src='/uploads/" + product.image + "' alt='" + product.name + "'>" +
                                "<h3>" + product.name + "</h3>" +
                                "<p>Price: ₱" + product.price + "</p>" +
                                "<a class ='viewBtnCustom' href='/apps/views/auth/login.php'>View</a>" +
                            "</div>";

                            $("#products").append(productCard);
                    });
                } else {
                    $("#products").html("<p>No products found</p>");
                }
            }
        });
    }
    fetchAndDisplayProducts();
});