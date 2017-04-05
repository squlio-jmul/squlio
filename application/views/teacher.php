<header class="school-admin-page-header">
	<h4>Teacher</h4>
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
	<div class="add-teacher" data-school-id="<?=$school_id?>">
	<h4><?=$teachers?> TEACHERS</h4>
		<button type=submit class="btn btn-primary">+ Add New</button>
	</div>
	<div class="school-dropdown">
		<label for="School"> Select a School </label>
		<select id="school">
			<option value="">Select One</option>
	<?
				if (isset($school)) {
					foreach($school as $s) {
	?>
						<option value="<?=$s['id']?>"><?=$s['name']?></option>
	<?
					}
				}
	?>
		</select>
	</div>
	<table id="table" class="display" cellspacing="0" width="100%" >
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Class</th>
				<th>Status</th>
			</tr>
		</thead>
	</table>
</div>
