<!-- Update Modal -->
<div class="modal fade" id="updateStockModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
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
                <form id="updateStockForm">
                    <!-- Add form fields for each attribute (e.g., size, color, stock_quantity, etc.) -->
                    <div class="form-group">
                        <label for="updateSize">Size</label>
                        <input type="text" class="form-control" id="updateSize" name="updateSize" required>
                    </div>

                    <div class="form-group">
                        <label for="updateColor">Color</label>
                        <input type="text" class="form-control" id="updateColor" name="updateColor" required>
                    </div>

                    <div class="form-group">
                        <label for="updateStockQuantity">Stock Quantity</label>
                        <input type="number" class="form-control" id="updateStockQuantity" name="updateStockQuantity" required>
                    </div>

                     <!-- Image 1 -->
                     <div class="form-group">
                        <label for="updateImage1">Product Image : </label>
                        <img id="updateImagePreview" src="" alt="Product Image" style="max-width: 100px;">
                        <input type="file" class="form-control-file" id="updateImage" name="updateImage">
                    </div>

            
                    <input type="hidden" id="updateVariationId" name="updateVariationId">

                    <button type="button" class="btn btn-primary" onclick="submitStockUpdateForm()">Update</button>

                    
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update Modal -->
