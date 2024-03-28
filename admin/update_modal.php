<!-- Update stock Modal -->
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
                        <label for="updateColor">Stock Color</label>
                        <input type="text" class="form-control" id="updateColor" name="updateColor" required>
                    </div>

                    <div class="form-group">
                        <label for="updateStockQuantity">Stock Quantity</label>
                        <input type="number" class="form-control" id="updateStockQuantity" name="updateStockQuantity" required>
                    </div>


                   

            
                    <input type="hidden" id="updateVariationId" name="updateVariationId">

                    <button type="button" class="btn btn-primary" onclick="submitStockUpdateForm()">Update</button>

                    
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update stock Modal -->



<!-- Update category  Modal -->
<div class="modal fade" id="updateCategoryModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Update form goes here -->
                <form id="updateCategoryForm">
                  

                    <div class="form-group">
                        <label for="updatecattitle">Category Title</label>
                        <input type="text" class="form-control" id="updatecattitle" name="updatecattitle" required>
                    </div>

                    <div class="form-group">
                        <label for="updatedesc">Category Description</label>
                        <input type="text" class="form-control" id="updatedesc" name="updatedesc" required>
                    </div>

                       <!-- Image 1 -->
                       <div class="form-group">
                        <label for="updatecategoryimage">Category Image : </label>
                        <img id="categoryimgpreview" src="" alt="Category Image" style="max-width: 100px;">
                        <input type="file" class="form-control-file" id="updatecategoryimage" name="updatecategoryimage">
                    </div>


            
                    <input type="hidden" id="updateCatId" name="updateCatId">

                    <button type="button" class="btn btn-primary" onclick="submitCategoryUpdateForm()">Update</button>

                    
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update category Modal -->




<!-- Update sub category Modal -->
<div class="modal fade" id="updatesubCategoryModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Sub-Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Update form goes here -->
                <form id="updatesubCategoryForm">
                  
                <div class="form-group">
                        <label for="updatesubCatCategory">Category</label>
                        <select class="form-control" id="updatesubCatCategory" name="updatesubCatCategory">
                            <!-- Categories will be populated dynamically here -->
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="updatesubcattitle">Sub-Category Title</label>
                        <input type="text" class="form-control" id="updatesubcattitle" name="updatesubcattitle" required>
                    </div>

                    <div class="form-group">
                        <label for="updatesubctgdesc">Sub-Category Description</label>
                        <input type="text" class="form-control" id="updatesubctgdesc" name="updatesubctgdesc" required>
                    </div>



            
                    <input type="hidden" id="updatesubCatId" name="updatesubCatId">

                    <button type="button" class="btn btn-primary" onclick="submitsub_CategoryUpdateForm()">Update Sub-Category</button>

                    
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update sub category Modal -->
