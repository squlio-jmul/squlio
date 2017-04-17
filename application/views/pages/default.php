<html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=$title?></title>
	<? require_once('header.php'); ?>
</head>

<body class="page-index">
	<div id="wrapper">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-1 left-panel <?=$left_panel_type?>">
					<? require_once('left_navbar.php'); ?>
				</div>
				<div class="col-xs-11 right-panel">
					<? require_once('right_navbar.php'); ?>
					<div id="page-content">
						<?=$content?>
					</div>
					<? require_once('footer.php'); ?>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
