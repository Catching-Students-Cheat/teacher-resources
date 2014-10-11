<?php
	$id = isset($_GET['id'])?$_GET['id']:null;
	$post = isset($_POST)?$_POST:null;
?>
<!DOCTYPE HTML>
<html>

	<head>
		<title>catching students cheat</title>

		<meta name="description" content="Catching students cheat.">
		<meta name="keywords" content="catching students cheat.">

		<link href="html/css/reset.css" rel="stylesheet" type="text/css">
		<link href="html/css/styles.css" rel="stylesheet" type="text/css">

		<script>
			document.createElement('article');
			document.createElement('section');
			document.createElement('aside');
			document.createElement('hgroup');
			document.createElement('nav');
			document.createElement('header');
			document.createElement('footer');
			document.createElement('figure');
			document.createElement('figcaption');
		</script>

	</head>

	<body>

		<div id="wrapper">

			<header>

				<div id="logo">
					<img src="html/images/catching-students-cheat.png" width="394" height="146" alt="catching students cheat">
				</div>

				<nav>

					<ul>
						<!--header menu-->
						<?php
						//echo $_GET['id'];
							include_once dirname(__FILE__).'/lib/headerMenu.php';
							$headerMenu = new HeaderMenu($id);
							echo $headerMenu->run();
						?>
					</ul>

				</nav>

			</header>

			<div id="content">
				<?php
					include_once dirname(__FILE__).'/lib/mainContent.php';
					$mainContent = new MainContent(__DIR__,$id,$post);
					echo $mainContent->run();
				?>
			</div>
			<!-- /end #content-->

			<div id="rightcol">

				<aside>

					<?php
						include_once dirname(__FILE__).'/lib/rightCol.php';
						$rightCol = new RightCol(__DIR__);
						echo $rightCol->run();
					?>
				</aside>

			</div>
			<!-- /end #rightcol-->

			<footer>
				<p>
					<a href="http://texasintegratedservices.com"  target="_blank">Texas Integrated Services</a> &copy; 2014
				</p>
			</footer>

		</div>
		<!-- /end #wrapper-->
	</body>
</html>