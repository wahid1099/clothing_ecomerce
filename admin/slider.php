<?php
 // Start the session
include('../db.php');
include("auth_check.php");

// Fetch all products from the database
$query = "SELECT * FROM slider ORDER BY slide_id  DESC";

$result = mysqli_query($con, $query);



// Check for errors in the query
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Sliders</title>
    <link rel="stylesheet" href="inclueds/sidebar.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- toast -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


</head>

<body>


<!-- Bootstrap Update Modal -->
<div class="modal fade" id="updateSliderModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Slider Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Update form goes here -->
                <form id="updateSliderForm">
                    <div class="form-group">
                        <label for="updatesliderTitle">Slider Title</label>
                        <input type="text" class="form-control" id="updatesliderTitle" name="updatesliderTitle" required>
                    </div>

                    <div class="form-group">
                        <label for="updatesliderheading">Slider Heading</label>
                        <input type="text" class="form-control" id="updatesliderheading" name="updatesliderheading" required>
                    </div>
                     <!-- Image 1 -->
                     <div class="form-group">
                        <label for="updateImage1">Slider Image  </label>
                        <img id="updateSliderImgPreview" src="" alt="Product Image" style="max-width: 100px;">
                        <input type="file" class="form-control-file" id="updatesliderImage" name="updatesliderImage">
                    </div>

                    <div class="form-group">
                        <label for="updatesliderdescr">Slider Heading</label>
                        <input type="text" class="form-control" id="updatesliderdescr" name="updatesliderdescr" required>
                    </div>

                 
                  

                    <input type="hidden" id="updateSliderId" name="updateSliderId">

                    <button type="button" class="btn btn-primary" onclick="submitUpdateForm()">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Update Modal -->


<!-- Add Modal -->
<div class="modal fade" id="addsliderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Slider</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" action="add_slider.php" enctype="multipart/form-data">
                   
                <div class="form-group">
                        <label for="color">Slider Text:</label>
                        <input type="text" class="form-control" id="slidertext" name="slidertext" required>
                    </div>
                   
                    <div class="form-group">
                        <label for="color">Slider Heading:</label>
                        <input type="text" class="form-control" id="sliderheading" name="sliderheading" required>
                    </div>
                   
                    <div class="form-group">
                        <label for="color">Slider Description:</label>
                        <input type="text" class="form-control" id="sliderdescription" name="sliderdescription" required>
                    </div>
                   
                       

                    <div class="form-group">
                        <label for="image">Slider Image:</label>
                        <input type="file" class="form-control-file" id="sliderimage" name="sliderimage" accept="image/*" required>
                    </div>
                    <!-- End of your form content -->
                    <button type="submit" class="btn btn-primary">Add Slider</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->

<div class="row">
  
        <div class="col-lg-2">
        <?php include 'inclueds/sidebar.php'; ?>
        </div>
        <div class="col-lg-12" id="main">
       
        <h1>SLIDER</h1>

        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addsliderModal">
    Add Slider
</button>
        <h3 class="text-danger fw-bold ">*Note :Please upload 1280*720  size image.</h3><br>
        <table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col">Slider ID</th>
            <th scope="col">Slider Text</th>
            <th scope="col">Slider Heading</th>
            <th scope="col">Slider Image</th>
            <th scope="col">Slider Description</th>
            <th scope="col">Action</th>
           
          
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch orders from the database
        // $query = "SELECT * FROM orders";
        // $result = mysqli_query($con, $query);

        // Loop through the orders and display them in the table
        while ($row = mysqli_fetch_assoc($result)) {
            $imagePath = '../img/' . $row['slide_image'];

            echo '<tr>';
            echo '<td>' . $row['slide_id'] . '</td>';
            echo '<td>' . $row['slide_name'] . '</td>';
            echo '<td>' . $row['slide_heading'] . '</td>';
            echo '<td><img src="' . $imagePath . '" alt="Product Image" style="max-width: 200px;"></td>';
            echo '<td>' . $row['slide_text'] . '</td>';

            echo '<td>';
            echo '<button type="button" class="btn btn-danger" onclick="confirmSlideDelete(' . $row['slide_id'] . ')" data-toggle="modal" data-target="#deleteConfirmationModal">Delete</button>

             <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#updateSliderModal" onclick="openSliderUpdateModal(' . $row['slide_id'] . ')">Update</button>';

           
            // Add more buttons or actions as needed
            echo '</td>';
           
            echo '</tr>';
        }

        // Free the result set
        mysqli_free_result($result);
        ?>
    </tbody>
</table>


</div>


<!-- Bootstrap Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this product?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Yes</button>
            </div>
        </div>
    </div>
</div>
  <!-- Bootstrap Delete Confirmation Modal -->


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script src="tinymce/tinymce.min.js"></script>
    <script>
        tinymce.init({
            selector: 'textarea'
        });
    </script>
    <!-- toast -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
   



<script src="./inclueds/slider.js"></script>

</body>

</html>
