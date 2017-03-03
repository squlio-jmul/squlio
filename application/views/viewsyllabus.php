<div id="viewsyllabus-container">
	<h2> View Syllabus </h2>
	<br></br>
	<div class="form-group">
		<label for="classroom"> Select a Classroom</label>
		<select id="classroom">
			<option value=""> - Select One - </option>
		<?
			if (isset($classroom)) {
				foreach($classroom as $c){
		?>
					<option value="<?=$c['id']?>"><?=$c['name']?></option>
		<?
				}
			}
		?>
		</select>
		<br></br>
		<label for="term"> Select a term </label>
		<select id="term">
			<option value=""> - Select One -</option>
		<?
			if(isset($term)){
				foreach($term as $t){
		?>
					<option value="<?=$t['id']?>"><?=$t['name']?></option>
		<?
				}
			}
		?>
		</select>
	</div>
	<br></br>
	<table id = "table" class="display" cellspacing="0" width="100%">
		<thead>
			<tr>
				<th>Id</th>
				<th>School id</th>
				<th>Term id</th>
				<th>Classroom id</th>
				<th>Classroom subject id</th>
				<th>Title</th>
				<th>Description</th>
				<th>Created on</th>
				<th>Last updated</th>
			</tr>
		</thead>
	</table>
	<br></br>
</div>
