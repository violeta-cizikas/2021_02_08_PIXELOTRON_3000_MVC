<?php
require APPROOT . '/views/inc/header.php'; ?>
<!-- jumbotron - demonstracine bootstrapo klase -->
<div class="jumbotron jumbotron-fluid">
		<div class="container">
			<h1>Register</h1>
			<!-- kuriama register forma --> 
			<form method="post">
				<div class="form-group">
					<input name="firstname" type="text" class="form-control <?php echo (!empty($data['firstnameErr'])) ? 'is-invalid' : ''; ?>" placeholder="First Name">
					<span class='invalid-feedback'><?php echo $data['firstnameErr'] ?></span>
				</div>

				<div class="form-group">
					<input name="lastname" type="text" class="form-control <?php echo (!empty($data['lastnameErr'])) ? 'is-invalid' : ''; ?>" placeholder="Last Name">
					<span class='invalid-feedback'><?php echo $data['lastnameErr'] ?></span>
				</div>

				<div class="form-group">
					<input name="email" type="text" class="form-control <?php echo (!empty($data['emailErr'])) ? 'is-invalid' : ''; ?>" placeholder="Email">
					<span class='invalid-feedback'><?php echo $data['emailErr'] ?></span>
				</div>

				<div class="form-group">
					<input name="password" type="password" class="form-control <?php echo (!empty($data['passwordErr'])) ? 'is-invalid' : ''; ?>" placeholder="Password">
					<span class='invalid-feedback'><?php echo $data['passwordErr'] ?></span>
				</div>

				<div class="form-group">
					<input name="confirmPassword" type="password" class="form-control <?php echo (!empty($data['confirmPasswordErr'])) ? 'is-invalid' : ''; ?>" placeholder="Confirm password">
					<span class='invalid-feedback'><?php echo $data['confirmPasswordErr'] ?></span>
				</div>

				<button type="submit" class="btn btn-primary">Register</button>
			</form>
	</div>
</div>

<!-- footeryje uzdaromas html'as ir body -->
<?php require APPROOT . '/views/inc/footer.php';