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
if(isset($_POST['item_btn'])) {
  $invoice -> insertItems($_POST);
  $success = true;

}
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container content-invoice">
	<div><a class="btn btn-warning back_btn" href="javascript:history.go(-1)">&#8592 Go Back</a></div>
	<?php
		if($success) {
			echo '<div class="alert alert-success" role="alert">Items saved Successfully!</div>';	
		}
		if(!empty($error)) {
			echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
		}
	?>
	<form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate=""> 
		<div class="load-animate animated fadeInUp">
			<div class="row">
				<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
					<h2 class="title">Insert New Items</h2>	
				</div>		    		
			</div></br></br>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
					<table class="table table-bordered table-hover" id="insertItem" >	
						<tr>
							<th width="4%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
							<th width="48%">Item Name</th>
							<th width="48%">Price</th>								
						</tr>							
						<tr>
							<td><input class="itemRow" type="checkbox"></td>
							
							<td><input type="text" name="productName[]" id="productName_1" class="form-control" autocomplete="off"></td>			
							<td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
						</tr>						
					</table>
			</div>
      </div>
			<div class="row my-2">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 ">
					<button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
					<button class="btn btn-success" id="addItemRows" type="button">+ Add More</button>
				</div>
        </div>
      <div class="clearfix"></div>	
      <div class="form-group center">
						<input type="hidden" value="<?php echo $_SESSION['userid']; ?>" class="form-control" name="userId">
						<input data-loading-text="Saving Items..." type="submit" name="item_btn" value="Save Items" class="btn btn-primary submit_btn receipt-save-btn">						
					</div>	      	
		</div>
	</form>			
</div>
</div>	
<?php include('footer.php');?>