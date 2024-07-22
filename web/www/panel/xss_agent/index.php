<?php
  include "./settings/settings.php";

?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
	<!-- Mirrored from panel/xss_agent/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 11 Jul 2024 11:56:28 GMT -->
	<head>
		<meta charset="utf-8">
		<title>Xss-Agent | Dashboard</title>
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
			<div id="sidebar" class="app-sidebar">
				<div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
					<div class="menu">
						<div class="menu-header">Main</div>
						<div class="menu-item active">
							<a href="index.php" class="menu-link">
								<span class="menu-icon">
									<i class="bi bi-cpu"></i>
								</span>
								<span class="menu-text">Dashboard</span>
							</a>
						</div>
						<div class="menu-item">
							<a href="Bots.php" class="menu-link">
								<span class="menu-icon">
									<i class="bi bi-windows"></i>
								</span>
								<span class="menu-text">Bots</span>
							</a>
						</div>
						<div class="menu-header">____________________</div>
						<div class="menu-item">
							<a href="Agents.php" class="menu-link">
								<span class="menu-icon">
									<i class="bi bi-people"></i>
								</span>
								<span class="menu-text">Agents</span>
							</a>
						</div>
						<div class="menu-item">
							<a href="Logs.php" class="menu-link">
								<span class="menu-icon">
									<i class="bi bi-menu-button-wide"></i>
								</span>
								<span class="menu-text">Logs</span>
							</a>
						</div>

						<div class="menu-item">
							<a href="security_report.php" class="menu-link">
								<span class="menu-icon">
									<i class="bi bi-file-earmark-pdf-fill"></i>
								</span>
								<span class="menu-text">Security Reports</span>
							</a>
						</div>
					</div>
				</div>
			</div>
			<button class="app-sidebar-mobile-backdrop" data-toggle-target=".app" data-toggle-class="app-sidebar-mobile-toggled"></button>
			<div id="content" class="app-content">
				<div class="row">
					<div class="col-xl-3 col-lg-6">
						<div class="card mb-3">
							<div class="card-body">
								<div class="d-flex fw-bold small mb-3">
									<span class="flex-grow-1">CONNECTED BOTS</span>
									<a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none">
										<i class="bi bi-fullscreen"></i>
									</a>
								</div>
								<div class="row align-items-center mb-2">
									<div class="col-7">
										<h3 class="mb-0">4.2m</h3>
									</div>
									<div class="col-5">
										<div class="mt-n2" data-render="apexchart" data-type="bar" data-title="Visitors" data-height="30"></div>
									</div>
								</div>
								<div class="small text-inverse text-opacity-50 text-truncate">
									<i class="fa fa-chevron-up fa-fw me-1"></i> 33.3% more than last week <br>
								</div>
							</div>
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6">
						<div class="card mb-3">
							<div class="card-body">
								<div class="d-flex fw-bold small mb-3">
									<span class="flex-grow-1">EXECUTED COMMANDS</span>
									<a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none">
										<i class="bi bi-fullscreen"></i>
									</a>
								</div>
								<div class="row align-items-center mb-2">
									<div class="col-7">
										<h3 class="mb-0">$35.2K</h3>
									</div>
									<div class="col-5">
										<div class="mt-n2" data-render="apexchart" data-type="line" data-title="Visitors" data-height="30"></div>
									</div>
								</div>
								<div class="small text-inverse text-opacity-50 text-truncate">
									<i class="fa fa-chevron-up fa-fw me-1"></i> 20.4% more than last week <br>
								</div>
							</div>
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6">
						<div class="card mb-3">
							<div class="card-body">
								<div class="d-flex fw-bold small mb-3">
									<span class="flex-grow-1">AVAILABLE AGENTS</span>
									<a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none">
										<i class="bi bi-fullscreen"></i>
									</a>
								</div>
								<div class="row align-items-center mb-2">
									<div class="col-7">
										<h3 class="mb-0">03</h3>
									</div>
									<div class="col-5">
										<div class="mt-n3 mb-n2" data-render="apexchart" data-type="pie" data-title="Visitors" data-height="45"></div>
									</div>
								</div>
								<div class="small text-inverse text-opacity-50 text-truncate">
									<i class="fa fa-chevron-up fa-fw me-1"></i> 59.5% more than last week <br>
								</div>
							</div>
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6">
						<div class="card mb-3">
							<div class="card-body">
								<div class="d-flex fw-bold small mb-3">
									<span class="flex-grow-1">BANDWIDTH</span>
									<a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none">
										<i class="bi bi-fullscreen"></i>
									</a>
								</div>
								<div class="row align-items-center mb-2">
									<div class="col-7">
										<h3 class="mb-0">4.5TB</h3>
									</div>
									<div class="col-5">
										<div class="mt-n3 mb-n2" data-render="apexchart" data-type="donut" data-title="Visitors" data-height="45"></div>
									</div>
								</div>
								<div class="small text-inverse text-opacity-50 text-truncate">
									<i class="fa fa-chevron-up fa-fw me-1"></i> 5.3% more than last week <br>
								</div>
							</div>
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-6">
						<div class="card mb-3">
							<div class="card-body">
								<div class="d-flex fw-bold small mb-3">
									<span class="flex-grow-1">SERVER STATS</span>
									<a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none">
										<i class="bi bi-fullscreen"></i>
									</a>
								</div>
								<div class="ratio ratio-21x9 mb-3">
									<div id="chart-server"></div>
								</div>
								<div class="row">
									<div class="col-lg-6 mb-3 mb-lg-0">
										<div class="d-flex align-items-center">
											<div class="w-50px h-50px">
												<div data-render="apexchart" data-type="donut" data-title="Visitors" data-height="50"></div>
											</div>
											<div class="ps-3 flex-1">
												<div class="fs-10px fw-bold text-inverse text-opacity-50 mb-1">DISK USAGE</div>
												<div class="mb-2 fs-5 text-truncate">20.04 / 256 GB</div>
												<div class="progress h-3px bg-secondary-transparent-2 mb-1">
													<div class="progress-bar bg-theme" style="width: 20%"></div>
												</div>
												<div class="fs-11px text-inverse text-opacity-50 mb-2 text-truncate"> Last updated 1 min ago </div>
												<div class="d-flex align-items-center small">
													<i class="bi bi-circle-fill fs-6px me-2 text-theme"></i>
													<div class="flex-1">DISK C</div>
													<div>19.56GB</div>
												</div>
												<div class="d-flex align-items-center small">
													<i class="bi bi-circle-fill fs-6px me-2 text-theme text-opacity-50"></i>
													<div class="flex-1">DISK D</div>
													<div>0.50GB</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="d-flex">
											<div class="w-50px pt-3">
												<div data-render="apexchart" data-type="donut" data-title="Visitors" data-height="50"></div>
											</div>
											<div class="ps-3 flex-1">
												<div class="fs-10px fw-bold text-inverse text-opacity-50 mb-1">BANDWIDTH</div>
												<div class="mb-2 fs-5 text-truncate">83.76GB / 10TB</div>
												<div class="progress h-3px bg-secondary-transparent-2 mb-1">
													<div class="progress-bar bg-theme" style="width: 10%"></div>
												</div>
												<div class="fs-11px text-inverse text-opacity-50 mb-2 text-truncate"> Last updated 1 min ago </div>
												<div class="d-flex align-items-center small">
													<i class="bi bi-circle-fill fs-6px me-2 text-theme"></i>
													<div class="flex-1">HTTP</div>
													<div>35.47GB</div>
												</div>
												<div class="d-flex align-items-center small">
													<i class="bi bi-circle-fill fs-6px me-2 text-theme text-opacity-50"></i>
													<div class="flex-1">FTP</div>
													<div>1.25GB</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>
					</div>
					<div class="col-xl-6">
						<div class="card mb-3">
							<div class="card-body">
								<div class="d-flex fw-bold small mb-3">
									<span class="flex-grow-1">TRAFFIC ANALYTICS</span>
									<a href="#" data-toggle="card-expand" class="text-inverse text-opacity-50 text-decoration-none">
										<i class="bi bi-fullscreen"></i>
									</a>
								</div>
								<div class="ratio ratio-21x9 mb-3">
									<div id="world-map" class="jvectormap-without-padding"></div>
								</div>
								<div class="row gx-4">
									<div class="col-lg-6 mb-3 mb-lg-0">
										<table class="w-100 small mb-0 text-truncate text-inverse text-opacity-60">
											<thead>
												<tr class="text-inverse text-opacity-75">
													<th class="w-50">COUNTRY</th>
													<th class="w-25 text-end">VISITS</th>
													<th class="w-25 text-end">PCT%</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>FRANCE</td>
													<td class="text-end">13,849</td>
													<td class="text-end">40.79%</td>
												</tr>
												<tr>
													<td>SPAIN</td>
													<td class="text-end">3,216</td>
													<td class="text-end">9.79%</td>
												</tr>
												<tr class="text-theme fw-bold">
													<td>MEXICO</td>
													<td class="text-end">1,398</td>
													<td class="text-end">4.26%</td>
												</tr>
												<tr>
													<td>UNITED STATES</td>
													<td class="text-end">1,090</td>
													<td class="text-end">3.32%</td>
												</tr>
												<tr>
													<td>BELGIUM</td>
													<td class="text-end">1,045</td>
													<td class="text-end">3.18%</td>
												</tr>
											</tbody>
										</table>
									</div>
									<div class="col-lg-6">
										<div class="card">
											<div class="card-body py-2">
												<div class="d-flex align-items-center">
													<div class="w-70px">
														<div data-render="apexchart" data-type="donut" data-height="70"></div>
													</div>
													<div class="flex-1 ps-2">
														<table class="w-100 small mb-0 text-inverse text-opacity-60">
															<tbody>
																<tr>
																	<td>
																		<div class="d-flex align-items-center">
																			<div class="w-6px h-6px rounded-pill me-2 bg-theme bg-opacity-95"></div> FEED
																		</div>
																	</td>
																	<td class="text-end">25.70%</td>
																</tr>
																<tr>
																	<td>
																		<div class="d-flex align-items-center">
																			<div class="w-6px h-6px rounded-pill me-2 bg-theme bg-opacity-75"></div> ORGANIC
																		</div>
																	</td>
																	<td class="text-end">24.30%</td>
																</tr>
																<tr>
																	<td>
																		<div class="d-flex align-items-center">
																			<div class="w-6px h-6px rounded-pill me-2 bg-theme bg-opacity-55"></div> REFERRAL
																		</div>
																	</td>
																	<td class="text-end">23.05%</td>
																</tr>
																<tr>
																	<td>
																		<div class="d-flex align-items-center">
																			<div class="w-6px h-6px rounded-pill me-2 bg-theme bg-opacity-35"></div> DIRECT
																		</div>
																	</td>
																	<td class="text-end">14.85%</td>
																</tr>
																<tr>
																	<td>
																		<div class="d-flex align-items-center">
																			<div class="w-6px h-6px rounded-pill me-2 bg-theme bg-opacity-15"></div> EMAIL
																		</div>
																	</td>
																	<td class="text-end">7.35%</td>
																</tr>
															</tbody>
														</table>
													</div>
												</div>
											</div>
											<div class="card-arrow">
												<div class="card-arrow-top-left"></div>
												<div class="card-arrow-top-right"></div>
												<div class="card-arrow-bottom-left"></div>
												<div class="card-arrow-bottom-right"></div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="card-arrow">
								<div class="card-arrow-top-left"></div>
								<div class="card-arrow-top-right"></div>
								<div class="card-arrow-bottom-left"></div>
								<div class="card-arrow-bottom-right"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<a href="#" data-toggle="scroll-to-top" class="btn-scroll-top fade">
				<i class="fa fa-arrow-up"></i>
			</a>
		</div>


		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;">
			<div class="modal-dialog" role="document" style="display: flex; justify-content: center; align-items: center; height: 100vh;">
				<div class="modal-content" style="width: 100%; max-width: none; margin: auto;">
				<div class="card">
					<div class="card-body">
					<div class="p-3 bg-inverse bg-opacity-10 mb-0 rounded-3">
						<h4 style="text-align: center;">☢️ Disclaimer ☢️</h4>
						<hr class="my-2">
						<p class="lead" style="font-size: 0.9rem;">
						This tool is intended for authorized security testing and research purposes only. By using this tool, you agree to the following terms and conditions:
						</p>
						<ol>
						<li>You will only use this tool for legal and ethical purposes, such as testing your own systems or those you have explicit permission to test.</li>
						<li>You will not use this tool to gain unauthorized access to any systems or networks, or to cause any damage or disruption.</li>
						<li>You understand that the use of this tool may be subject to local laws and regulations, and you are responsible for ensuring that your use of the tool complies with all applicable laws.</li>
						<li>You will not use this tool to engage in any illegal or malicious activities, such as hacking, cracking, or distributing malware.</li>
						<li>You will not use this tool to violate the privacy or security of any individual or organization without their consent.</li>
						<li>You understand that the use of this tool is at your own risk, and the developers of this tool are not responsible for any damages or consequences that may arise from its use.</li>
						</ol>
						<p>
						By using this tool, you acknowledge that you have read and understood this disclaimer and agree to be bound by its terms and conditions.
						</p>
						<hr class="my-2">
						<div style="text-align: right;">
						<a class="btn btn-success btn-sm" href="#" role="button" id="agreeButton">
							<i class="bi bi-check-circle"></i> I Agree
						</a>
						</div>
					</div>
					</div>
					<div class="card-arrow">
					<div class="card-arrow-top-left"></div>
					<div class="card-arrow-top-right"></div>
					<div class="card-arrow-bottom-left"></div>
					<div class="card-arrow-bottom-right"></div>
					</div>
				</div>
				</div>
			</div>
		</div>

		<script>
			// Wait for the page to load
			window.addEventListener('load', function() {
				// Show the modal
				$('#myModal').modal({
					backdrop: 'static', // Prevent closing by clicking outside
					keyboard: false      // Prevent closing with the Esc key
				}).modal('show');

				// Close modal only on button click
				document.getElementById('agreeButton').addEventListener('click', function() {
					$('#myModal').modal('hide');
				});
			});
		</script>


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