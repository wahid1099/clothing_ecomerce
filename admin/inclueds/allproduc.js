function openUpdateModal(productId) {
  // Fetch product data for the specified ID and populate the form fields
  $.ajax({
    type: "GET",
    url: "get_product_data.php", // Create this PHP file to fetch product data based on ID
    data: { productId: productId },
    dataType: "json",
    success: function (data) {
      console.log(data);
      // Populate the form fields with the fetched data
      $("#updateProductTitle").val(data.product_title);

      $("#updateProductPrice").val(data.product_price);
      $("#updateProductdesc").html(data.product_desc);
      // Update image previews
      $("#updateImage1Preview").attr(
        "src",
        "../img/products/" + data.product_img1
      );
      $("#updateImage2Preview").attr(
        "src",
        "../img/products/" + data.product_img2
      );

      $("#updateProductkeyword").val(data.product_keywords);
      // Populate more form fields as needed

      // Set the product ID in the hidden input field
      $("#updateProductId").val(productId);

      // Open the update modal
      $("#updateModal").modal("show");
    },
  });
}

function submitUpdateForm() {
  // Submit the update form using AJAX
  var formData = new FormData($("#updateForm")[0]);
  var productDesc = $("#updateProductdesc").html();

  // Append the HTML content to the FormData
  formData.append("updateProductdesc", productDesc);
  $.ajax({
    type: "POST",
    url: "update_product.php", // Create this PHP file to handle the update operation
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      // Handle the update success

      console.log(response);

      // Show Toastify notification for success
      Toastify({
        text: response,
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        backgroundColor: "#65B741", // Green color for success
        onClick: function () {
          // Callback after click, you can redirect or perform additional actions here
        },
      }).showToast();

      // Close the update modal
      $("#updateModal").modal("hide");

      // Reload the page after a delay (e.g., 3 seconds)
      setTimeout(function () {
        location.reload();
      }, 2000); // Adjust the delay as needed
    },
    error: function (error) {
      // Handle the update error
      console.error("Update failed:", error);

      // Show Toastify notification for error
      Toastify({
        text: "Failed to update product",
        duration: 2000,
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        backgroundColor: "#FF0000", // Red color for error
        onClick: function () {
          // Callback after click, you can redirect or perform additional actions here
        },
      }).showToast();
    },
  });
}

function confirmDelete(productId) {
  // Set the product ID to be deleted
  $("#confirmDeleteButton").data("product-id", productId);
}

// Handle the delete confirmation
$("#confirmDeleteButton").on("click", function () {
  var productId = $(this).data("product-id");
  // Show the Toastify notification

  window.location.href = "delete_product.php?product_id=" + productId;
});
