// Update color dropdown options using the availableColors array
var colorDropdown = document.getElementById("colorDropdown");
colorDropdown.innerHTML = '<option value="">-- Select Color --</option>';
for (var i = 0; i < availableColors.length; i++) {
  colorDropdown.innerHTML +=
    '<option value="' +
    availableColors[i] +
    '">' +
    availableColors[i] +
    "</option>";
}

// Show the color dropdown container
document.getElementById("colorDropdownContainer").style.display = "block";

// Function to update sizes
async function updateSizes() {
  // Get selected color
  var selectedColor = document.getElementById("colorDropdown").value;

  var productIdInput = document.getElementById("productIdvar");

  var productId = productIdInput.value;

  try {
    // Fetch sizes based on the selected color using fetch
    const response = await fetch(
      `./get_sizes.php?product_id=${productId}&color=${selectedColor}`
    );

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    // Parse the JSON response
    const sizes = await response.json();
    console.log("Sizes:", sizes);

    // Check if sizes is an array
    if (Array.isArray(sizes)) {
      // Update size dropdown options
      var sizeDropdown = document.getElementById("sizeDropdown");
      sizeDropdown.innerHTML = '<option value="">-- Select Size --</option>';
      for (var i = 0; i < sizes.length; i++) {
        sizeDropdown.innerHTML +=
          '<option value="' + sizes[i] + '">' + sizes[i] + "</option>";
      }

      // Show the size dropdown container
      document.getElementById("sizeDropdownContainer").style.display = "block";
    } else {
      console.error("Invalid response format:", sizes);
    }
  } catch (error) {
    console.error("Error fetching sizes:", error.message);
  }
}
