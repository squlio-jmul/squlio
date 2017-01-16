<!DOCTYPE ! html>
<html>
<head>
	<meta name "viewport" content = "width=device-width, initial-scale=1.0">
	<title> Sign Up Form </title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<div class = "container">
<div class = "row">
	<div class = "col-md-6 col-md-offset-3">
		<?php echo $this->session->flashdata('verify_msg'); ?>
	</div>
</div>

<div class = "row">
	<div class = "col-md-6 col-md-offset-3">
		<div class = "panel panel-default">
			<div class = "panel-heading">
				<h4>User Registration Form</h4>
			</div>
			<div class = "panel-body">
				<?php $attributes = array("name" => "signupform");
				echo form_open("welcome/signup", $attributes);?>
				<div class = "form-group">
					<label for = "username">User Name </label>
					<input class = "form-control" name = "username" placeholder = "Your user name" type = "text" value = "" />
					<span class = "text-danger"></span>
				</div>
			
				<div class = "form-group">
					<label for = "email"> Email </label>
					<input class = "form-control" name = "email" placeholder = "Your email" value = "" />
					<span class = "text-danger"> </span>
				</div>

				<div class = "form-group">
					<label for = "password">Password</label>
					<input class = "form-control" name = "password" placeholder = "your password" type = "password" />
					<span class = "text-danger"></span>
				</div>
				
				<div class = "form-group">
					<label for = "first_name"> First name </label>
					<input class = "form-control" name = "first_name" placeholder = "Your first name" type = "text" value = "" />
					<span class = "text-danger"></span>
				</div>
				
				<div class = "form-group">
					<label for = "last_name"> Last Name </label>
					<input class = "form-control" name = "last_name" placeholder = "Your last name" type = "text" value = "" />
					<span class = "text-danger"></span>
				</div> 

				<div class = "form-group">
					<button name = "submit" type = "submit" class = "btn btn-default">Sign Up </button>
					<button name = "cancel" type = "reset" class = "btn btn-default">Cancel </button>
				</div>
				<?php echo form_close(); ?>
				<?php //echo $this->session->flashdata('msg') ?>
				
			</div>
		</div>
	</div>
</div>
</div>
</body>
</html>
