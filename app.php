<?php
/**********************************************8
this program is to include required page by user

creator:- raman tehlan
date of creation:- 03/02/2017
************************************************/



						$page = "dashboard";

						if(isset($_GET['page'])){

						switch ($_GET['page']) {
							case 'dashboard':
									$page = "dashboard";
							break;
							case 'analysis':
									$page = "analysis";
							break;
							case 'data_upload':
									$page = "data_upload";
							break;
							case 'image_upload':
									$page = "image_upload";
							break;
							default:
									$page = "dashboard";	
							break;
						}

						}

?>

<!DOCTYPE html>
<html>
	<head>
				<title>APP</title>

				<link rel="stylesheet" href="http://localhost/assets/style/jquery-ui.css">
				<link rel="stylesheet" href="http://localhost/assets/style/comman-ui.css">
				<link rel="stylesheet" href="http://localhost/assets/style/app-ui.css">

				<script type="text/javascript" src="http://localhost/assets/script/jquery.js"></script>
				<script type="text/javascript" src="http://localhost/assets/script/jquery-ui.js"></script>
				<script type="text/javascript" src="http://localhost/assets/script/effect.lib.js"></script>
	</head>
	<body>

			<?php 
					include "menu.fragment.php";
			?>
			<div class='main_frame '>

					<?php

						include $page . ".php";

					?>

			</div>

	</body>	
</html>