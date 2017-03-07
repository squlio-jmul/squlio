<div class="admin-content-wrapper">
	<div class="admin-sidebar">
		<h3>Squlio</h3>
		<ul class="sidebar-nav">
			<li>
				<a class="active"  href="#dashboard">Dashboard</a>
			</li>
			<li>
				<a href=#">Schools</a>
			</li>
			<li>
				<a href="/admin/settings">App Settings</a>
			</li>
		</ul>
	</div>
	<div class="admin-content">
		<header class="admin-page-header">
			<h4>DASHBOARD</h4>
			<a class="admin-logout" href="/logout">Logout</a>
		</header>
		<div class="admin-main-content">
			<ul class="list-status">
				<li class="status">
					<div class="status-content">
						<h2><?=$school_amount?></h2>
						<p>SCHOOLS</p>
					</div>
				</li>
				<li class="status">
					<div class="status-content">
						<h2><?=$principal_amount?></h2>
						<p>PRINCIPLES</p>
					</div>
				</li>
				<li class="status">
					<div class="status-content">
						<h2><?=$admin_amount?></h2>
						<p>ADMINS</p>
					</div>
				</li>
			</ul>
		</div>
		<footer class="admin-footer">
			<p>Copyright &copy 2016-2017.Squl.io
		</footer>
	</div>
</div>

