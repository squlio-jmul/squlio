<div class="header">
	SQULIO
</div>
<ul class="nav nav-stacked">
<?
	switch($login_type) {
		case 'school_admin':
?>
			<li role="presentation" <?=($page_title == 'Dashboard') ? 'class="active"':''?>><a href="/school_admin">Dashboard</a></li>
			<li role="presentation" <?=($page_title == 'Classroom Grades') ? 'class="active"':''?>><a href="/school_admin/classroom_grades">Classroom Grades</a></li>
			<li role="presentation" <?=($page_title == 'Terms') ? 'class="active"':''?>><a href="/school_admin/terms">Terms</a></li>
			<li role="presentation" <?=($page_title == 'Subjects') ? 'class="active"':''?>><a href="/school_admin/subjects">Subjects</a></li>
			<li role="presentation" <?=($page_title == 'Classes') ? 'class="active"':''?>><a href="/school_admin/classes">Classes</a></li>
			<li role="presentation" <?=($page_title == 'Teachers') ? 'class="active"':''?>><a href="/school_admin/teachers">Teachers</a></li>
			<li role="presentation" <?=($page_title == 'Students') ? 'class="active"':''?>><a href="/school_admin/students">Students</a></li>
			<li role="presentation" <?=($page_title == 'Announcements') ? 'class="active"':''?>><a href="/school_admin/announcements">Announcements</a></li>
			<li role="presentation" <?=($page_title == 'Messages') ? 'class="active"':''?>><a href="/school_admin/messages">Messages <span class="badge sq-badge num-messages <?=($num_new_message ? '' : 'sq-hidden')?>"><?=$num_new_message?></span></a></li>
			<li role="presentation" <?=($page_title == 'School Settings') ? 'class="active"':''?>><a href="/school_admin/school_settings">School Settings</a></li>
<?
			break;
		default:
			break;
	}
?>
</ul>
