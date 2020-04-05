 <?php
 $IsDue = false;  
 $today= strtotime(date("Y/m/d"));
 $invoiceList = $invoice ->getInvoiceList();
foreach($invoiceList as $invoice){
  $originalOrderDate = $invoice['order_date'];
  $dueAmount = (float)$invoice['order_total_amount_due'];
  $customerId = $invoice['customer_id'];
  $invoiceId = $invoice['order_id'];
  $parsedDate = strtotime(date("Y-m-d",strtotime($originalOrderDate )));
  $difference =  (int)(($today - $parsedDate)/60/60/24);

  if($difference >= 15 && $dueAmount > 0){
    $customer = $ledger -> getCustomer($customerId);
    echo'<li class="list-group-item alert-warning">Unpaid invoice of <b>'.$customer['customer_name'].'</b>\'s invoice no. <b>'.$invoiceId.'</b> for '.$difference.' days.</li>';
    $IsDue = true;
  }
  
}
if(!$IsDue){
  echo'<li class="list-group-item alert-success">We are good! No due payments.</li>';
}
    ?>