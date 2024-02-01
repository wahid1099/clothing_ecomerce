<!-- Update Modal -->
<div class="modal fade" id="updateModal<?php echo $row['variation_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Product Variation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Update form goes here -->
                <form id="updateForm<?php echo $row['variation_id']; ?>">
                    <!-- Add form fields for each attribute (e.g., size, color, stock_quantity, etc.) -->
                    <div class="form-group">
                        <label for="updateSize">Size</label>
                        <input type="text" class="form-control" id="updateSize<?php echo $row['variation_id']; ?>" name="updateSize" required>
                    </div>

                    <div class="form-group">
                        <label for="updateColor">Color</label>
                        <input type="text" class="form-control" id="updateColor<?php echo $row['variation_id']; ?>" name="updateColor" required>
                    </div>

                    <div class="form-group">
                        <label for="updateStockQuantity">Stock Quantity</label>
                        <input type="number" class="form-control" id="updateStockQuantity<?php echo $row['variation_id']; ?>" name="updateStockQuantity" required>
                    </div>

                    <!-- Add more form fields as needed -->

                    <input type="hidden" id="updateVariationId" name="updateVariationId" value="<?php echo $row['variation_id']; ?>">

                    <button type="button" class="btn btn-primary" onclick="submitUpdateForm(<?php echo $row['variation_id']; ?>)">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update Modal -->
