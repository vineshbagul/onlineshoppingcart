<?php
				session_start();
				include('config.php');
			// --------------------------------registration------------------------------------------
			if (isset($_POST['registration'])) {
			$f_name = $_POST['f_name'];
			$l_name = $_POST['l_name'];
			$dob = $_POST['dob'];
			$email = $_POST['Email'];
			$password = $_POST['Password'];
			$house_no = $_POST['houseno'];
			$street_no = $_POST['streetno'];
			$street_name = $_POST['streetname'];
			$locality = $_POST['locality'];
			$landmark = $_POST['landmark'];
			$zip_code = $_POST['zipcode'];
			$city = $_POST['city'];
			$state = $_POST['state'];
			$country_id = $_POST['country_id'];
			$phonenotype_id = $_POST['phonenotype_id'];
			$phone_no = $_POST['phone_no'];
			$payment_type_id = $_POST['payment_type_id'];
			$bank_name = $_POST['bank_name'];
			$card_no = $_POST['card_no'];
			$exp_date = $_POST['exp_date'];
			
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

			} catch (mysqli_sql_exception $exception) {
			$conn->rollback();
			throw $exception;
			}
			
}

	// Add products into the cart table
	if (isset($_POST['pid'])) {
	  $pid = $_POST['pid'];
	  $pname = $_POST['pname'];
	  $pprice = $_POST['pprice'];
	  $pimage = $_POST['pimage'];
	  $pcode = $_POST['pcode'];
	  $pqty = $_POST['pqty'];
	  $total_price = $pprice * $pqty;
	  $stmt = $conn->prepare('SELECT product_code FROM cart WHERE product_code=?');
	  $stmt->bind_param('s',$pcode);
	  $stmt->execute();
	  $res = $stmt->get_result();
	  $r = $res->fetch_assoc();
	  $code = $r['product_code'] ?? '';
	  if (!$code) {
	    $query = $conn->prepare('INSERT INTO cart (product_name,product_price,product_image,qty,total_price,product_code) VALUES (?,?,?,?,?,?)');
	    $query->bind_param('ssssss',$pname,$pprice,$pimage,$pqty,$total_price,$pcode);
	    $query->execute();
	    echo '<div class="alert alert-success alert-dismissible mt-2">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>Item added to your cart!</strong>
	</div>';
	  } else {
	    echo '<div class="alert alert-danger alert-dismissible mt-2">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>Item already added to your cart!</strong>
	</div>';
	  }
	}
	// Get no.of items available in the cart table
	if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
	  $stmt = $conn->prepare('SELECT * FROM cart');
	  $stmt->execute();
	  $stmt->store_result();
	  $rows = $stmt->num_rows;
	  echo $rows;
	}
	// Remove single items from cart
	if (isset($_GET['remove'])) {
	  $id = $_GET['remove'];
	  $stmt = $conn->prepare('DELETE FROM cart WHERE id=?');
	  $stmt->bind_param('i',$id);
	  $stmt->execute();
	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'Item removed from the cart!';
	  header('location:cart.php');
	}
	// Remove all items at once from cart
	if (isset($_GET['clear'])) {
	  $stmt = $conn->prepare('DELETE FROM cart');
	  $stmt->execute();
	  $_SESSION['showAlert'] = 'block';
	  $_SESSION['message'] = 'All Item removed from the cart!';
	  header('location:cart.php');
	}
	// Set total price of the product in the cart table
	if (isset($_POST['qty'])) {
	  $qty = $_POST['qty'];
	  $pid = $_POST['pid'];
	  $pprice = $_POST['pprice'];
	  $tprice = $qty * $pprice;
	  $stmt = $conn->prepare('UPDATE cart SET qty=?, total_price=? WHERE id=?');
	  $stmt->bind_param('isi',$qty,$tprice,$pid);
	  $stmt->execute();
	}
	// Checkout and save customer info in the orders table
	if (isset($_POST['action']) && isset($_POST['action']) == 'order') {
	  $name = $_POST['name'];
	  $email = $_POST['email'];
	  $phone = $_POST['phone'];
	  $products = $_POST['products'];
	  $grand_total = $_POST['grand_total'];
	  $address = $_POST['address'];
	  $pmode = $_POST['pmode'];
	  $data = '';
	  $stmt = $conn->prepare('INSERT INTO orders (name,email,phone,address,pmode,products,amount_paid)VALUES(?,?,?,?,?,?,?)');
	  $stmt->bind_param('sssssss',$name,$email,$phone,$address,$pmode,$products,$grand_total);
	  $stmt->execute();
	  $stmt2 = $conn->prepare('DELETE FROM cart');
	  $stmt2->execute();
	  $data .= '<div class="text-center">
		<h1 class="display-4 mt-2 text-danger">Thank You!</h1>
		<h2 class="text-success">Your Order Placed Successfully!</h2>
		<h4 class="bg-danger text-light rounded p-2">Items Purchased : ' . $products . '</h4>
		<h4>Your Name : ' . $name . '</h4>
		<h4>Your E-mail : ' . $email . '</h4>
		<h4>Your Phone : ' . $phone . '</h4>
		<h4>Total Amount Paid : ' . number_format($grand_total,2) . '</h4>
		<h4>Payment Mode : ' . $pmode . '</h4>
	  </div>';
	  echo $data;
	}
	   
	// -----------------------------------------registration-----------------------------------------------
	?>