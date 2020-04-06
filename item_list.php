<?php 
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
?>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container invoice-list-container">		
  <div>
  <a class="btn btn-warning back_btn" href="javascript:history.go(-1)">&#8592 Go Back</a>
  <!-- <a class="btn btn-info print_btn pull-right">Print</a> -->
  </div>
	  <h2 class="title">Item List</h2>		
    <?php 
    $ItemList = $invoice->getAllItems();
     if(empty($ItemList)){
      echo '<div class="alert alert-danger" role="alert">No Items Added Yet!</div>';	
    }
    else {  
    ?>	  
      <table id="data-table" class="table table-condensed table-striped">
        <thead>
          <tr>
            <th>Item No.</th>
            <th>Item Name</th>
            <th>Price</th>
          </tr>
        </thead>
        <?php		
        foreach($ItemList as $ItemDetails){
            echo '
              <tr>
                <td>'.$ItemDetails["item_number"].'</td>
                <td>'.$ItemDetails["item_name"].'</td>
                <td>'.$ItemDetails["item_price"].'</td>
              </tr>
            ';
        }
      }
        ?>
      </table>	
</div>	
<?php include('footer.php');?>