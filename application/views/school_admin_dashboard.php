<div id="sq-school-admin-dashboard-container" class="sq-container">
	<div class="row school-info">
		<div class="col-xs-2">
			<img src="<?=($school_admin['school']['photo_url']) ? $school_admin['school']['photo_url'] : $img_path . '/no_image.png'?>" class="img-responsive" />
		</div>
		<div class="col-xs-8">
			<div class="school-name">
				<?=$school_admin['school']['name']?>
			</div>
			<div class="school-address">
				<?=$school_admin['school']['address_1']?><br />
				<?=$school_admin['school']['city']?>, <?=$school_admin['school']['state']?> <?=$school_admin['school']['zipcode']?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-3">
			<div class="widget">
				<?=number_format($classes_count)?> Class<?=($classes_count > 1 ) ? 'es' : ''?>
			</div>
		</div>
		<div class="col-xs-3">
			<div class="widget">
				<?=number_format($teachers_count)?> Teacher<?=($teachers_count > 1 ) ? 's' : ''?>
			</div>
		</div>
		<div class="col-xs-3">
			<div class="widget">
				<?=number_format($students_count)?> Student<?=($students_count > 1 ) ? 's' : ''?>
			</div>
		</div>
		<div class="col-xs-3">
			<div class="widget">
				<?=number_format($materials_count)?> Material<?=($materials_count > 1 ) ? 's' : ''?>
			</div>
		</div>
	</div>
</div>
