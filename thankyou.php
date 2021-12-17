
<?php 

session_start();

if (isset($_POST['placeorder'])) {
    $contact_id = $_POST['contact_id'];
    $address_id = $_POST['address_id'];
    $paymentinfo_id = $_POST['paymentinfo_id'];
    $people_id = $_POST['people_id'];

    
  }
?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Vinesh">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Thank You</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <!-- <script src="https://https://use.fontawesome.com/a34asdfsd.js."></script> -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="table-responsive mt-2">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <td colspan="7">
                                <h4 class="text-center text-info m-0">Order Details</h4>
                           
                            </td>
                        </tr>
                        <tr>
                            <th>Order ID</th>
                           <th>Order Date</th>
                            <th>Bank Name</th>
                            <th>Status </th>
                            <th>Contact No</th>

                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    include 'config.php';
					
					if(isset($_SESSION['people_id']))
					{
					$people_id = $_SESSION['people_id'];
					}
         
                    $qry="SELECT orderheader.order_id as order_id ,orderheader.order_date as order_date ,payment_info.bank_name as bank_name ,status.status_description as status ,contact.phone_no as phone_no  
						  FROM orderheader INNER JOIN payment_info ON orderheader.payment_id = payment_info.paymentinfo_id 
						  INNER JOIN status ON orderheader.status_id=status.status_id  
						  INNER JOIN contact ON orderheader.contact_id = contact.contact_id 
						  WHERE orderheader.people_id='$people_id'
						  order by orderheader.order_id desc
						  limit 1;";
                     $result = $conn->query($qry);
                   while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $row['order_id'] ?></td>
                            <td><?= $row['order_date'] ?></td>
                            <td><?= $row['bank_name'] ?></td>
                            <td><?= $row['status'] ?></td>
                            <td><?= $row['phone_no'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

             <div class="table-responsive mt-2">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <td colspan="12">
                                <h4 class="text-center text-info m-0">Order Summary</h4>
                            </td>
                        </tr>
                        <tr>
                            <th>Product ID</th>
							<th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total Price</th>
							<th>Discount Amount</th>
                            <th>Final Amount</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $qry="SELECT orderitem.product_id as product_id,product.product_price as product_price,orderitem.quantity as quantity,
						  orderitem.total_price as total_price,orderitem.discount_amount as discount_amount,orderitem.final_amount as final_amount,
						  product.product_name as product_name 
						  FROM orderitem INNER JOIN product ON orderitem.product_id = product.product_id 
						  WHERE order_id='15';";
					$result = $conn->query($qry);
					$grand_total = 0;
                    while ($row = $result->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?= $row['product_id'] ?></td>
                            <td><?= $row['product_name'] ?></td>
                            <td><?= $row['quantity'] ?></td>
                            <td><?= $row['product_price'] ?></td>
                            <td><?= $row['total_price'] ?></td>
							<td><?= $row['discount_amount'] ?></td>
                            <td><?= $row['final_amount'] ?></td>
                         </tr>  
					<?php $grand_total += $row['final_amount']; ?>
                    <?php endwhile; ?>
					<tr>
					<td colspan="6"><b>Grand Total</b></td>
					<td><b><i class="fas fa-euro-sign"></i>&nbsp;&nbsp;<?= number_format($grand_total,2); ?></b></td>
					</tr>
					<tr>
					<td colspan="7"><a href="LandingPage.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue
                    Shopping</a></td>
					</tr>
                    </tbody>
                </table>
            </div>
        </div>
        
    <script>
    // $(document).ready(function() {
    //     $(.editbtn).on('click',function() {
    //     $().modal 
            
    //     });         
    // });
    </script>
    </body>
</html>