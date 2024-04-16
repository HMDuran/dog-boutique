function fetchProducts() {
    $.ajax({
        url: "/api/product/read.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.data.length > 0) {
                $("#productTable tbody").empty();

                $.each(response.data, function (index, product) {
                    var row = "<tr>" +
                        "<td>" + product.id + "</td>" +
                        "<td><img src='/uploads/" + product.image + "' alt='" + product.name + "'></td>" +
                        "<td>" + product.name + "</td>" +
                        "<td>" + product.description + "</td>" +
                        "<td>" + product.categoryid + "</td>" +
                        "<td>" + product.stock + "</td>" +
                        "<td>" + product.price + "</td>" +
                        "<td>" +
                        "<button onclick='editProduct(" + product.id + ")'>Edit</button>" +
                        "<button onclick='deleteProduct(" + product.id + ")'>Delete</button>" +
                        "</td>" +
                        "</tr>";
                    $("#productTable tbody").append(row);
                });
            } else {
                $("#productTable tbody").html("<tr><td colspan='8'>No products found</td></tr>");
            }
        }
    });
}

function showProductItems(){  
    $.ajax({
        url:"/apps/views/dashboard/adminView/viewAllProducts.php",
        method:"POST",
        data:{record:1},
        success:function(data){
            $('#contents').html(data);

            populateCategoryDropdown();
            fetchProducts();
        }
    });
}

function populateCategoryDropdown() {
    $.ajax({
        url: "/api/category/read.php",
        type: "POST",
        dataType: "json",
        success: function (data) {
            if (data.records) {
                var categories = data.records;
                var dropdown = $("#category");
                dropdown.empty(); 
                dropdown.append($("<option></option>").text("Select category"));
                $.each(categories, function (key, category) {
                    dropdown.append($("<option></option>")
                        .attr("value", category.id)
                        .text(category.name)
                    );
                });
            }
        }
    });
}

$(document).ready(function() {
    $("#productForm").submit(function(event) {
        event.preventDefault();

        const productId = $('#p_id').val(); 
        console.log('Product ID:', productId);
        
        let url, method;
        if (productId) {
            url = '/api/product/update.php';
            method = 'POST'; 
        } else {
            url = '/api/product/create.php';
            method = 'POST'; 
        }

        const formData = new FormData(this);
        formData.append('id', productId); 

         console.log('Form Data:', formData);
    
        const newFile = $('#file')[0].files[0];
        if (newFile) {
            formData.append('image', newFile);
        }
    

        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false, 
            contentType: false,
            success: function(response) { 
                $('#myModal').modal('hide');
                alert(response.message);
                showProductItems(); 
                $('#productForm')[0].reset();
                $('#p_id').val('');          
                $('#modalTitle').text("Product Item Details");
            }
        });
    });
});

function deleteProduct(id){
    $.ajax({
        url:"/api/product/delete.php",
        method:"POST",
        contentType: "application/json",
        data: JSON.stringify({ id: id }),
        success:function(response){
            alert('Item Successfully deleted');
            showProductItems();
        }
    });
}

function fetchProductDetails(id) {
    $.ajax({
        url: "/api/product/read_one.php?id=" + id, 
        type: "GET",
        dataType: "json",
        success: function (product) {
            
            $('#p_name').val(product.name);
            $('#p_price').val(product.price);
            $('#p_stock').val(product.stock); 
            $('#p_desc').val(product.description);
            $('#category').val(product.categoryid);
             $('#file').val(product.image);

            $('#myModal').modal('show'); 
        }
    });
}

function editProduct(id) {
    fetchProductDetails(id);
    $('#p_id').val(id); 
    $('#modalTitle').text("Update Product"); 

    $('#productForm').attr('action', '/api/product/update.php'); 
    $('#myModal').modal('show'); 
}

function showCategory(){  
    $.ajax({
        url:"/apps/views/dashboard/adminView/viewAllCategory.php",
        method:"POST",
        data:{record:1},
        success:function(data){
            $('#contents').html(data);
        }
    });
}

function showUsers(){
    $.ajax({
        url:"/apps/views/dashboard/adminView/viewAllUser.php",
        method:"POST",
        data:{record:1},
        success:function(data){
            $('#contents').html(data);
        }
    })
}

function showOrders() {
    $.ajax({
        url: "/apps/views/dashboard/adminView/viewAllOrder.php",
        method: "POST",
        data: { record: 1 },
        success: function (data) {
            $('#contents').html(data);
        }
    });
}

function showDashboard(){
    $.ajax({
        url:"/apps/views/dashboard//adminView/viewDashboard.php",
        method:"POST",
        data:{record:1},
        success:function(data){
            $('#contents').html(data);
        }
    });
}