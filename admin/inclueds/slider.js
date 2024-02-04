function openSliderUpdateModal(sliderId) {
  // Fetch product data for the specified ID and populate the form fields
  $.ajax({
    type: "GET",
    url: "get_sliderData.php", // Create this PHP file to fetch product data based on ID
    data: { sliderId: sliderId },
    dataType: "json",
    success: function (data) {
      console.log(data);
      // Populate the form fields with the fetched data
      $("#updatesliderTitle").val(data.slide_name);
      $("#updatesliderheading").val(data.slide_heading);
      $("#updatesliderdescr").val(data.slide_text);

      $("#updateSliderImgPreview").attr("src", "../img/" + data.slide_image);

      $("#updateSliderId").val(sliderId);

      // Open the update modal
      $("#updateModal").modal("show");
    },
  });
}

function submitUpdateForm() {
  // Submit the update form using AJAX
  var formData = new FormData($("#updateSliderForm")[0]);

  $.ajax({
    type: "POST",
    url: "update_slider.php", // Create this PHP file to handle the update operation
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

function confirmSlideDelete(slide_id) {
  // Set the product ID to be deleted
  $("#confirmDeleteButton").data("slide_id", slide_id);
}

// Handle the delete confirmation
$("#confirmDeleteButton").on("click", function () {
  var slide_id = $(this).data("slide_id");
  // Show the Toastify notification

  console.log(slide_id);

  window.location.href = "delete_slide.php?slide_id=" + slide_id;
});
