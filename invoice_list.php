<?php 
session_start();
include('header.php');
include 'ledger.php';
include 'Invoice.php';
require("nepali-date.php");
$ledger = new Ledger();
$invoice = new Invoice();
$nepali_date = new nepali_date();
$invoice->checkLoggedIn();
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container invoice-list-container">		
  <div><a class="btn btn-warning back_btn" href="javascript:history.go(-1)">&#8592 Go Back</a></div>
	  <h2 class="title">Invoice List</h2>		
    <?php 
    $invoiceList = $invoice->getInvoiceList();
     if(empty($invoiceList)){
      echo '<div class="alert alert-danger" role="alert">No Transactions Yet!</div>';	
    }
    else {  
    ?>	  
      <table id="data-table" class="table table-condensed table-striped">
        <thead>
          <tr>
            <th>Invoice No.</th>
            <th>Created Date</th>
            <th>Customer Name</th>
            <th>Invoice Total</th>
            <th>Amount Due </th>
            <th>Print</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <?php		
        foreach($invoiceList as $invoiceDetails){
          $customerDetails = $ledger -> getCustomer($invoiceDetails['customer_id']);
			    $invoiceDate = $invoiceDetails['order_date'];
          $date = $invoice -> NepaliDate($invoiceDate, $nepali_date);
          
            echo '
              <tr>
                <td>'.$invoiceDetails["order_id"].'</td>
                <td>'.$date['y'].'-'.$date['m'].'-'.$date['d'].'</td>
                <td>'.$customerDetails["customer_name"].'</td>
                <td>'.$invoiceDetails["order_total_after_tax"].'</td>
                <td>'.$invoiceDetails["order_total_amount_due"].'</td>
                <td><a href="print_invoice.php?invoice_id='.$invoiceDetails["order_id"].'" title="Print Invoice"><span class="glyphicon glyphicon-print"></span></a></td>
                <td><a href="edit_invoice.php?update_id='.$invoiceDetails["order_id"].'"  title="Edit Invoice"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a href="#" id="'.$invoiceDetails["order_id"].'" class="deleteInvoice"  title="Delete Invoice"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
            ';
        }
      }
        ?>
      </table>	
</div>	
<?php include('footer.php');?>