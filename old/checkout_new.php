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
    </head>
    <body>
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
                            <form action="action.php" method="post" name="login">
                                <h6>Select Phone Number:-</h6>


                                             <div class="form-check">

                                               <?php
                                               include 'config.php';
											   if(isset($_SESSION['people_id']))
												{
												$people_id = $_SESSION['people_id'];
												}
                                               $stmt = "SELECT phone_no FROM contact where people_id = '$people_id';";
											   $result = $conn->query($stmt);
                                               while ($row = $result->fetch_assoc()):
                                               ?>
											   <div class="form-group">
												<input class="form-check-input" type="radio" name="Phonetype" id="Phonetype">
                                                <label class="form-check-label" for="Phonetype"><?= $row['phone_no'] ?></label>
												</div>
                                                  <?php endwhile; ?>
                                            </div>

                                <hr style="width:100%;text-align:center;margin-left:0">
                                <h6>Select Address:-</h6>



                                <div class="form-check">
                                  <?php
                                  include 'config.php';
                                  $stmt = $conn->prepare('SELECT address_id,house_no,street_no,street_name,locality,landmark,zip_code,city,state,country_name FROM address,country where address.country_id = country.country_id and address.people_id = 1');
                                  $stmt->execute();
                                  $result = $stmt->get_result();
                                  while ($row = $result->fetch_assoc()):
                                  ?>

                                    <div class="form-group">
									<div class="form-group">
                                    <input class="form-check-input" type="radio" name="Adreess" id="Adreess" checked>
                                    <label class="form-check-label" for="Adreess">
                                        
                                        <tr>
										<label class="form-check-label" for="house_no"><b>House No:</b></label>
                                        <td><?php echo $row['house_no']; ?></td>
										</tr>
										<tr>
										<label class="form-check-label" for="house_no">Street No: </label>
                                        <td><?php echo  $row['street_no']; ?></td>
										</tr>
										<tr>
                                        <td><?php echo $row['street_name']; ?></td> 
                                        <td><?php echo $row['locality']; ?></td> 
                                        <td><?php echo $row['landmark']; ?></td>
                                         <td><?php echo $row['zip_code']; ?></td> 
                                         <td><?php echo $row['city']; ?></td> 
                                         <td><?php echo $row['state']; ?></td> 
                                         <td><?php echo $row['country_name']; ?></td> 
                                     </tr>
									</div>
                                  <?php endwhile; ?>

                                </div>



                                <div class="form-check">
                                  <?php
                                  include 'config.php';
                                  $stmt = $conn->prepare('SELECT address_id,house_no,street_no,street_name,locality,landmark,zip_code,city,state,country_name FROM address,country where address.country_id = country.country_id and address.people_id = 2');
                                  $stmt->execute();
                                  $result = $stmt->get_result();
                                  while ($row = $result->fetch_assoc()):
                                  ?>


                                    <input class="form-check-input" type="radio" name="Adreess" id="Adreess" checked>
                                    <label class="form-check-label" for="Adreess">
                                        <?=  $row['house_no'], $row['street_no'], $row['street_name'], $row['locality'], $row['landmark'], $row['zip_code'], $row['city'], $row['state'], $row['country_name'] ?>
                                    </label>

                                  <?php endwhile; ?>
                                </div>




                                <hr style="width:100%;text-align:center;margin-left:0">
                                <h6>Select Payment:-</h6>
                                <div class="form-check">
                                  <?php
                                  $stmt = $conn->prepare('SELECT bank_name,card_no,exp_date,payment_type_name FROM payment_info,payment_type where payment_type.payment_type_id = payment_info.payment_type_id and payment_info.people_id = 1');
                                  $stmt->execute();
                                  $result = $stmt->get_result();
                                  while ($row = $result->fetch_assoc()):
                                  ?>

                                    <input class="form-check-input" type="radio" name="payment" id="payment">
                                    <label class="form-check-label" for="payment">
                                      

                                    <tr>
                                        <td><?php echo $row['payment_type_name']; ?></td> 

                                        <td><?php echo $row['card_no']; ?></td> 

                                        
                                        <td><?php echo $row['bank_name']; ?></td> 
                                        
                                        <td><?php echo $row['exp_date']; ?></td> 

                                    <?php endwhile; ?>

                                </div>


                                <div class="form-check">
                                  <?php
                                  $stmt = $conn->prepare('SELECT bank_name,card_no,exp_date,payment_type_name FROM payment_info,payment_type where payment_type.payment_type_id = payment_info.payment_type_id and payment_info.people_id = 2');
                                  $stmt->execute();
                                  $result = $stmt->get_result();
                                  while ($row = $result->fetch_assoc()):
                                  ?>

                                    <input class="form-check-input" type="radio" name="payment" id="payment">
                                    <label class="form-check-label" for="payment">
                                      <?= $row['payment_type_name'], $row['card_no'], $row['bank_name'], $row['exp_date'] ?>
                                    </label>
                                    <?php endwhile; ?>
                                </div>










                                <hr style="width:100%;text-align:center;margin-left:0">
                                <div class="text-center">
                                    <button type="submit" class="btn btn-danger text-center" onclick="" >Place Order</button>
                                </div>

















                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
