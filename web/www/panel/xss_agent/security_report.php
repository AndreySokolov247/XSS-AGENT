<?php
  include "./settings/sql_queries.php";
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
						<div class="menu-item ">
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

						<div class="menu-item active">
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
				<div class="card">
					<div class="tab-content p-4">
						
						<?php echo $html_content; ?>

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