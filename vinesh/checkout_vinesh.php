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
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
                                    <div class="form-group">
                                        <select class="custom-select" name="contact_id" id="contact_id">
                                            <?php
                                            // include("config.php");
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
                                            // print_r($row['phoneno_typeid']);
                                            // exit();
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
                                    while ($row = $result->fetch_assoc()):
                                    ?>
                                    <div class="form-group">
                                        <div class="form-group">
                                            <select class="custom-select" name="address_id" id="address_id">
                                                <?php
                                                echo "<option value='".$row['address_id']."'>".$row['house_no'].", ". $row['street_no']." ,"
                                                . $row['street_name']." ,". $row['locality']." ,". $row['landmark']." ,". $row['zip_code']." ". $row['city'].", ".$row['state']." ,". $row['country_name']. "</option>";
                                                ?>
                                                <?php endwhile; ?>
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
                                        while ($row = $result->fetch_assoc()):
                                        ?>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <!-- <input class="form-check-input" type="radio" name="Adreess" id="Adreess" checked> -->
                                                <!-- <label class="form-check-label" for="Adreess"> -->
                                                <select class="custom-select" name="paymentinfo_id" id="paymentinfo_id">
                                                    <?php
                                                    echo "<option value='".$row['paymentinfo_id']."'>".$row['bank_name'].", ". $row['card_no']." ," . $row['exp_date']."</option>";
                                                    ?>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="width:100%;text-align:center;margin-left:0">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-danger text-center" name="placeorder" value="placeorder" >Place Order</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
    </html>