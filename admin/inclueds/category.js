function openupdateCategoryModal(catid) {
  // Fetch product data for the specified ID and populate the form fields
  $.ajax({
    type: "GET",
    url: "get_category.php", // Create this PHP file to fetch product data based on ID
    data: { catid: catid },
    dataType: "json",
    success: function (data) {
      console.log(data);
      // Populate the form fields with the fetched data

      $("#updatecattitle").val(data.cat_title);
      $("#updatedesc").val(data.cat_desc);
      $("#updateCatId").val(data.cat_id);
    },
  });
}

function submitCategoryUpdateForm() {
  // Submit the update form using AJAX
  var formData = new FormData($("#updateCategoryForm")[0]);
  formData.append("updateCatId", $("#updateCatId").val());

  // Append the HTML content to the FormData
  $.ajax({
    type: "POST",
    url: "update_category.php", // Create this PHP file to handle the update operation
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      Toastify({
        text: "Category updated successfully",
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        backgroundColor: "#65B741", // Green color for success
        onClick: function () {},
      }).showToast();

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
        text: "Failed to update Category",
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
