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
                                "<p>₱" + product.price + "</p>" +
                            "</div>";

                            $("#products").append(productCard);
                    });
                    initializeSlider();
                } else {
                    $("#products").html("<p>No products found</p>");
                    disableArrows(); 
                }
            }
        });
    }
    
    function initializeSlider() {
        const leftButton = document.getElementById('left-button');
        const rightButton = document.getElementById('right-button');
        const products = document.getElementById('products');
        const productContainer = document.getElementById('products-container');

        let currentIndex = 0;
        const productsCount = products.children.length;
        const productWidth = products.children[0].offsetWidth + 40;

        function updateSlider() {
            const offset = -currentIndex * productWidth;
            products.style.transform = `translateX(${offset}px)`;
            updateArrowStates();
        }

        function updateArrowStates() {
            leftButton.disabled = currentIndex === 0;
            rightButton.disabled = currentIndex >= Math.ceil(productsCount - productContainer.clientWidth / productWidth);
        }

        leftButton.addEventListener('click', () => {
            if (currentIndex > 0) {
                currentIndex--;
                updateSlider();
            }
        });

        rightButton.addEventListener('click', () => {
            if (currentIndex < Math.ceil(productsCount - productContainer.clientWidth / productWidth)) {
                currentIndex++;
                updateSlider();
            }
        });
        updateArrowStates();
    }

    function disableArrows() {
        document.getElementById('left-button').disabled = true;
        document.getElementById('right-button').disabled = true;
    }

    fetchAndDisplayProducts();
});