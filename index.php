<?php

include_once("link/link-2.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="assets/scss/ui-login.scss"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.0.0-beta.20/css/uikit.css">
    <link rel="stylesheet" href="assets/scss/navigationTrue-a-j.scss">
    <link rel="stylesheet" href="assets/scss/revenue.scss">
    <link rel="stylesheet" href="assets/scripts/module/test/test.scss">
    <script src="assets/scripts/module/test/test.js"></script>
    <script src="assets/scripts/script-bash.js"></script>
    
  <title>Document</title>
</head>
<body>
  <div class="page-wrapper">
    
    <main class="page-content mt-0">
      <div class="my-login-page">
        <section class="h-100">
		      <div class="container h-100">
		      	<div class="row justify-content-md-center h-100">
		      		<div class="card-wrapper">
		      			<div class="brand">

		      			</div>
		      			<div class="card fat">
		      				<div class="card-body">
		      					<h4 class="card-title">Login</h4>
		      					<form class="my-login-validation" action="backend/chk.login.php" method="POST">
		      						<div class="form-group">
		      							<label for="username">username</label>
		      							<input id="username" type="text" class="form-control" name="username" value="" required autofocus>
		      							<div class="invalid-feedback">
		      								Email is invalid
		      							</div>
		      						</div>

		      						<div class="form-group">
		      							<label for="password">Password
		      							</label>
		      							<input id="password" type="password" class="form-control" name="password" required data-eye>
		      						    <div class="invalid-feedback">
		      						    	Password is required
		      					    	</div>
		      						</div>

		      						<div class="form-group m-0">
		      							<button type="submit" class="btn btn-primary btn-block">
		      								Login
		      							</button>
		      						</div>
		      						<div class="mt-4 text-center">
		      							Don't have an account? <a href="register.html">Create One</a>
		      						</div>
		      					</form>
		      				</div>
		      			</div>
		      			<div class="footer">
		      				Copyright &copy; 2017 &mdash; Your Company 
		      			</div>
		      		</div>
		      	</div>
		      </div>
	      </section>
      </div>
    </main>
  </div>
  <script src="assets/scripts/login.js"></script>
</body>
</html>