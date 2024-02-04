function openStockUpdateModal(variationId) {
  // Fetch product data for the specified ID and populate the form fields
  $.ajax({
    type: "GET",
    url: "get_stocldata.php", // Create this PHP file to fetch product data based on ID
    data: { variationId: variationId },
    dataType: "json",
    success: function (data) {
      console.log(data);

      $("#updateSize").val(data.size);
      $("#updateColor").val(data.color);
      $("#updateStockQuantity").val(data.stock_quantity);
      $("#updateVariationId").val(variationId);

      $("#updateImagePreview").attr("src", "../img/products/" + data.image_url);

      //  $("#updateStockModal").modal("show");
    },
  });
}

function submitStockUpdateForm() {
  // Submit the update form using AJAX
  var formData = new FormData($("#updateStockForm")[0]);
  formData.append("updateVariationId", $("#updateVariationId").val());

  // Append the HTML content to the FormData
  $.ajax({
    type: "POST",
    url: "update_stock.php", // Create this PHP file to handle the update operation
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
      //  $("#updateStockModal").modal("hide");

      // Reload the page after a delay (e.g., 3 seconds)
      setTimeout(function () {
        location.reload();
      }, 1000); // Adjust the delay as needed
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
