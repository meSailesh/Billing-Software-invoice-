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
  $totalDue = $ledger -> getTotalBalance($customerId);
  $companyDetails = $ledger->getCustomer($customerId);
  $transactions = $ledger->getAllTransaction($customerId);
  //$arrayTransaction = array($transactions);
}
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container invoice-list-container">	
  <div><a class="btn btn-warning back_btn" href="javascript:history.go(-1)">&#8592 Go Back</a></div>
	
	  <h2 class="title">Transactions</h2>	
    
 

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

    <div class="container-fluid">
    <div class="row alert alert-info text-center"><b>Total Due Balance: Rs <?php echo $totalDue ?><b></div>
    <?php
  foreach($transactions as $transaction)
  {
    $invoiceId = $transaction["order_id"];
    $initialPayment = $ledger ->initialPayment($invoiceId);
    //print_r($initialPayment);
    $transactionDetails = $ledger -> TransactionDetails($invoiceId);
    $InvoiceDue = $invoice ->getTotalDue($invoiceId);

    if($initialPayment['paid'] > 0){
      $paymentDetails = array();
      $paymentDetails['Id'] = 0;
      $paymentDetails['Date'] = $initialPayment['date'];
      $paymentDetails['Amount'] = $initialPayment['paid'];
      $paymentDetails['Type'] = "Initial Payment";
      array_push($transactionDetails, $paymentDetails);
    }
  
   //print_r($transactionDetails);
  ?>
    <div class="row">
    <div class="col-lg-2"></div>
    <div class="col-lg-8">
    <div class="panel panel-primary">
    <div class="panel-heading">Invoice Details</div>
    <div class="panel-body">
    <table id="data-table" class="table table-condensed">
    <thead>
      <tr>
      <th>Transaction Id</th>
        <th>Transaction Date</th>
        <th>Transaction Type</th>
        <th>Amount</th>          
      </tr>
    </thead>
    <tbody>
   
      <?php
        foreach($transactionDetails as $detail){
          echo'
          <tr>
             <td>'.$detail['Id'].'</td>
             <td>'.$detail['Date'].'</td>
             <td>'.$detail['Type'].'</td>
             <td>'.$detail['Amount'].'</td>
             </tr>';    
        } 
      ?>
    
    </tbody>
    </table>
    </div>
    <div class="panel-footer">Invoice-Due: Rs <?php echo $InvoiceDue; ?></div>
  </div>
    </div>
    <div class="col-lg-2"></div>
    
    </div>
  
  <?php
  }
 ?>
<p class="alert alert-warning">Note* : Transaction id equals invoice id and receipt id for credit and debit transactions respectively.</p>
</div>
</div>	
<?php include('footer.php');?>