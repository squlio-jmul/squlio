<div id="sq-login-container">
	<div class="logo-container">
		<img class="img-responsive" src="<?=$img_path?>/logo-squlio.png" />
	</div>
	<div class="form-container">
		<form id="login-form">
			<div class="form-group">
				<input type="text" name="email" class="form-control" placeholder="Email" value="" />
			</div>
			<div class="form-group">
				<input type="password" name="password" class="form-control" placeholder="Password" value="" />
			</div>
			<button type="submit" class="button login-button">Login</button>
			<div class="error-container"></div>
			<div class="center margintop10">
				<a href="" class="forgot-password small">Forgot password</a>
			</div>
		</form>
	</div>
	<p class="copyright">Copyright &copy; 2016 - <?=date('Y')?>. Squl.io</p>
	<div class="bg-gray"></div>
</div>
