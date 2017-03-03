<div id="admin-container">
<div class ="row">
	<div class="center-wrapper">
		<div class="logo">
			<img class="logo-img" src="/public/img/logo-squlio.png" alt="squlio logo">
		</div>
		<div class="panel panel-default">
			<div class="panel-body">
				<form id="admin-form" class="form-active">
					<div class="form-group">
						<input type="email" name="email" class="form-control" placeholder="Email" value="" />
					</div>
					<div class="form-group">
						<input type="password" name="password" class="form-control" placeholder="Password" value="" />
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Login</button>
					</div>
					<a class="forget-password" href="#admin-forget-password">Forget Password </a>
				</form>
				<form id="admin-forget-password">
					<p>Forgot your password? Enter email to reset.</p>
					<div class="form-group">
						<input type="email" name="email" class="form-control" placeholder="Email" value="" />
					</div>
					<div class="form-group">
						<button type="submit" class="btn btn-primary">RESET PASSWORD</button>
					</div>
					<a class="login-link" href="#admin-form">Login</a>
				</form>
				<div class="error-container"></div>
			</div>
		</div>
	</div>
</div>
</div>

