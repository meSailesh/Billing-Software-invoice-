<?php 
session_start();
include('header.php');
include 'Invoice.php';
include 'Ledger.php';
$companyNameError = false;
$invoice = new Invoice();
$ledger = new Ledger();
$invoice->checkLoggedIn();?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container-fluid dashboard">
<div class="row  header">
<h1 style="color:white">Dashboard</h1> 
</div>
  
  <div class="row">
  <div class="col-md-7">
    <div class="row menus">
    <div class="col-md-4">
        <a href="insert_item.php"><div class="panel">Insert Item</div></a>   
      </div>
         <div class="col-md-4">
      <a href="item_list.php"><div class="panel">Item List</div></a>   
      </div>
      <div class="col-md-4">
      <a href="create_invoice.php"><div class="panel">Create Invoice</div></a>   
      </div>
      <div class="col-md-4">
      <a href="receipt.php"><div class="panel">Make Payment</div></a>   
      </div>
      <div class="col-md-4">
      <a href="create_customer.php"><div class="panel">Add Customer</div></a>   
      </div>
      <div class="col-md-4">
        <a href="invoice_list.php"><div class="panel">Invoice List</div></a>   
      </div>
      <div class="col-md-4">
      <a href="customer_list.php"><div class="panel">Customer List</div></a>   
      </div>
    </div>
  </div>
    
  <div class="col-md-5">
    <div class="panel panel-default">
    <div class="panel-heading"><h3 style="color:#337ab7;">Notice Board</h3></div>
    <div class="panel-body">
    <ul class="list-group notices">
        <?php 
        include('notice_board.php');
        ?>
    </ul>
    </div>
    </div>
  </div>
  </div>
</div>

<?php include('footer.php');?>