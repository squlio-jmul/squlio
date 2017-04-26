<div id="sq-school-admin-dashboard-container" class="sq-container">
	<div class="row school-info">
		<a href="/school_admin/school_settings">
			<div class="col-xs-3">
				<div class="avatar-container" style="background-image: url(<?=($school_admin['school']['photo_url']) ? $school_admin['school']['photo_url'] : $img_path . '/no_image.png'?>)"></div>
			</div>
			<div class="col-xs-9">
				<div class="school-name">
					<?=$school_admin['school']['name']?>
				</div>
				<div class="school-address">
					<?=$school_admin['school']['address_1']?><br />
					<?=$school_admin['school']['city']?>, <?=$school_admin['school']['state']?> <?=$school_admin['school']['zipcode']?>
				</div>
			</div>
		</a>
	</div>
	<div class="row">
		<div class="col-xs-3">
			<a href="/school_admin/classes" class="redirect">
				<div class="widget">
					<?=number_format($classes_count)?> Class<?=($classes_count > 1 ) ? 'es' : ''?>
				</div>
			</a>
		</div>
		<div class="col-xs-3">
			<a href="/school_admin/teachers" class="redirect">
				<div class="widget">
					<?=number_format($teachers_count)?> Teacher<?=($teachers_count > 1 ) ? 's' : ''?>
				</div>
			</a>
		</div>
		<div class="col-xs-3">
			<a href="/school_admin/students" class="redirect">
				<div class="widget">
					<?=number_format($students_count)?> Student<?=($students_count > 1 ) ? 's' : ''?>
				</div>
			</a>
		</div>
		<div class="col-xs-3">
			<a href="/school_admin/subjects" class="redirect">
				<div class="widget">
					<?=number_format($subjects_count)?> Subject<?=($subjects_count > 1 ) ? 's' : ''?>
				</div>
			</a>
		</div>
	</div>
</div>
