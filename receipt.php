<?php 
session_start();
include('header.php');
include 'Invoice.php';
include 'ledger.php';
$success = false;
$error= '';
$invoice = new Invoice();
$ledger = new Ledger();
$invoice->checkLoggedIn();
$customerList = $ledger->getCustomerList();
if(isset($_POST['invoice_btn'])) {
	$customerId = $_POST['customerId'];
	if(empty($customerId)) {
		$error = "Please Select Customer First.";
	}

	else if(empty($_POST['invoiceNumber'])) {
		$error = "Please Enter Invoice Number.";
	}

	else if(!$invoice->validateInvoice($_POST['invoiceNumber'], $customerId)) {
		$error = "Invoice Not found for the current user!.";
	}
	
	else if(empty($_POST['paidAmount']) ) {
		$error = "Please enter amount to make payment.";
	}
	else {
		$due_amount = $invoice -> getTotalDue($_POST['invoiceNumber']);
		$updatedAmount = $due_amount - $_POST['paidAmount'];
		if($updatedAmount <=0) {
			$error = "Hey! It seems the due amount is less than this value. Please recheck from invoice list.";
		}
		else{
			$ledger->createReceipt($_POST);
			$invoice->updateDueAmount($updatedAmount, $_POST['invoiceNumber']);
			$success= true;
		}
		
	}
	
}
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container content-invoice">
	<div><a class="btn btn-warning back_btn" href="dashboard.php">&#8592 Go Back</a></div>
	<?php
		if($success) {
			echo '<div class="alert alert-success" role="alert">Payment saved Successfully!</div>';	
		}
		if(!empty($error)) {
			echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
		}
	?>
	<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate=""> 
		<div class="load-animate animated fadeInUp">
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<h2 class="title">Make Payment</h2>	
				</div>		    		
			</div>
			<input id="currency" type="hidden" value="$">
			<div class="row"> 
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 "></div>    		
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 ">
					<h4>From,</h4>
					<div class="form-group">
						<select class="form-control" name="customerId">
							<option value="0">Select Customer</option>
							<?php
							foreach($customerList as $customerValue)
							{
								echo '
								<option value="'.$customerValue["customer_id"].'">'.$customerValue["customer_name"].', '.$customerValue["customer_address"].'</option>';
							}
							 ?>
						
						</select>
                    </div>
						<div class="form-group">
							<h4>Invoice Number:</h4>
							<div class="input-group">
								<input value="" type="number" class="form-control" name="invoiceNumber" id="invoiceNumber" placeholder="Invoice Number">
							</div>

                    <div class="form-group">
							<h4>Amount Paid:</h4>
							<div class="input-group">
								<div class="input-group-addon currency">NRS</div>
								<input value="" type="number" class="form-control" name="paidAmount" id="paidAmount" placeholder="Paid Amount">
							</div>
                        </div>
                        <div class="form-group">
						<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
						<input data-loading-text="Saving Invoice..." type="submit" name="invoice_btn" value="Save Payment" class="btn btn-success submit_btn receipt-save-btn">						
					</div>
				</div>
			</div>
			<br/>
			<div class="clearfix"></div>		      	
		</div>
	</form>			
</div>
</div>	
<?php include('footer.php');?>