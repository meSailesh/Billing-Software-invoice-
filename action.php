<?php
session_start();
include 'Invoice.php';
$invoice = new Invoice();


	
if($_POST['action'] == 'delete_invoice' && $_POST['id']) {
	$invoice->deleteInvoice($_POST['id']);	
	$jsonResponse = array(
		"status" => 1	
	);
	echo json_encode($jsonResponse);	
}

if($_POST['action'] == 'fill_fields' && $_POST['id']) {
	$details = $invoice->getItemDetails($_POST['id']);	
	$jsonResponse = array(
		"name" => $details->item_name,
		"price" => $details->item_price
	);
	echo json_encode($jsonResponse);	
}



