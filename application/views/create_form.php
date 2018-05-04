<!DOCTYPE html>
<html lang="en">
<head>
	<title>Bootstrap Example</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
		<!-- Brand/logo -->
		<a class="navbar-brand" href="#">Form Creator</a>

		<!-- Links -->
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="#">Link 1</a>
			</li>
		</ul>
	</nav>
	<div class="container">
		<div class="row mt-4">
			<?php echo form_open('form/create',array('class' => 'form-inline')); ?>
				<div class="col">
					<label for="formname">Form name:</label>
				</div>
				<div>
					<input type="text" class="form-control" id="fname" placeholder="Form name" name="fname">
				</div>
				<div>
					<button type="submit" class="btn btn-primary">Submit</button>
				</div>
			</form>
		</div>
		<div><?php echo validation_errors(); ?></div>
	</div>
</body>
</html>