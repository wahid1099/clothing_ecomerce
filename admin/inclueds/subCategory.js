function openupdatesubCategoryModal(p_cat_id) {
  // Fetch product data for the specified ID and populate the form fields
  $.ajax({
    type: "GET",
    url: "get_Sub_category.php", // Create this PHP file to fetch product data based on ID
    data: { p_cat_id: p_cat_id },
    dataType: "json",
    success: function (data) {
      // Populate the form fields with the fetched data

      $("#updatesubcattitle").val(data.p_cat_title);
      $("#updatesubctgdesc").val(data.p_cat_desc);
      $("#updatesubCatId").val(data.p_cat_id);
      populateCategorySelect(data.cat_id, data.categories);
    },
  });
}

// Function to populate the category select dropdown and select the default category
function populateCategorySelect(selectedCatId, categories) {
  var select = $("#updatesubCatCategory");
  select.empty(); // Clear previous options

  // Add a default option
  $("<option>Select a Category</option>").appendTo(select);

  // Loop through the categories and create options
  $.each(categories, function (index, category) {
    var option = $("<option></option>")
      .attr("value", category.cat_id)
      .text(category.cat_title)
      .appendTo(select);

    // Set the default category as selected
    if (category.cat_id === selectedCatId) {
      option.attr("selected", true);
    }
  });
}
function submitsub_CategoryUpdateForm() {
  // Submit the update form using AJAX
  var selectedCategoryId = $("#updatesubCatCategory").val();

  var formData = new FormData($("#updatesubCategoryForm")[0]);
  formData.append("updatesubCatId", $("#updatesubCatId").val());
  formData.append("updateCategory", selectedCategoryId); // Add selected category ID to form data

  // Append the HTML content to the FormData
  $.ajax({
    type: "POST",
    url: "update_sub_category.php", // Create this PHP file to handle the update operation
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      Toastify({
        text: "Sub-Category updated successfully",
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
        text: "Failed to update Sub-Category",
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
