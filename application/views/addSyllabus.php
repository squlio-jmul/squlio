<div id="addsyllabus-container">
	<h2>Add Syllabus Form</h2>
	<form id="addsyllabus-form">
		<div class="form-group">
			<label for="term"> Select a Term </label>
			<select id="term">
				<option value=""> - Select One - </option>
			<?
				if (isset($term)){
					foreach($term as $t){
			?>
						<option value="<?=$t['id']?>"><?=$t['name']?></option>
			<?
					}
				}
			?>
			</select>
		</div>
		<div class="form-group">
			<label for="classroom"> Select a Classroom </label>
			<select id="classroom">
				<option value=""> - Select One - </option>
			<?
				if (isset($classroom)){
					foreach($classroom as $c){
			?>
						<option value="<?=$c['id']?>"><?=$c['name']?></option>
			<?
					}
				}
			?>
			</select>
		</div>
		<div class="form-group">
			<label for="classroom_subject"> Select a Classroom Subject </label>
			<select id="classroom_subject">
				<option value=""> - Select One - </option>
			<?
				if (isset($classroom_subject)){
					foreach($classroom_subject as $cs){
			?>
						<option value="<?=$cs['id']?>"><?=$cs['name']?></option>
			<?
					}
				}
			?>
			</select>
		</div>
		<div class="form-group">
			<label for="title">Title</label>
			<input type="text" name="title" class="form-control" placeholder="Title" value="" />
		</div>
		<div class="form-group">
			<label for="description">Description</label>
			<input type="textarea" name="description" class="form-control" placeholder="Description" value="" />
		</div>
		<div class="form-group">
			<label for="date">Date</label>
			<input type="text" id = "date" name="date" class="form-control" placeholder="date" value ="">
		</div>
		<button type="submit" class="btn btn-primary">Submit</button>
		<button type="reset" class="btn btn-primary">Cancel</button>
		<br></br>
		<div id="success-container"></div>
		<div class="error-container"></div>
	</form>
</div>
