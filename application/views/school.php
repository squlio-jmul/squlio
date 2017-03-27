<header class="admin-page-header">
	<h4>schools</h4>
	<a class="admin-logout" href="/logout">Logout</a>
</header>
<div class="admin-main-content">
	<div class="add-school">
	<h4><?=$school_amount?> SCHOOLS</h4>
		<button type=submit class="btn btn-primary">+ Add New</button>
	</div>
	<table id="table" class="display" cellspacing="0" width="100%" >
		<thead>
			<tr>
				<th>Id</th>
				<th>Name</th>
				<th>Principals</th>
				<th>Admins</th>
				<th>Teachers</th>
				<th>Students</th>
				<th>classroom</th>
				<th>status</th>
				<th>Action</th>
			</tr>

		</thead>
	</table>
</div>
