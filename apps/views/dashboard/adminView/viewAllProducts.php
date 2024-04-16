<link rel=stylesheet href="/public/styles/dashboard/adminView/viewAllProducts.css"></link>

<div class="container">
  <h2>Product Items</h2>
  
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add Product
  </button>

  <table id='productTable'>
    <thead>
      <tr>
        <th>No.</th>
        <th>Image</th>
        <th>Name</th>
        <th>Description</th>
        <th>Category</th>
        <th>Stock</th>
        <th>Price</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="productTableBody"></tbody> 
  </table>

   <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="modalTitle">Product Item Details</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form id="productForm"  enctype='multipart/form-data' action="/api/product/create.php" method="POST">
            <input type="hidden" name="product_id" id="p_id"> 
            <div class="form-group">
              <label for="name">Product Name:</label>
              <input type="text" name="name" class="form-control" id="p_name" required>
            </div>
            <div class="form-group">
              <label for="price">Price:</label>
              <input type="number" name="price" class="form-control" id="p_price" required>

              <label for="stock">Stock:</label>
              <input type="number" name="stock" class="form-control" id="p_stock" required>
            </div>
            <div class="form-group">
              <label for="qty">Description:</label>
              <input type="text" name="description" class="form-control" id="p_desc" required>
            </div>
            <div class="form-group">
              <label>Category:</label>
              <select id="category" name="categoryid" >
                <option disabled selected>Select category</option>
              </select>
            </div>
            <div class="form-group">
                <label for="file">Choose Image:</label>
                <input type="file" name="image" class="form-control-file" id="file">
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-secondary" id="upload" style="height:40px">Add Item</button>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>

</div>