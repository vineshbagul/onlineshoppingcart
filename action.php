<?php
	session_start();
	include('config.php');
	
	// --------------------------------insertdata for placeorder button from checkout page-------------------------------------------------------------
	if (isset($_POST['placeorder'])) {
		
		$people_id = $_POST['people_id'];
		$contact_id = $_POST['contact_id'];
		$address_id = $_POST['address_id'];
		$paymentinfo_id = $_POST['paymentinfo_id'];	
		
		$conn -> autocommit(FALSE);
		$conn->begin_transaction();
		
		try {       
		$conn ->query("INSERT INTO `orderheader`(`people_id`,`payment_id`, `order_date`, `billingaddress_id`, `status_id`,`contact_id`) 
		               VALUES ('$people_id','$paymentinfo_id',CURRENT_DATE(),'$address_id','2','$contact_id');");
		
		
		$qry="SELECT max(order_id) as order_id FROM `orderheader`";
		$result=mysqli_query($conn,$qry);
		$data=mysqli_fetch_assoc($result);
		$order_id=$data['order_id'];
		
		
		$qry="SELECT product_id,product_price,quantity,total_price,discount_amount,final_amount FROM cart WHERE people_id='$people_id';";
        $result = $conn->query($qry);
        while ($row = $result->fetch_assoc()){
		$product_id      = $row['product_id'];
		$product_price   = $row['product_price'];
		$quantity        = $row['quantity'];
		$total_price     = $row['total_price'];
		$discount_amount = $row['discount_amount'];
		$final_amount    = $row['final_amount'];
		
		$conn ->query("INSERT INTO `orderitem`(`order_id`, `product_id`, `quantity`, `order_date`, `total_price`, `final_amount`, `discount_amount`) VALUES ('$order_id','$product_id','$quantity',CURRENT_DATE(),'$total_price','$final_amount','$discount_amount')");
		}
		$conn ->query("DELETE FROM `cart` where people_id='$people_id'");
		$conn->commit();
		header('location:thankyou.php');
		}catch (mysqli_sql_exception $exception) {
			$conn->rollback();
			throw $exception;
			}
	 }
	
	
// --------------------------------insert address from profile page-----------------------------------------------------------------------------------
	if (isset($_POST['addresssave'])) {
		$house_no 	 = $_POST['houseno'];
		$street_no 	 = $_POST['streetno'];
		$street_name = $_POST['streetname'];
		$locality 	 = $_POST['locality'];
		$landmark 	 = $_POST['landmark'];
		$zip_code 	 = $_POST['zipcode'];
		$city 		 = $_POST['city'];
		$state 		 = $_POST['state'];
		$country_id  = $_POST['country_id'];
		$people_id   = $_POST['people_id']; 
		
		$query = "INSERT INTO address (`people_id`,`house_no`,`street_no`,`street_name`,`locality`,`landmark`,`zip_code`,`city`,`state`,`country_id`) 
			      VALUES ('$people_id','$house_no','$street_no','$street_name','$locality','$landmark','$zip_code','$city','$state','$country_id')";
		$results = mysqli_query($conn,$query);
		header('location:profile.php');
	 }

// --------------------------------insert payment from profile page-----------------------------------------------------------------------------------
	if (isset($_POST['paymentsave'])) {
		$payment_type_id = $_POST['payment_type_id'];
		$card_no         = $_POST['card_no'];
		$bank      	     = $_POST['bank']; 
		$expdate   	     = $_POST['expdate'];
		$people_id       = $_POST['people_id']; 
				
		$query = "INSERT INTO `payment_info`(`payment_type_id`, `bank_name`, `card_no`, `exp_date`, `people_id`) 
				  VALUES ('$payment_type_id','$bank','$card_no','$expdate','$people_id')";
		$results = mysqli_query($conn,$query);
		header('location:profile.php');
	 }

// -------------------------------- insert contact from profile page----------------------------------------------------------------------------------
	if (isset($_POST['contactsave'])) {
		$phoneno_typeid = $_POST['phonenotype_id'];
		$phone_no       = $_POST['contactnumber'];
		$people_id      = $_POST['people_id']; 
				
		$query = "INSERT INTO `contact`(`phoneno_typeid`, `phone_no`, `people_id`) VALUES ('$phoneno_typeid','$phone_no','$people_id')";
		$results = mysqli_query($conn,$query);
		header('location:profile.php');
	 }

// --------------------------------sign up--------------------------------------------------------------------------------------------------------------
	if (isset($_POST['registration'])) {
			$f_name 	 	 = $_POST['f_name'];
			$l_name 	 	 = $_POST['l_name'];
			$dob 		 	 = $_POST['dob'];
			$email 		 	 = $_POST['Email'];
			$password 	 	 = $_POST['Password'];
			$house_no 	 	 = $_POST['houseno'];
			$street_no 	 	 = $_POST['streetno'];
			$street_name 	 = $_POST['streetname'];
			$locality 	 	 = $_POST['locality'];
			$landmark 	 	 = $_POST['landmark'];
			$zip_code 	 	 = $_POST['zipcode'];
			$city 		 	 = $_POST['city'];
			$state 		 	 = $_POST['state'];
			$country_id  	 = $_POST['country_id'];
			$phonenotype_id  = $_POST['phonenotype_id'];
			$phone_no 		 = $_POST['phone_no'];
			$payment_type_id = $_POST['payment_type_id'];
			$bank_name 		 = $_POST['bank_name'];
			$card_no 	     = $_POST['card_no'];
			$exp_date 		 = $_POST['exp_date'];
			
			$conn -> autocommit(FALSE);
			$conn->begin_transaction();
			
			try {
			$conn->query("INSERT INTO `people`(`f_name`,`l_name`,`dob`,`email_id`,`password`,`role_id`) 
			VALUES ('$f_name','$l_name','$dob','$email','$password','1')");
			
			$qry="SELECT max(people_id) as people_id FROM `people`";
			
			$result=mysqli_query($conn,$qry);
			$data=mysqli_fetch_assoc($result);
			$id=$data['people_id'];
			
			$conn->query("INSERT INTO `address`(`people_id`, `house_no`, `street_no`, `street_name`, `locality`, `landmark`, `zip_code`, `city`, `state`, `country_id`) 
						  VALUES ('$id','$house_no','$street_no','$street_name','$locality','$landmark','$zip_code','$city','$state','$country_id')");
			
			$conn->query("INSERT INTO `payment_info`(`people_id`,`payment_type_id`,`bank_name`,`card_no`,`exp_date`) 
				          VALUES ('$id','$payment_type_id','$bank_name','$card_no','$exp_date')");

			
			$conn->query("INSERT INTO `contact`(`phoneno_typeid`,`phone_no`,`people_id`) VALUES ('$phonenotype_id','$phone_no','$id')");

			$conn->commit();
		    header('location:index.php');
			} catch (mysqli_sql_exception $exception) {
			$conn->rollback();
			throw $exception;
			}
			
}


// -----------------------------------------------------------------------------------------------------------------------------------------------------
	// Add products into the cart table
	if (isset($_POST['pid'])) {
	  
	  $pid 		   = $_POST['pid'];
	  $pprice 	   = $_POST['pprice'];
	  $pqty 	   = $_POST['pqty'];
	  $people_id   = $_POST['people_id'];
	  $total_price = $pprice * $pqty;
	  
	  
	  $qry="SELECT `discount_amount` FROM `discount` where `product_id`='$pid' and `quantity`='$pqty';";
	  $result1=mysqli_query($conn,$qry);
	  $data=mysqli_fetch_assoc($result1);
	  $row=mysqli_num_rows($result1);
	  if($row<1){
	  $discount_amt = 0;
	  }else
	  {
		$discount_amt=$data['discount_amount'];
	  }
	  $final_amount = $total_price - $discount_amt;
	  
	  $query="INSERT INTO `cart`(`people_id`, `product_id`, `quantity`, `total_price`, `product_price`,`discount_amount`, `final_amount`) VALUES ('$people_id','$pid','$pqty','$total_price','$pprice','$discount_amt','$final_amount')";
	  $results = mysqli_query($conn,$query);
	}

// ---------------------------------------------------------------------------------------------------------------------------------------------
	//Get no.of items available in the cart table
	// if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
	  // $stmt = $conn->prepare('SELECT * FROM cart');
	  // $stmt->execute();
	  // $stmt->store_result();
	  // $rows = $stmt->num_rows;

	  // echo $rows;
	// }
// ---------------------------------------------------------------------------------------------------------------------------------------------
	// Remove all items at once from cart
	if (isset($_GET['people_id'])) {
		
	  $people_id = $_GET['people_id'];
	
	  $qry="DELETE FROM `cart` WHERE `people_id`='$people_id'";
	  $result=mysqli_query($conn,$qry);
	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'All Item removed from the cart!';
	  header('location:cart.php');
	}
?>