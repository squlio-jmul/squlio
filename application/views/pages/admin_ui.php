<!doctype html>
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
		<div class="admin-content-wrapper">
			<? require_once('admin-sidebar.php'); ?>
			<div class="admin-content">
				<?=$content?>
				<? require_once('footer.php');?>
			</div>
		</div>
	</div>
</body>
</html>