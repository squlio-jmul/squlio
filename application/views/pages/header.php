	<link rel="shortcut icon" type="image/x-icon" href="<?=$img_path;?>/favicon/favicon.ico" />
	<link rel="icon" type="image/x-icon" href="<?=$img_path;?>/favicon/favicon.ico" />
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">
	<? if(!empty($headerJs)) : ?>
		<? foreach($headerJs as $js) : ?>
			<script type="text/javascript" src="<?=$js?>"></script>
		<? endforeach; ?>
	<? endif;?>
	<? if(!empty($headerCss)) : ?>
		<? foreach($headerCss as $css) : ?>
			<link href="<?=$css?>" rel="stylesheet" type="text/css">
		<? endforeach; ?>
	<? endif;?>
