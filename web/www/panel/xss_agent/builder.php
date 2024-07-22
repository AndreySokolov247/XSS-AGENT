<?php
  include "./settings/sql_queries.php";

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
  <!-- Mirrored from panel/xss_agent/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Jul 2024 11:56:28 GMT -->
  <head>
    <meta charset="utf-8">
    <title>Xss-Agent | Builder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content>
    <meta name="author" content>
    <link href="assets/css/vendor.min.css" rel="stylesheet">
    <link href="assets/css/app.min.css" rel="stylesheet">
    <link href="assets/plugins/jvectormap-next/jquery-jvectormap.css" rel="stylesheet">
  </head>
  <body class="theme-orange">
    <div id="app" class="app">
      <div id="header" class="app-header">
        <div class="mobile-toggler">
          <button type="button" class="menu-toggler" data-toggle-class="app-sidebar-mobile-toggled" data-toggle-target=".app">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
          </button>
        </div>
        <div class="brand">
          <a href="index.php" class="brand-logo">
            <span class="brand-img">
              <span class="brand-img-text text-theme">X</span>
            </span>
            <span class="brand-text">Xss-Agent</span>
          </a>
        </div>
        <div class="menu">
          <div class="menu-item dropdown dropdown-mobile-full">
            <a href="#" data-bs-toggle="dropdown" data-bs-display="static" class="menu-link">
              <div class="menu-icon">
                <i class="bi bi-bell nav-icon"></i>
              </div>
              <div class="menu-badge bg-theme"></div>
            </a>
						<div class="dropdown-menu dropdown-menu-end mt-1 w-300px fs-11px pt-1">
							<h6 class="dropdown-header fs-10px mb-1">NOTIFICATIONS</h6>
							<div class="dropdown-divider mt-1"></div>

							<hr class="my-0">
						</div>
          </div>
          <div class="menu-item">
            <a href="builder.php" id="builder_button" class="menu-link">
              <button type="button" class="btn btn-outline-theme">Builder</button>
            </a>
          </div>
        </div>
      </div>
      <button class="app-sidebar-mobile-backdrop" data-toggle-target=".app" data-toggle-class="app-sidebar-mobile-toggled"></button>
      <div id="content" class="app-content" style="width: 100%; height: 100%; margin: 0; padding: 2;">
        <div class="card">
          <div class="tab-content p-4">
            <div class="card-body d-flex flex-wrap">
              <div class="me-3 flex-grow-1">
                <label for="inputEndpoint" class="form-label">Endpoint</label>
                <input type="text" id="inputEndpoint" class="form-control" aria-describedby="endpointHelpBlock" placeholder="http://localhost/panel/xss_agent/endpoint/">
                <small id="endpointHelpBlock" class="form-text text-muted"> Please enter the endpoint URL. </small>
              </div>
              <div class="me-3">
                <label class="form-label">Architecture</label>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="architecture" id="architecture1" value="x86" checked>
                  <label class="form-check-label" for="architecture1">x86</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="architecture" id="architecture2" value="x64">
                  <label class="form-check-label" for="architecture2">x64</label>
                </div>
              </div>
              <div class="ms-auto mt-auto">
                <button type="button" id="generateImplantButton" class="btn btn-outline-theme">Generate the Implant</button>
              </div>
            </div>
          </div>

        <script>
            // Function to generate a random builder_id of 5 characters (uppercase letters and numbers)
            function generateBuilderId() {
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                var builderId = '';
                for (var i = 0; i < 5; i++) {
                    var randomIndex = Math.floor(Math.random() * characters.length);
                    builderId += characters.charAt(randomIndex);
                }
                return builderId;
            }

            // Function to send the second request to front_result.php
            function sendSecondRequest(builderId, buttonElement) {
                var xhr = new XMLHttpRequest();
                var formData = new FormData();
                formData.append("builder_id", builderId);

                xhr.open("POST", "./builder/front_result.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            var response = JSON.parse(xhr.responseText);
                            console.log("Response from front_result.php:");
                            console.log(response);

                            if (response.status === 'success') {
                                if (response.implant !== '') {
                                    // If implant link is available
                                    console.log("Received implant link:", response.implant);
                                    
                                    // Remove the existing button
                                    var generateImplantButton = document.getElementById("generateImplantButton");
                                    generateImplantButton.parentNode.removeChild(generateImplantButton);

                                    // Create a new button for download
                                    var downloadButton = document.createElement("button");
                                    downloadButton.setAttribute("type", "button");
                                    downloadButton.setAttribute("id", "downloadImplantButton");
                                    downloadButton.classList.add("btn", "btn-outline-theme");
                                    downloadButton.textContent = "Implant Download";
                                    downloadButton.disabled = false;

                                    // Add click event listener to initiate download
                                    downloadButton.addEventListener("click", function() {
                                        // Initiate download
                                        window.location.href = response.implant;

                                        // Disable button to prevent multiple clicks
                                        downloadButton.disabled = true;

                                        // Reload page after initiating download with a delay
                                        setTimeout(function() {
                                            //location.reload();
                                        }, 1000); // 1000 milliseconds (1 second) delay before reload
                                    });

                                    // Append the new button to the DOM
                                    var buttonContainer = document.querySelector('.ms-auto.mt-auto');
                                    buttonContainer.appendChild(downloadButton);
                                } else {
                                    // If no implant link is available
                                    console.log("No implant link found. Retrying in 1 second.");
                                    setTimeout(function() {
                                        sendSecondRequest(builderId, buttonElement);
                                    }, 1000); // 1000 milliseconds (1 second) delay before retry
                                }
                            } else {
                                // Handle error response
                                console.error("Error:", response.message);
                            }
                        } else {
                            // Handle HTTP error
                            console.error("Error fetching data. Status:", xhr.status);
                        }
                    }
                };
                xhr.send(formData);
            }

            // Event listener for the button click to generate builder
            var initialClickListener = function() {
                var endpoint = document.getElementById("inputEndpoint").value;
                var architecture = document.querySelector('input[name="architecture"]:checked').value;

                var builderId = generateBuilderId();

                var formData = new FormData();
                formData.append("endpoint_url", endpoint);
                formData.append("arc", architecture);
                formData.append("builder_id", builderId);

                var xhr = new XMLHttpRequest();
                xhr.open("POST", "./builder/create_builder.php", true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log("Generated builder_id:", builderId);
                        console.log(xhr.responseText);

                        // After successfully creating builder, start sending the second request
                        var generateImplantButton = document.getElementById("generateImplantButton");
                        generateImplantButton.innerHTML = 'Generating implant, please wait... <div class="spinner-grow spinner-grow-sm text-warning"></div>';
                        generateImplantButton.disabled = true;

                        sendSecondRequest(builderId, generateImplantButton);
                    }
                };
                xhr.send(formData);
            };

            // Event listener for the button click to generate builder
            document.getElementById("generateImplantButton").addEventListener("click", initialClickListener);
        </script>

          <div class="card-arrow">
            <div class="card-arrow-top-left"></div>
            <div class="card-arrow-top-right"></div>
            <div class="card-arrow-bottom-left"></div>
            <div class="card-arrow-bottom-right"></div>
          </div>
        </div>
      </div>
      <a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade">
        <i class="fa fa-arrow-up"></i>
      </a>
    </div>
    <script data-cfasync="false" src="../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="assets/js/vendor.min.js" type="7189fddf9ebfab541a8a31c2-text/javascript"></script>
    <script src="assets/js/app.min.js" type="7189fddf9ebfab541a8a31c2-text/javascript"></script>
    <script src="assets/plugins/jvectormap-next/jquery-jvectormap.min.js" type="7189fddf9ebfab541a8a31c2-text/javascript"></script>
    <script src="assets/plugins/jvectormap-content/world-mill.js" type="7189fddf9ebfab541a8a31c2-text/javascript"></script>
    <script src="assets/plugins/apexcharts/dist/apexcharts.min.js" type="7189fddf9ebfab541a8a31c2-text/javascript"></script>
    <script src="assets/js/demo/dashboard.demo.js" type="7189fddf9ebfab541a8a31c2-text/javascript"></script>
    <script src="../cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="7189fddf9ebfab541a8a31c2-|49" defer></script>
  </body>
</html>