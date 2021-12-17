<?php
  session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Checkout</title>
        <link rel="stylesheet" href="style.css">
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <!------ Include the above in your HEAD tag ---------->
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
        <link href="https://fonts.googleapis.com/css?family=Kaushan+Script" rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css' />
	</head>
    <body>
		<!-- Navbar start -->
  <nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="index.php"><i class="fas fa-mobile-alt"></i>&nbsp;&nbsp;Online Shop Retailer</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link active" href="index.php"><i class="fas fa-mobile-alt mr-2"></i>Products</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item" class="badge badge-danger"></span></a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="profile.php"><i class='fas fa-user-alt '></i><span id="profile" class="badge badge-danger"></span>&nbsp;&nbsp;Profile</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="fas fa-caret-square-right"></i>&nbsp;&nbsp;Log Out</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Navbar end -->
	
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div id="first">
                        <div class="myform form" style="max-width: 100%;">
                            <div class="logo mb-3">
                                <div class="col-md-12 text-center">
                                    <h3>Checkout Page</h3>
                                </div>
                            </div>
                            <hr style="width:100%;text-align:center;margin-left:0">
                            <form action="action.php" method="post" name="checkout">
                                <h6>Select Phone Number:-</h6>
                                             <div class="form-check">
											 <div class="form-group">
											 <select class="custom-select" name="contact_id" id="contact_id">
                                               <?php
                                               include 'config.php';
											   if(isset($_SESSION['people_id']))
												{
												$people_id = $_SESSION['people_id'];
												}
                                               $qry = "SELECT contact_id,phone_no FROM contact where people_id = '$people_id'";
											   $result = mysqli_query($conn,$qry);
											   while($row = mysqli_fetch_array($result))
											   {
                                               echo "<option value='".$row['contact_id']."'>".$row['phone_no']."</option>";
											   }
                                               ?>
											   </select>
											   </div>	   
                                               </div>
                                <hr style="width:100%;text-align:center;margin-left:0">
                                <h6>Select Address:-</h6>
                                <div class="form-check">
                                    <?php
                                    include 'config.php';
                                    if(isset($_SESSION['people_id']))
                                    {
                                    $people_id = $_SESSION['people_id'];
                                    }
                                    $stmt = $conn->prepare("SELECT address_id,house_no,street_no,street_name,locality,landmark,zip_code,city,state,country_name FROM address,country where address.country_id = country.country_id and address.people_id ='$people_id'");
                                    $stmt->execute();
                                    $result = $stmt->get_result();
									?>
									<div class="form-group">
                                        <div class="form-group">
                                            <select class="custom-select" name="address_id" id="address_id">
                                                <?php
												while ($row = $result->fetch_assoc()):
                                                echo "<option value='".$row['address_id']."'>".$row['house_no'].", ". $row['street_no']." ,"
                                                . $row['street_name']." ,". $row['locality']." ,". $row['landmark']." ,". $row['zip_code']." ". $row['city'].", ".$row['state']." ,". $row['country_name']. "</option>";
                                                endwhile; ?>
                                            </select>
                                        </div>
                                    </div>
									
                                </div>
                                    <hr style="width:100%;text-align:center;margin-left:0">
                                    <h6>Select Payment:-</h6>
                                    <div class="form-check">
                                        <?php
                                        if(isset($_SESSION['people_id']))
                                        {
                                        $people_id = $_SESSION['people_id'];
                                        }
                                        $stmt = $conn->prepare("SELECT paymentinfo_id,bank_name,card_no,exp_date,payment_type_name FROM payment_info,payment_type where payment_type.payment_type_id = payment_info.payment_type_id and payment_info.people_id ='$people_id'");
                                        $stmt->execute();
                                        $result = $stmt->get_result();
										?>
										<div class="form-group">
                                            <div class="form-group">
                                                <select class="custom-select" name="paymentinfo_id" id="paymentinfo_id">
										<?php
													while ($row = $result->fetch_assoc()):
                                                    echo "<option value='".$row['paymentinfo_id']."'>".$row['bank_name'].", ". $row['card_no']." ," . $row['exp_date']."</option>";
                                                    endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                <hr style="width:100%;text-align:center;margin-left:0">
                                <div class="text-center">
								<input type="hidden" name="people_id" id="people_id" value=<?= $people_id ?> class="form-control input-sm" placeholder="">
                                    <button type="submit" name= "placeorder" value= "placeorder" class="btn btn-danger text-center placeorder">Place Order</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

<script type="text/javascript">
  $(document).ready(function() {

    // Send product details in the server

    $(".placeorder").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest("#checkout");
      var pid = $form.find(".people_id").val();
      var contact_id = $form.find("#contact_id").val();
      var address_id = $form.find("#address_id").val();
      var paymentinfo_id = $form.find("#paymentinfo_id").val();


      $.ajax({
        url: 'action.php',
        method: 'post',
        data: {
          people_id: people_id,
		  contact_id: contact_id,
		  address_id: address_id,
		  paymentinfo_id: paymentinfo_id

        },
        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
        }
      });
    });
	
</script>
