<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed tz-navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<div class="page-title"><?=$page_title?></div>
		</div>
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-right border-left most-right">
				<? if ($login_type == 'school_admin') : ?>
					<li class="hello">Hello, <?=$user_obj['username']?></li>
					<li class="dropdown border-left">
						<a href="#" class="dropdown-toggle avatar" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="navbar-username"><img src="<?=$img_path?>/avatar.png" class="avatar-logo" /></a>
						<ul class="dropdown-menu">
							<li><a href="/logout">Log Out</a></li>
						</ul>
					</li>
				<? endif; ?>
			</ul>
		</div>
	</div>
</nav>
