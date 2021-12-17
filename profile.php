<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="author" content="Vinesh">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Profile</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
	  <!-- Navbar start -->
        <div class="container">
            <div class="table-responsive mt-2">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <td colspan="7">
                                <h4 class="text-center text-info m-0">Profile Of Customer</h4>
                            </td>
                        </tr>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
					include 'config.php';
					if(isset($_SESSION['people_id']))
					{
					$people_id = $_SESSION['people_id'];
					}
					$qry="SELECT people_id,f_name,l_name FROM people WHERE people_id='$people_id';";
					$result = $conn->query($qry);
					while ($row = $result->fetch_assoc()):
					?>
                        <tr>
                            <td><?= $row['people_id'] ?></td>
                            <td><?= $row['f_name'] ?></td>
                            <td><?= $row['l_name'] ?></td>
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
                                <h4 class="text-center text-info m-0">Address Of Customer</h4>
                                <button type="button" name="addaddress" onclick="addaddress()" id="" class="btn btn-info right" data-toggle="modal" data-target="#myModal">Add Address</button>
                            </td>
                        </tr>
                        <tr>
                            <th>House No</th>
							<th>Street No</th>
							<th>Street Name</th>
							<th>Locality</th>
							<th>Landmark</th>
							<th>Zip Code</th>
							<th>City</th>
							<th>State</th>
							<th>Country</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
					include 'config.php';
					if(isset($_SESSION['people_id']))
					{
					$people_id = $_SESSION['people_id'];
					}
					$stmt = "SELECT house_no,street_no,street_name,locality,landmark,zip_code,city,state,country_name FROM address,country WHERE address.country_id = country.country_id and people_id='$people_id';";
					$result = $conn->query($stmt);
					while ($row = $result->fetch_assoc()):
					?>
                        <tr>
                            <td><?= $row['house_no'] ?></td>
                            <td><?= $row['street_no'] ?></td>
                            <td><?= $row['street_name'] ?></td>
                            <td><?= $row['locality'] ?></td>
                            <td><?= $row['landmark'] ?></td>
                            <td><?= $row['zip_code'] ?></td>
                            <td><?= $row['city'] ?></td>
                            <td><?= $row['state'] ?></td>
                            <td><?= $row['country_name'] ?></td>
                         </tr>  
					<?php endwhile; ?>
                    </tbody>
                </table>
            </div>

                <div class="table-responsive mt-2">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                        <tr>
                            <td colspan="7">
                                <h4 class="text-center text-info m-0">Contact Information</h4>
                                <button type="button" name="addcontact" onclick="addcontact()" id="" class="btn btn-info right" data-toggle="modal" data-target="#contactModal">Add Contact</button>
                            </td>
                        </tr>
                        <tr>
                            <th>Phone Type</th>
                            <th>Contact Number>
                        </tr>
                    </thead>
                    <tbody>
					<?php
					$stmt = "SELECT phonetype.type_name,contact.phone_no FROM contact INNER JOIN phonetype ON contact.phoneno_typeid = phonetype.phonenotype_id where people_id='$people_id';";
					$result = $conn->query($stmt);
					while ($row = $result->fetch_assoc()):
					?>
                        <tr>
                            <td><?= $row['type_name'] ?></td>
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
                                <h4 class="text-center text-info m-0">Payment Information</h4>
                                <button type="button" name="addcontact" onclick="addcontact()" id="" class="btn btn-info right" data-toggle="modal" data-target="#paymentmodal">Add Payment</button>
                            </td>
                        </tr>
                        <tr>
                            <th>Type</th>
							<th>Card No</th>
                            <th>Bank</th>
                            <th>Exp Date</th>
                        </tr>
                    </thead>
                    <tbody>
					<?php
					$stmt = "SELECT payment_info.bank_name,payment_info.card_no,payment_info.exp_date,payment_type.payment_type_name FROM payment_info INNER JOIN payment_type ON payment_type.payment_type_id = payment_info.payment_type_id WHERE people_id='$people_id';";
					$result = $conn->query($stmt);
					while ($row = $result->fetch_assoc()):
					?>
                        <tr>
                            <td><?= $row['payment_type_name'] ?></td>
                            <td><?= $row['card_no'] ?></td>
                            <td><?= $row['bank_name'] ?></td>
                            <td><?= $row['exp_date'] ?></td>
                         </tr>  
					<?php endwhile; ?>
                    </tbody>
                </table>
            </div>
            <!-- -------------------------------------address modal------------------------------------------------ -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Address</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
						<form action="action.php" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="houseno" id="houseno" class="form-control input-sm" placeholder="House Number">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="streetno" id="streetno" class="form-control input-sm" placeholder="Street Number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="streetname" id="streetname" class="form-control input-sm" placeholder="Street Name">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="locality" id="locality" class="form-control input-sm" placeholder="Locality">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="landmark" id="landmark" class="form-control input-sm" placeholder="Landmark">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="zipcode" id="zipcode" class="form-control input-sm" placeholder="Zip Code">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="city" id="city" class="form-control input-sm" placeholder="City">
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="state" id="state" class="form-control input-sm" placeholder="State">
                                    </div>
                                </div>
                            </div>
							<div class="row">
							<div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <select class="form-select form-control input-sm" id="country_id" name="country_id">
																<?php
                                                                $qry = "SELECT country_id,country_name FROM country";
                                                                $result = mysqli_query($conn,$qry);
                                                                while($row = mysqli_fetch_array($result))
                                                                {
                                                                echo "<option value='".$row['country_id']."'>".$row['country_name']."</option>";
                                                                
                                                                }
                                                                ?>
                                        </select>
                                    </div>
                                </div>
							</div>
                        </div>
                        <div class="modal-footer">
							<input type="hidden" name="people_id" id="people_id" value=<?= $people_id ?> >
                            <button type="submit" class="btn btn-success" name="addresssave">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
						</form>
                    </div>
                </div>
            </div>
            <!-- --------------------------------------contact modal------------------------------------------------ -->
            <div class="modal fade" id="contactModal" role="dialog">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Alternate Number</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
						<form action="action.php" method="POST">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <select class="form-select form-control input-sm" name="phonenotype_id" id="phonenotype_id">
																<?php
                                                                $qry = "SELECT phonenotype_id,type_name FROM phonetype";
                                                                $result = mysqli_query($conn,$qry);
                                                                while($row = mysqli_fetch_array($result))
                                                                {
                                                                echo "<option value='".$row['phonenotype_id']."'>".$row['type_name']."</option>";
                                                                
                                                                }
                                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="contactnumber" id="contactnumber" class="form-control input-sm" placeholder="Contact Number">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
							<input type="hidden" name="people_id" id="people_id" value=<?= $people_id ?> >
                            <button type="submit" class="btn btn-success" name="contactsave">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
						</form>
                    </div>
                </div>
            </div>
			
		            <!-- --------------------------------------payment modal------------------------------------------------ -->
            <div class="modal fade" id="paymentmodal" role="dialog">
                <div class="modal-dialog ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Alternate Number</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
						<form action="action.php" method="POST">
                        <div class="modal-body">
                                                           <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <select class="form-select form-control input-sm" id="payment_type_id" name="payment_type_id">
																<?php
                                                                $qry = "SELECT payment_type_id,payment_type_name FROM payment_type";
                                                                $result = mysqli_query($conn,$qry);
                                                                while($row = mysqli_fetch_array($result))
                                                                {
                                                                echo "<option value='".$row['payment_type_id']."'>".$row['payment_type_name']."</option>";
                                                                
                                                                }
                                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <input type="text" name="card_no" id="card_no" class="form-control input-sm" placeholder="Card Number">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="bank" id="bank" class="form-control input-sm" placeholder="Bank Name">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="date" name="expdate" id="expdate" class="form-control input-sm" placeholder="Exp Date">
                                        </div>
                                    </div>
                                </div>
                        <div class="modal-footer">
						<input type="hidden" name="people_id" id="people_id" value=<?= $people_id ?> >
                            <button type="submit" class="btn btn-success" name="paymentsave">Save</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        </div>
						</form>
                    </div>
                </div>
            </div>
        </div>
		
	<script>
	$(document).ready(function() {
	});
	</script>
    </body>
</html>


