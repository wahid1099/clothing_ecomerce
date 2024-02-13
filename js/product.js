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

// Function to update sizes
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

    // Update size dropdown options
    var sizeDropdown = document.getElementById("sizeDropdown");
    if (!sizeDropdown) {
      throw new Error("Size dropdown element not found");
    }
    sizeDropdown.innerHTML = '<option value="">-- Select Size --</option>';
    sizes.forEach(function (size) {
      sizeDropdown.innerHTML +=
        '<option value="' + size + '">' + size + "</option>";
    });

    // Show the size dropdown container
    var sizeDropdownContainer = document.getElementById(
      "sizeDropdownContainer"
    );
    if (!sizeDropdownContainer) {
      throw new Error("Size dropdown container element not found");
    }
    sizeDropdownContainer.style.display = "block";

    // Add onchange event listener to the size dropdown
    sizeDropdown.addEventListener("change", function () {
      var selectedSize = this.value;
      document.getElementById("selectedSize").value = selectedSize;
      console.log("Selected size:", selectedSize);
      // Additional actions or event handling for size change can be added here
    });
  } catch (error) {
    console.error("Error fetching sizes:", error.message);
  }
}
