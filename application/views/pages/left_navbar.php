<div class="header">
	SQULIO
</div>
<ul class="nav nav-stacked">
<?
	switch($login_type) {
		case 'school_admin':
?>
			<li role="presentation" <?=($page_title == 'Dashboard') ? 'class="active"':''?>><a href="/school_admin">Dashboard</a></li>
			<li role="presentation" <?=($page_title == 'Terms') ? 'class="active"':''?>><a href="/school_admin/terms">Terms</a></li>
			<li role="presentation" <?=($page_title == 'Classes') ? 'class="active"':''?>><a href="/school_admin/classes">Classes</a></li>
			<li role="presentation" <?=($page_title == 'Teachers') ? 'class="active"':''?>><a href="/school_admin/teachers">Teachers</a></li>
			<li role="presentation" <?=($page_title == 'Students') ? 'class="active"':''?>><a href="/school_admin/students">Students</a></li>
			<li role="presentation" <?=($page_title == 'Materials') ? 'class="active"':''?>><a href="/school_admin/materials">Materials</a></li>
			<li role="presentation" <?=($page_title == 'Announcements') ? 'class="active"':''?>><a href="/school_admin/announcements">Announcements</a></li>
			<li role="presentation" <?=($page_title == 'Messages') ? 'class="active"':''?>><a href="/school_admin/messages">Messages</a></li>
			<li role="presentation" <?=($page_title == 'School Settings') ? 'class="active"':''?>><a href="/school_admin/school_settings">School Settings</a></li>
<?
			break;
		default:
			break;
	}
?>
</ul>
