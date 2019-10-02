 <?php 
    $db= new mysqli("localhost", "root", "","billing_software")or die("Couldn't connect to database");

    $sql_invoice="SELECT * FROM `invoice_order` ORDER BY `order_date` ASC";
    

    $run_invoice=mysqli_query($db,$sql_invoice);
    


    function get_customer($id){
      $sql_customer="select * from customers";
      $run_customer=mysqli_query( $GLOBALS['db'],$sql_customer);
      while($row=mysqli_fetch_array($run_customer)){
        if($id==$row['customer_id']){
        $customer_name=$row['customer_name'];
        return $customer_name;
        }
      }
    }

    

    while($row=mysqli_fetch_array($run_invoice)){
      $today= strtotime(date("Y/m/d"));
      $original_order_date = $row['order_date'];
      $only_date = strtotime(date("Y-m-d",strtotime($original_order_date)));
      $value = ($today - $only_date)/60/60/24;

      $id_p=$row['customer_id'];
      
      if($value>=15 && ($row['order_total_amount_due']>0) ){
        $name=get_customer($id_p);
        echo "<li class='list-group-item notice-information'>Unpaid invoice of <b>".$name."</b>'s invoice no. <b>".$row['order_id']."</b> for ".$value." days.<tr>";
      }
      else{ 
        echo '<div class="alert alert-success" role="alert">We are good!</div>';	
        }

     
    }
    ?>