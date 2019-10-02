<?php 
session_start();
include('header.php');
include 'Invoice.php';
include 'ledger.php';
$invoice = new Invoice();
$ledger = new Ledger();
$ledger->checkLoggedIn();
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container customer-list-container">		
    <div><a class="btn btn-warning back_btn" href="javascript:history.go(-1)">&#8592 Go Back</a></div>
	  <h2 class="title">PHP Invoice System</h2>	
      <a class="btn btn-success" href="create_customer.php" type="button">+ Add New Customer</a>	
      <?php
      $ledgerList = $ledger->getCustomerList();
      if(empty($ledgerList)){
        echo '<div class="alert alert-danger" role="alert">No Customers Yet!</div>';
      }
      else { ?>	  
      <table id="data-table" class="table table-condensed table-striped">
        <thead>
          <tr>
          <th>Customer Name</th>
            <th>Customer Address</th>
            <th>Phone Number</th>
            <th>Pan Number</th>
            <th> Edit Details</th>
            <th>Transactions</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
        <?php		
		
        foreach($ledgerList as $ledgerDetails){
			$ledgerDate = date("d/M/Y, H:i:s", strtotime($ledgerDetails["created_date"]));
            echo '
              <tr>
                <td>'.$ledgerDetails["customer_name"].'</td>
                <td>'.$ledgerDate.'</td>
                <td>'.$ledgerDetails["customer_name"].'</td>
                <td>'.$ledgerDetails["customer_name"].'</td>
                <td><a href="edit_customer.php?customer_id='.$ledgerDetails["customer_id"].'"  title="Edit Customer Details"><span class="glyphicon glyphicon-edit"></span></a></td>
                <td><a href="transactions.php?update_id='.$ledgerDetails["customer_id"].'"  title="View Transactions"><span class="glyphicon glyphicon-file"></span></a></td>
                <td><a href="#" id="'.$ledgerDetails["customer_id"].'" class="deleteInvoice"  title="Delete Customer"><span class="glyphicon glyphicon-remove"></span></a></td>
              </tr>
            ';
        } 
      }      
        ?>
        </tbody>
      </table>	
</div>	
<?php include('footer.php');?>