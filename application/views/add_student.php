<header class="school-admin-page-header">
	<h4>Add Student</h4>
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
	<form id="add-student-form">
		<div class="student-form-container">
			<div class="avatar-container">
				<div class="avatar">
				</div>
				<div class="upload-btn">
					<span class="btn btn-default btn-file ">
						Upload <input type="file" hidden />
					</span>
				</div>
			</div>
			<div class="add-student" data-num-students="<?=$num_student?>" data-current-students="<?=$students?>">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username" class="form-control" placeholder="Student username" value="" />
				</div>
				<div class="form-group">
					<label for="classroom">Class</label>
					<select id="classroom" class="form-control">
						<option value="">Select One</option>
					<?
							if (isset($classroom)) {
								foreach ($classroom as $c ) {
					?>
									<option value="<?=$c['id']?>"><?=$c['name']?></option>
					<?
								}
							}
					?>
					</select>
				</div>
				<div class="form-left">
					<div class="form-group">
						<label for="email">Email</label>
						<input type="email" name="email" class="form-control" placeholder="Student email" value="" />
					</div>
					<div class="form-group">
						<label for="first_name">First Name</label>
						<input type="text" name="first_name" class="form-control" placeholder="Student first name" value="" />
					</div>
					<div class="form-group">
						<label for="gender">Gender</label>
						<select id="gender" class="form-control">
							<option value="">Select One</option>
							<option value="male">Male</option>
							<option value="female">Female</option>
						</select>
				</div>

				</div>
				<div class="form-right">
					<div class="form-group">
						<label for="password">Password</label>
						<input type="password" name="password" class="form-control" placeholder="Student password" value="" />
					</div>
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<input type="text" name="last_name" class="form-control" placeholder="Studentt last name" value="" />
					</div>
					<div class="form-group">
						<label for="birthday">Birthday</label>
						<input type="text" id="birthday" name="birthday" class="form-control" placeholder="Student birthday" value="" />
					</div>
				</div>
				<div class="add-parents">
					<h5>Parents</h5>
					<div class="form-father">
						<div class="form-group">
							<label for="father">Father</label>
							<input type="hidden" name="guardian_type" value="father" />
						</div>
						<div class="form-group">
							<input type="text" name="father_username" class="form-control" placeholder="Parents username" value="" />
						</div>
						<div class="form-group">
							<input type="email" name="father_email" class="form-control" placeholder="Parents email" value="" />
						</div>
						<div class="form-group">
							<input type="password" name="father_password" class="form-control" placeholder="Parents password" value="" />
						</div>
						<div class="form-group">
							<input type="text" name="father_first_name" class="form-control" placeholder="Parents first name" value="" />
						</div>
						<div class="form-group">
							<input type="text" name="father_last_name" class="form-control" placeholder="Parents last name" value="" />
						</div>
						<div classs="form-group">
							<input type="text" name="father_phone" class="form-control" placeholder="Parents phone number" value="" />
						</div>
					</div>
					<div class="form-mother">
						<div class="form-group">
							<label for="mother">Mother</label>
							<input type="hidden" name="guardian_type" value="mother" />
						</div>
						<div class="form-group">
							<input type="text" name="mother_username" class="form-control" placeholder="Parents username" value="" />
						</div>
						<div class="form-group">
							<input type="email" name="mother_email" class="form-control" placeholder="Parents email" value="" />
						</div>
						<div class="form-group">
							<input type="password" name="mother_password" class="form-control" placeholder="Parents password" value="" />
						</div>
						<div class="form-group">
							<input type="text" name="mother_first_name" class="form-control" placeholder="Parents first name" value="" />
						</div>
						<div class="form-group">
							<input type="text" name="mother_last_name" class="form-control" placeholder="Parents last name" value="" />
						</div>
						<div classs="form-group">
							<input type="text" name="mother_phone" class="form-control" placeholder="Parents phone number" value="" />
						</div>
					</div>
				</div>
			</div>
			<div class="student-status">
				<div class="status-container">
					<h4>Status</h4>
					<select id="status">
						<option value="">Select One </option>
						<option value="1">Active</option>
						<option value="0">Deleted</option>
					</select>
					<button type="submit" class="save-btn">Save</button>
					<button type="reset" class="reset-btn">Delete</button>
				</div>
			</div>
		</div>
	</form>
</div>
