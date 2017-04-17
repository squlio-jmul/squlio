<div id="sq-school-admin-dashboard-container" class="sq-container">
	<div class="row school-info">
		<div class="col-xs-1">
			<img src="<?=$img_path?>/school.png" class="img-responsive" />
		</div>
		<div class="col-xs-10">
			<div class="school-name">
				<?=$school_admin['school']['name']?>
			</div>
			<div class="school-address">
				<?=$school_admin['school']['address_1']?><br />
				<?=$school_admin['school']['city']?> <?=$school_admin['school']['zipcode']?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-3">
			<div class="widget">
				<?=number_format($classes_count)?> Classes
			</div>
		</div>
		<div class="col-xs-3">
			<div class="widget">
				<?=number_format($teachers_count)?> Teachers
			</div>
		</div>
		<div class="col-xs-3">
			<div class="widget">
				<?=number_format($students_count)?> Students
			</div>
		</div>
		<div class="col-xs-3">
			<div class="widget">
				<?=number_format($materials_count)?> Materials
			</div>
		</div>
	</div>
</div>
