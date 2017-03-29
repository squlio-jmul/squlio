<header class="school-admin-page-header">
	<h4>DASHBOARD</h4>
	<div class="user-section">
		<ul class="user">
			<li class="user-tag">
			<p> Hello, <?=$username?> </p>
			</li>
			<li class="user-avatar">
			</li>
			<li class="logout">
				<a class="school-admin-logout" href="/logout">Logout</a>
			</li>
		</ul>
	</div>
</header>
<div class="school-admin-main-content">
	<div class"school-section">
		<div class="school-photo">
		</div>
		<div class="school-tag">
			<h3> <?=$school?> </h3>
			<h5> <?=$address?></h5> 
		</div>
	</div>
	<ul class="list-school-data">
		<li class="school-data">
			<div class="school-content">
				<h2><?=$classes?></h2>
				<p>Classes</p>
			</div>
		</li>
		<li class="school-data">
			<div class="school-content">
				<h2><?=$teachers?></h2>
				<p>Teachers</p>
			</div>
		</li>
		<li class="school-data">
			<div class="school-content">
				<h2><?=$students?></h2>
				<p>Students</p>
			</div>
		</li>
		<li class="school-data">
			<div class="school-content">
				<h2><?=$materials?></h2>
				<p>Materials</p>
			</div>
		</li>
	</ul>
</div>

