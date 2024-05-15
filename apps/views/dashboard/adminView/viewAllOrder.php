<link rel=stylesheet href="/public/styles/dashboard/adminView/viewAllOrder.css"></link>
 
<div class="container">
  <h3>Orders List</h3>

  <table class="table">
    <thead>
      <tr>
        <th>No.</th>
        <th>User Name</th>
        <th>User Information</th>
        <th>Order #</th>
        <th>Order Date</th>
        <th>Order Items</th> 
        <th>Total Amount</th>
        <th class="status">Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="orderTable"></tbody>
  </table>

  <!-- Editing order status -->
  <div class="modal fade" id="editOrderModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="statusModalLabel">Edit Order Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label for="newStatus">New Status:</label>
        <select class="form-control" id="newStatus">
          <option value="pending">Pending</option>
          <option value="processing">Processing</option>
          <option value="shipped">Shipped</option>
          <option value="delivered">Delivered</option>
        </select>

        <input type="hidden" id="orderId">
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-primary" onclick="updateOrderStatus()">Save changes</button>
      </div>
    </div>
  </div>
  </div>
</div>