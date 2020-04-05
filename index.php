<?php 
session_start();
include('header.php');
$loginError = '';
if (!empty($_POST['email']) && !empty($_POST['pwd'])) {
	include 'Invoice.php';
	$invoice = new Invoice();
	$user = $invoice->loginUsers($_POST['email'], $_POST['pwd']); 
	if(!empty($user)) {
		$_SESSION['user'] = $user[0]['first_name']."".$user[0]['last_name'];
		$_SESSION['userid'] = $user[0]['id'];
		$_SESSION['email'] = $user[0]['email'];		
		$_SESSION['address'] = $user[0]['address'];
		$_SESSION['mobile'] = $user[0]['mobile'];
		header("Location:dashboard.php");
	} else {
		$loginError = "Invalid email or password!";
	}
}
?>
<title>Billing & Invoice Software</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
</head>
<div class= "container-fluid" style= "min-height:95vh">
<div class="row">	
	<div class="demo-heading">
		<h2 style= "text-align: center;">Welcome to Billing Software</h2>
	</div>
	<div class="login-form">		
		<h4>Admin Login:</h4>		
		<form method="post" action="">
			<div class="form-group">
			<?php 
			echo $loginError;
			if ($loginError ) { ?>
				<div class="alert alert-warning"><?php echo $loginError; ?></div>
			<?php } ?>
			</div>
			<div class="form-group">
				<input name="email" id="email" type="email" class="form-control" placeholder="Email address" autofocus="" required>
			</div>
			<div class="form-group">
				<input type="password" class="form-control" name="pwd" placeholder="Password" required>
			</div>  
			<div class="form-group">
				<button type="submit" name="login" class="btn btn-success">Login</button>
			</div>
		</form>		
	</div>		
</div>		
</div>
</div> 
<?php include('footer.php');?>