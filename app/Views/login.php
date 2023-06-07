<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>ITF</title>
		<head>
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
label.error {
  color: red;
  font-size: 12px;
  margin-top: 5px;
}
input.error {
  border: 1px solid red;
}


  </style>
  <body>
  <div class="global-container">
	<div class="card login-form">
	<div class="card-body">
		<h3 class="card-title text-center">ITF Timesheet</h3>
		<div class="card-text">
    <?php if(session()->getFlashdata('msg')):?>
                    <div class="alert alert-warning">
                       <?= session()->getFlashdata('msg') ?>
                    </div>
                <?php endif;?>
			<!--
			<div class="alert alert-danger alert-dismissible fade show" role="alert">Incorrect username or password.</div> -->
			<form method="post" id="login-form" action="<?php echo base_url('loginAuth'); ?>">
  
				<!-- to error: add class "has-danger" -->
				<div class="form-group">
					<label for="exampleInputEmail1">Email address</label>
					<input type="email" name="email" id="email"class="form-control form-control-sm" id="exampleInputEmail1" aria-describedby="emailHelp">
				</div>
				<div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<a href="<?php echo base_url(); ?>/recover" style="float:right;font-size:12px;">Forgot password?</a>
					<input type="password" name="password" id="password" class="form-control form-control-sm" id="exampleInputPassword1">
				</div>
				<button type="submit" class="btn btn-primary btn-block">Sign in</button>
				
				<div class="sign-up">
				
				</div>
			</form>
		</div>
	</div>
</div>
</div>
  </body>
</html>

	<script>
  $(document).ready(function() {
    $("#login-form").validate({
      rules: {
        email: {
          required: true,
          email: true
        },
        password: {
          required: true
        }
      },
      messages: {
        email: {
          required: "Please enter your email address",
          email: "Please enter a valid email address"
        },
        password: {
          required: "Please enter your password"
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
  });
</script>

