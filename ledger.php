<?php
class Ledger{
	private $host  = 'localhost';
    private $user  = 'root';
    private $password   = "";
    private $database  = "billing_software";   
	private $CustomerTable = 'customers';	
		private $ReceiptTable = 'receipt';
		private $InvoiceTable = 'invoice_order';
	private $invoiceOrderItemTable = 'invoice_order_item';
  private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data= array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[]=$row;            
		}
		return $data;
	}

	private function getField($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$data = mysqli_fetch_field($result);            
		return $data;
	}

	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function viewCustomers($limit=0) {
		$sqlQuery = "
			SELECT customer_id, created_date, customer_name, customer_address, customer_number, customer_pan 
			FROM ".$this->CustomerTable." 
			ORDER BY customer_name ASC LIMIT".$limit;
        return  $this->getData($sqlQuery);
	}	
	public function checkLoggedIn(){
		if(!$_SESSION['userid']) {
			header("Location:index.php");
		}
	}
	public function createReceipt($POST){
		$sqlInsert = "
			INSERT INTO ".$this->ReceiptTable."(user_id, customer_id, invoice_id, amount_paid) 
			VALUES ('".$POST['userId']."','".$POST['customerId']."', '".$POST['invoiceNumber']."', '".$POST['paidAmount']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);    	
	}		
	public function insertCustomer($POST) {		
		$sqlInsert = "
			INSERT INTO ".$this->CustomerTable."(user_id, customer_name, customer_address, customer_number, customer_pan) 
			VALUES ('".$POST['userId']."','".$POST['companyName']."', '".$POST['companyAddress']."', '".$POST['companyPhone']."', '".$POST['companyPan']."')";		
		mysqli_query($this->dbConnect, $sqlInsert);    	
	}	
	public function updateCustomer($POST) {
		if($POST['customerId']) {	
			$sqlInsert = "
				UPDATE ".$this->CustomerTable." 
				SET customer_name = '".$POST['companyName']."', customer_address= '".$POST['companyAddress']."', customer_number = '".$POST['companyPhone']."', customer_pan = '".$POST['companyPan']."' 
				WHERE user_id = '".$POST['userId']."' AND customer_id = '".$POST['customerId']."'";		
			mysqli_query($this->dbConnect, $sqlInsert);	
		}		
		$this->deleteInvoiceItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {			
			$sqlInsertItem = "
				INSERT INTO ".$this->invoiceOrderItemTable."(order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_final_amount) 
				VALUES ('".$POST['invoiceId']."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);			
		}       	
	}	
	public function getCustomerList(){
		$sqlQuery = "
			SELECT * FROM ".$this->CustomerTable." 
			WHERE user_id = '".$_SESSION['userid']."'";
		return  $this->getData($sqlQuery);
	}	
	public function getCustomer($customerId){
		$sqlQuery = "
			SELECT * FROM ".$this->CustomerTable." 
			WHERE user_id = '".$_SESSION['userid']."' AND customer_id = '$customerId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}	
	
	public function deleteInvoiceItems($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);				
	}
	public function deleteInvoice($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deleteInvoiceItems($invoiceId);	
		return 1;
	}

	public function showTransactions($customerId){
		$sqlQuery = "
		SELECT A.order_date, A.order_id, A.order_total_amount_due, B.created_date,B.receipt_id, B.amount_paid FROM invoice_order A LEFT JOIN receipt B ON A.type = B.type WHERE A.customer_id = '$customerId' UNION ALL SELECT A.order_date, A.order_total_amount_due,A.order_id, B.created_date, B.amount_paid,B.receipt_id FROM invoice_order A RIGHT JOIN receipt B ON A.type = B.type WHERE B.Customer_id = '$customerId'" ;
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}
}
?> 