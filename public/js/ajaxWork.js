function fetchProducts() {
    $.ajax({
        url: "/api/product/read.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
             if (response.data.length > 0) {
                $("#productTable tbody").empty();

                $.each(response.data, function (index, product) {
                    var count = index + 1;
                    var row = "<tr>" +
                        "<td>" + count + "</td>" +
                        "<td><img src='/uploads/" + product.image + "' alt='" + product.name + "'></td>" +
                        "<td>" + product.name + "</td>" +
                        "<td class='description_p'>" + product.description + "</td>" +
                        "<td>" + product.category_name + "</td>" +
                        "<td>" + product.stock + "</td>" +
                        "<td>₱ " + product.price + "</td>" +
                        "<td class='actions'>" +
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

function saveSectionState(sectionId) {
    localStorage.setItem('activeSection', sectionId);
}

function restoreSectionState() {
    return localStorage.getItem('activeSection');
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
                saveSectionState('products');
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
    var activeSection = restoreSectionState();
    if (activeSection) {
        if (activeSection === 'products') {
            showProductItems();
        } else if (activeSection === 'category') {
            showCategory();
        } else if (activeSection === 'dashboard') {
            showDashboard();
        } else if (activeSection === 'orders') {
            showOrders();
        }
    }

    $("#productForm").submit(function(event) {
        event.preventDefault(); 
        const productId = $('#p_id').val(); 
        
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
            }
        });
    });

    $("#categoryForm").submit(function(event) {
        event.preventDefault();
        
        const categoryId = $('#c_id').val(); 
        
        let url, method;
        if (categoryId) {
            url = '/api/category/update.php';
            method = 'POST'; 
        } else {
            url = '/api/category/create.php';
            method = 'POST'; 
        }
    
        const formData = new FormData(this);
        formData.append('id', categoryId); 
    
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false, 
            contentType: false,
            success: function(response) { 
                $('#myModal').modal('hide');
                alert('Item Successfully added');
                showCategory(); 
                $('#categoryForm')[0].reset();
                $('#c_id').val('');          
                $('#modalTitle').text("Category Item Details");
            }
        });
    });    
});

function deleteProduct(id) {
    $.ajax({
        url: "/api/product/delete.php",
        method: "POST",
        contentType: "application/json",
        data: JSON.stringify({ id: id }),
        success: function(response) {
            $.notify(response.message, 'success');
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
        }
    });
}

function editProduct(id) {
    fetchProductDetails(id);
    $('#p_id').val(id); 
    $('#modalTitle').text("Update Product"); 
    $('#upload').text('Update Product');

    $('#productForm').attr('action', '/api/product/update.php'); 
    $('#myModal').modal('show'); 
}

function fetchCategories() {
    $.ajax({
        url: "/api/category/read.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.records.length > 0) {
                $("#categoryTableBody").empty();

                $.each(response.records, function (index, category) {
                    var count = index + 1;
                    var row = "<tr>" +
                        "<td>" + count + "</td>" +
                        "<td>" + category.name + "</td>" +
                        "<td class='actions'>" +
                        "<button onclick='editCategory(" + category.id + ")'>Edit</button>" +
                        "<button  onclick='deleteCategory(" + category.id + ")'>Delete</button>" +
                        "</td>" +
                        "</tr>";
                    $("#categoryTableBody").append(row);

                });
            } else {
                $("#categoryTableBody").html("<tr><td colspan='3'>No categories found</td></tr>");
            }
        }
    });
}

function showCategory(){  
    $.ajax({
        url:"/apps/views/dashboard/adminView/viewAllCategory.php",
        method:"POST",
        data:{record:1},
        success:function(data){
            $('#contents').html(data);
            fetchCategories();
            saveSectionState('category');
        }
    });
}

