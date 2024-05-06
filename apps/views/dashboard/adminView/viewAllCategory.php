<link rel=stylesheet href="/public/styles/dashboard/adminView/viewAllCategory.css"></link>
 
<div class="container">
<?php 
    session_start();
    if (isset($_SESSION['notifications']) && is_array($_SESSION['notifications'])) {
        foreach ($_SESSION['notifications'] as $notification) {
            $type = $notification['type'];
            $message = $notification['message'];
            echo "<script>alert('$message');</script>";
        }
        unset($_SESSION['notifications']); 
    }
  ?>
  <h3>Category Items</h3>

  <!-- Trigger the modal with a button -->
  <button type="button" class="btn" style="height:40px" data-toggle="modal" data-target="#myModal">
    Add Category
  </button>

  <table class="table">
    <thead>
      <tr>
        <th class="text-center">No.</th>
        <th class="text-center">Name</th>
        <th class="text-center" colspan="2">Action</th>
      </tr>
    </thead>
    <tbody id="categoryTableBody"></tbody>
  </table>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="modalTitle">New Category Item</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
            <form id="categoryForm" action='/api/category/create.php' enctype='multipart/form-data' method="POST">
              <input type="hidden" name="c_id" id="c_id"> 
              <div class="form-group">
                <label for="c_name">Category Name:</label>
                <input type="text" class="form-control" name="c_name" id="c_name" required>
              </div>
              <div class="form-group">
                <button type="submit" class="btn btn-secondary" id="upload" name="upload" style="height:40px">Add Category</button>
              </div>
            </form>
          </div>
        </div>   
      </div>
  </div>

</div>