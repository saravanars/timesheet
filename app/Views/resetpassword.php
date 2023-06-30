

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Reset password</title>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
  </head>
  <style>
    html,body { 
	height: 100%; 
}

.global-container{
	height:100%;
	display: flex;
	align-items: center;
	justify-content: center;
	background-color: #f5f5f5;
}

form{
	padding-top: 10px;
	font-size: 14px;
	margin-top: 30px;
}

.card-title{ font-weight:300; }

.btn{
	font-size: 14px;
	margin-top:20px;
}


.login-form{ 
	width:330px;
	margin:20px;
}

.sign-up{
	text-align:center;
	padding:20px 0 0;
}

.alert{
	margin-bottom:-30px;
	font-size: 13px;
	margin-top:20px;
}
/* Error message styling */
label.error {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}

/* Input field styling with error */
input.error {
  border: 1px solid red;
}

  </style>
  <body>
  <div class="global-container">
	<div class="card login-form">
	<div class="card-body">
		<h3 class="card-title text-center">Forget Password</h3>
		<div class="card-text">
    <?php if(session()->getFlashdata('msg')):?>
                    <div class="alert alert-warning">
                       <?= session()->getFlashdata('msg') ?>
                    </div>
                <?php endif;?>
			<!--
			<div class="alert alert-danger alert-dismissible fade show" role="alert">Incorrect username or password.</div> -->
			<form method="post"  id="form" action="<?php echo base_url(); ?>update">
  
				<!-- to error: add class "has-danger" -->
				<div class="form-group">
					<label for="exampleInputPassword1">Entry New Password</label>
					<input type="password" name="password" class="form-control form-control-sm" id="exampleInputPassword1"  onkeyup='check()'>
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Confirm Password</label>
				
					<input type="password" name="confirmpassword" class="form-control form-control-sm" id="InputPassword1" onkeyup='check()'>
				</div>
        <input type="hidden" name="id" value="<?php ($id);?>">
				<button type="submit" class="btn btn-primary btn-block">Confirm</button>
<!-- 				
				<div class="sign-up">
				<p>Don't have an account ? <a href="">Create One</a></p>
				</div> -->
			</form>
		</div>
	</div>
</div>
</div>
  </body>
</html>
<script>
	$(document).ready(function() {
  $("#form").validate({
    rules: {
      password: {
        required: true,
        minlength: 6
      },
      confirmpassword: {
        required: true,
        equalTo: "#exampleInputPassword1"
      }
    },
    messages: {
      password: {
        required: "Please enter a password",
        minlength: "Your password must be at least 6 characters long"
      },
      confirmpassword: {
        required: "Please confirm your password",
        equalTo: "Passwords do not match"
      }
    }
  });
});

</script>