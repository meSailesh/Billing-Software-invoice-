<?php 
session_start();
$emptyError = '';
include('header.php');
include 'ledger.php';
$ledger = new Ledger();
$ledger->checkLoggedIn();
if(!empty($_POST))
{
if(!empty($_POST['companyName']) && !empty($_POST['companyAddress']) && !empty($_POST['companyPhone']))
{	
	$ledger->insertCustomer($_POST);
	header("Location:customer_list.php");	
}
else{
	$emptyError = "You cannot leave mandatory field empty!";
}
}
?>

<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container content-invoice">
		<div><a class="btn btn-warning back_btn" href="javascript:history.go(-1)">&#8592 Go Back</a></div>
	<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate=""> 
		<div class="load-animate animated fadeInUp">
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<h2 class="title">Add New Customer</h2>
				</div>		    		
			</div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			
					<div class="form-group">
						<?php
						 if ($emptyError ) { ?>
						<div class="alert alert-warning"><?php echo $emptyError; ?></div>
						<?php } ?>
					</div>
					<div class="form-group">
                        <label for="companyName">Customer Name</label><span class="mandatory">*</span>
						<input type="text" class="form-control" name="companyName" id="companyName" autocomplete="off">
					</div>
					<div class="form-group">
                        <label for ="companyAddress">Address</label><span class="mandatory">*</span>
						<textarea class="form-control" rows="3" name="companyAddress" id="companyAddress"></textarea>
					</div>
					<div class="form-group">
                        <label for="companyPhone">Phone Number</label><span class="mandatory">*</span>
						<input type="number" class="form-control" name="companyPhone" id="companyPhone" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="companyPan">PAN Number</label>
        
						<input type="number" class="form-control" name="companyPan" id="companyPan" placeholder="optional" autocomplete="off">
                    </div>
                    <div class="form-group">
						<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
						<input data-loading-text="Saving Details..." type="submit" name="customer_btn" value="Save Details" class="btn btn-success submit_btn customer-save-btm">						
					</div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
            </div>
    		<div class="clearfix"></div>		      	
		</div>
	</form>			
</div>
</div>	
<?php include('footer.php');?>