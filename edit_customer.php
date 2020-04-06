<?php 
session_start();
include('header.php');
include 'ledger.php';
$ledger = new Ledger();
$ledger->checkLoggedIn();
if(!empty($_POST['companyName']) && $_POST['companyName']) {	
	$ledger->saveInvoice($_POST);
	header("Location:invoice_list.php");	
}
if(!empty($_GET['customer_id'])){
	$customerId = $_GET['customer_id'];
	$customerValue = $ledger->getCustomer($customerId);
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
					<h2 class="title">Edit Customer</h2>
				</div>		    		
			</div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
					
					<div class="form-group">
						<input type="text" value="<?php echo $customerValue['customer_name']; ?>" class="form-control" name="companyName" id="companyName" placeholder="Company Name" autocomplete="off">
					</div>
					<div class="form-group">
						<textarea class="form-control" rows="3" name="companyAddress" id="address" placeholder="Company Address"><?php echo $customerValue['customer_address']; ?></textarea>
					</div>
					<div class="form-group">
						<input type="number" value="<?php echo $customerValue['customer_number']; ?>" class="form-control" name="companyPhone" id="companyName" placeholder="Company Phone" autocomplete="off">
                    </div>
                    <div class="form-group">
						<input type="number" value="<?php echo $customerValue['customer_pan']; ?>" class="form-control" name="companyPan" id="companyPan" placeholder="Company PAN Number" autocomplete="off">
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