document.addEventListener("DOMContentLoaded", function () {
  // Fetch sales data using AJAX
  fetchSalesData();
});

function fetchSalesData() {
  // Use AJAX to fetch sales data from your server
  // Adjust the URL based on your server endpoint
  fetch("get_sales_data.php")
    .then((response) => response.json())
    .then((data) => {
      console.log(data);

      // Call function to render the chart with the fetched data
      renderSalesChart(data);
    })
    .catch((error) => console.error("Error fetching sales data:", error));
}

function renderSalesChart(salesData) {
  var ctx = document.getElementById("salesChart").getContext("2d");

  // Extract dates and amounts from the sales data
  var dates = salesData.map((item) => item.date);
  var amounts = salesData.map((item) => item.order_price);

  // Create the chart
  var salesChart = new Chart(ctx, {
    type: "bar", // You can change the chart type (bar, line, etc.)
    data: {
      labels: dates,
      datasets: [
        {
          label: "Sales Amount",
          data: amounts,
          backgroundColor: "rgba(75, 192, 192, 0.2)", // Color for bars
          borderColor: "rgba(75, 192, 192, 1)", // Border color for bars
          borderWidth: 1, // Border width for bars
        },
      ],
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
        },
      },
    },
  });
}