function deleteCategory(id){
    $.ajax({
        url:"/api/category/delete.php",
        method:"POST",
        contentType: "application/json",
        data: JSON.stringify({ id: id }),
        success:function(response){
            $.notify(response.message, 'success');
            showCategory();
        }
    });
}

function fetchCategoryDetails(id) {
    $.ajax({
        url: "/api/category/read_one.php?id=" + id, 
        type: "GET",
        dataType: "json",
        success: function (category) {
            $('#c_name').val(category.name);
            $('#myModal').modal('show');
        }
    });
}

function editCategory(id) {
    fetchCategoryDetails(id);
    $('#c_id').val(id); 
    $('#modalTitle').text("Update Category");
    $('#upload').text('Update Category');

    $('#categoryForm').attr('action', '/api/category/update.php');
    $('#myModal').modal('show');
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

function fetchOrders() {
    $.ajax({
        url: "/api/orders/read.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.data.length > 0) {
                $("#orderTable").empty();

                $.each(response.data, function (index, order) {
                    var orderItems = "";
                    $.each(order.order_items, function (idx, item) {
                        orderItems += item.quantity + "x " + item.product_name + "<br>";
                    });

                    var row = "<tr>" +
                        "<td>" + (index + 1) + "</td>" +
                        "<td>#" + order.id + "</td>" + 
                        "<td>" + order.order_date + "</td>" + 
                        "<td>" + order.customer_name + "</td>" +
                        "<td>" + orderItems + "</td>" +
                        "<td>₱" + order.total_amount + "</td>" +
                        "<td>" + order.status + "</td>" +
                        "<td class='actions'>" +
                            "<button onclick='editOrder(" + order.id + ")'>Edit</button>" +
                            "<button onclick='deleteOrder(" + order.id + ")'>Delete</button>" +
                        "</td>" +
                        "</tr>";
                    $("#orderTable").append(row);
                });
            } else {
                $("#orderTable").html("<tr><td colspan='8'>No orders found</td></tr>");
            }
        }
    });
}

function showOrders() {
    $.ajax({
        url: "/apps/views/dashboard/adminView/viewAllOrder.php",
        method: "POST",
        data: { record: 1 },
        success: function (data) {
            $('#contents').html(data);
            fetchOrders();
            saveSectionState('orders');
        }
    });
}

function fetchOrderDetails(id) {
    $.ajax({
        url: "/api/orders/read_one.php?id=" + id,
        type: "GET",
        dataType: "json",
        success: function (orders) {
            $('#newStatus').val(orders.status);
            $('#orderId').val(id);
            $('#editOrderModal').modal('show');
        }
    });
}

function updateOrderStatus() {
    var newStatus = $('#newStatus').val();
    var orderId = $('#orderId').val();
    $.ajax({
        url: "/api/orders/update_status.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({ id: orderId, status: newStatus }), 
        success: function(response) {
            $('#editOrderModal').modal('hide');
            $.notify('Order status updated successfully', 'success');
            fetchOrders();
        }
    });
}

function editOrder(id) {
    fetchOrderDetails(id);
}

function deleteOrder(id) {
    $.ajax({
        url: "/api/orders/delete.php",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify({ id: id }),
        success: function(response) {
            $.notify(response.message, 'success');
            fetchOrders();
        }
    });
}

function fetchTotals() {
    $.ajax({
      url: "/api/objects/total.php",
      type: "GET",
      dataType: "json",
      success: function(response) {
        $('#totalCategories').text(response.totalCategories);
        $('#totalProducts').text(response.totalProducts);
        $('#totalUsers').text(response.totalUsers);
        $('#totalOrders').text(response.totalOrders);
        $('#newOrders').text(response.totalNewOrders);
      }
    });
  }

function showDashboard(){
    $.ajax({
        url:"/apps/views/dashboard/adminView/viewDashboard.php",
        method:"POST",
        data:{record:1},
        success:function(data){
            $('#contents').html(data);
            saveSectionState('dashboard');
            fetchTotals();
        }
    });
}