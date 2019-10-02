<?php 
session_start();
include('header.php');
include 'ledger.php';
include 'Invoice.php';
$invoice = new Invoice();
$ledger = new Ledger();
$invoice->checkLoggedIn();
if(!empty($_GET['update_id'])){
  $customerId = $_GET['update_id'];
  $companyDetails = $ledger->getCustomer($customerId);
  $transactions = $ledger->showTransactions($customerId);
  $arrayTransaction = array($transactions);
 // print_r($transactions);
}
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container invoice-list-container">	
  <div><a class="btn btn-warning back_btn" href="javascript:history.go(-1)">&#8592 Go Back</a></div>
	
	  <h2 class="title">PHP Invoice System</h2>	
    
 

 <div class="Container customer_detail_container">
 <div class="row customer-details-top">
 <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
 <h4><small>Customer Name</small>&nbsp&nbsp <?php echo $companyDetails["customer_name"] ?><h4>
 </div>
 <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
 <h4><small>Contact Number</small>&nbsp&nbsp <?php echo $companyDetails["customer_number"] ?><h4>
 </div>
 </div>
 <div class="row customer-details-bottom">
 <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
 <h4><small>Address</small>&nbsp&nbsp <?php echo $companyDetails["customer_address"] ?><h4>
 </div>
 <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
 <h4><small>PAN Number</small>&nbsp&nbsp <?php echo $companyDetails["customer_pan"] ?><h4>
 </div>
 </div>
 </div>
  	  
      <table id="data-table" class="table table-condensed table-striped">
        <thead>
          <tr>
            <th>Invoice Date</th>
            <th>Invoice Number</th>
            <th>Debited Amount</th>
            <th>Receipt Date</th>
            <th>Receipt Number</th>
            <th>Credited Amount</th>
            <th>Balance</th>
          </tr>
        </thead>
        <?php		

	        foreach($arrayTransaction as $transaction){
      $invoiceDate = date("d/M/Y", strtotime($transaction["order_date"]));
      $receiptDate = date("d/M/Y", strtotime($transaction["created_date"]));
            echo '
              <tr>
                <td>'.$invoiceDate.'</td>
                <td>'.$transaction["order_id"].'</td>
                <td>'.$transaction["order_total_amount_due"].'</td>
                <td>'.$receiptDate.'</td>
                <td>'.$transaction["receipt_id"].'</td>
                <td>'.$transaction["amount_paid"].'</td>
                <td>'.$transaction["amount_paid"].'</td>
                </tr>
            ';
        }       
        ?>
      </table>	
</div>	
<?php include('footer.php');?>