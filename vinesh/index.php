<?php
session_start();
if(isset($_SESSION['people_Id']))
{
header('location:LandingPage.php');
}
include('config.php');
if(isset($_POST['commit']))
{
$Email=$_POST['Email'];
$Password=$_POST['Password'];
// setCookie('people_id',$people_id,time()+ (10 * 365 * 24 * 60 * 60));
// var_dump($email);
$qry="SELECT * FROM `customer` WHERE `email`='$Email' AND `password`='$Password'";
// var_dump($qry);
$result=mysqli_query($conn,$qry);
$data=mysqli_fetch_assoc($result);
$row=mysqli_num_rows($result);
// var_dump($row);
if($row<1)
{
?>
<script>
alert("Email and password does not exist!!!");
window.open('index.php','_self');
</script>
<?php
}
else
{
$id=$data['people_Id'];
//session_start();
$_SESSION['people_Id']=$id;
$Email=$data['email'];
header('location:LandingPage.php');
}
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login</title>
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
        <div class="container">
            <div class="row">
                <div class="col-md-8 mx-auto" style="max-width: 100%;">
                    <div id="first">
                        <div class="myform form ">
                            <div class="logo mb-3">
                                <div class="col-md-12 text-center">
                                    <h1>Login</h1>
                                </div>
                            </div>
                            <form action="index.php" method="post" name="login">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" name="Email"  class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Password</label>
                                    <input type="password" name="Password" id="password"  class="form-control" aria-describedby="emailHelp" placeholder="Enter Password">
                                </div>
                                <!--  <div class="form-group">
                                    <p class="text-center">By signing up you accept our <a href="#">Terms Of Use</a></p>
                                </div> -->
                                <div class="col-md-12 text-center ">
                                    <button type="submit" name="login" class=" btn btn-block mybtn btn-primary tx-tfm">Login</button>
                                </div>
                                <hr style="width:100%;text-align:center;margin-left:0">
                                <!--   <div class="col-md-12 mb-3">
                                    <p class="text-center">
                                        <a href="javascript:void();" class="google btn mybtn"><i class="fa fa-google-plus">
                                            </i> Signup using Google
                                        </a>
                                    </p>
                                </div> -->
                                <div class="form-group">
                                    <p class="text-center">Don't have account? <a href="#" id="signup">Sign up here</a></p>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                    <div id="second">
                        <div class="myform form ">
                            <div class="logo mb-3">
                                <div class="col-md-12 text-center">
                                    <h1 >Signup</h1>
                                </div>
                            </div>
                            <form action="action.php" method="post" name="registration">
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="f_name" id="f_name" class="form-control input-sm" placeholder="First Name">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="l_name" id="l_name" class="form-control input-sm" placeholder="Last Name">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="Email" id="email" class="form-control input-sm" placeholder="Email Address">
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="password" name="Password" id="password" class="form-control input-sm" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="input-group mb-2">
                                            <span class="input-group-text" id="dob">DOB</span>
                                            <input type="date" name="dob" id="dob" class="form-control input-sm" placeholder="">
                                        </div>
                                    </div>
                                </div>
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
                                <!-- <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control input-sm" placeholder="Email Address">
                                </div> -->
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
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <!-- <select class="form-select form-control input-sm custom-select" id="country">
                                                <option selected>Select Country</option>
                                                <option value="1">India</option>
                                                <option value="2">Germany</option>
                                                <option value="3">UK</option>
                                            </select> -->
                                            <select class="custom-select" name="country_id" id="country_id">
                                                <?php
                                                // include("config.php");
                                                $qry = "SELECT * FROM country";
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
                                <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <!--  <div class="form-group">
                                            <input type="text" name="phonetype" id="phonetype" class="form-control input-sm" placeholder="Enter phone type">
                                        </div> -->
                                        <div class="form-group">
                                           <select class="custom-select" name="phonenotype_id" id="phonenotype_id">
                                                <?php
                                                // include("config.php");
                                                $qry = "SELECT * FROM phonetype";
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
                                            <input type="text" name="phone_no" id="phone_no" class="form-control input-sm" placeholder="Contact Number">
                                        </div>
                                    </div>
                                </div>
                                <!--   <div class="row">
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="number" name="contactno" id="first_name" class="form-control input-sm" placeholder="Contact Number">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="last_name" id="last_name" class="form-control input-sm" placeholder="Last Name">
                                        </div>
                                        <div class="form-group">
                                            <select class="form-select" id="inputGroupSelect02">
                                                <option selected>Phone Type</option>
                                                <option value="1">Primary No</option>
                                                <option value="2">Alternate No</option>
                                                <option value="3">Landline No</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <!-- <select class="form-select form-control input-sm" id="inputGroupSelect02" name="">
                                                <option selected>Payment Type</option>
                                                <option value="1">Debit Card</option>
                                                <option value="2">Credit Card</option>
                                                <option value="3">Netbanking</option>
                                            </select> -->
                                            <select class="custom-select" name="payment_type_id" id="payment_type_id">
                                                <?php
                                                // include("config.php");
                                                $qry = "SELECT * FROM payment_type";
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
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="card_no" id="card_no" class="form-control input-sm" placeholder="Card Number">
                                        </div>
                                    </div>
                                     <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="bank_name" id="bank_name" class="form-control input-sm" placeholder="Bank Name">
                                        </div>
                                    </div>
                                    <div class="col-xs-6 col-sm-6 col-md-6">
                                        <div class="form-group">
                                            <input type="text" name="exp_date" id="exp_date" class="form-control input-sm" placeholder="Exp date">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center ">
                                    <button type="submit" name="registration" value="registration" class=" btn btn-success tx-tfm">Save</button>
                                </div>
                            </form>
                            
                            <hr style="width:100%;text-align:center;margin-left:0">
                            <div class="col-md-12 extrafield">
                                <div class="form-group">
                                    <p class="text-center"><a href="#" id="signin">Already have an account?</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </body>
        <script type="text/javascript">
        function addadress() {
        var houseno = $('#houseno').val();
        var streetno = $('#streetno').val();
        var streetname = $('#streetname').val();
        var locality = $('#locality').val();
        var landmark = $('#landmark').val();
        var zipcode = $('#zipcode').val();
        var city = $('#city').val();
        var state = $('#state').val();
        $.ajax({
        url: "action.php",
        type: 'post',
        data: {
        houseno: houseno,
        streetno: streetno,
        streetname: streetname,
        locality: locality,
        landmark: landmark,
        zipcode: zipcode,
        city: city,
        state: state
        },
        success: function(data, status)
        {
        // alert('Details are successfully updated!!');
        // location.reload(true);
        // $('#user').DataTable().ajax.reload();
        // swal.fire({
        // position: 'top',
        // type: 'success',
        // title: 'User details has been added',
        // showConfirmButton: false,
        // timer: 1800
        // });
        }
        });
        }
        
        $("#signup").click(function() {
        $("#first").fadeOut("fast", function() {
        $("#second").fadeIn("fast");
        });
        });
        $("#signin").click(function() {
        $("#second").fadeOut("fast", function() {
        $("#first").fadeIn("fast");
        });
        });
        
        $(function() {
        $("form[name='login']").validate({
        rules: {
        
        email: {
        required: true,
        email: true
        },
        password: {
        required: true,
        
        }
        },
        messages: {
        email: "Please enter a valid email address",
        
        password: {
        required: "Please enter password",
        
        }
        
        },
        submitHandler: function(form) {
        form.submit();
        }
        });
        });
        
        $(function() {
        
        $("form[name='registration']").validate({
        rules: {
        firstname: "required",
        lastname: "required",
        email: {
        required: true,
        email: true
        },
        password: {
        required: true,
        minlength: 5
        }
        },
        
        messages: {
        firstname: "Please enter your firstname",
        lastname: "Please enter your lastname",
        password: {
        required: "Please provide a password",
        minlength: "Your password must be at least 5 characters long"
        },
        email: "Please enter a valid email address"
        },
        
        submitHandler: function(form) {
        form.submit();
        }
        });
        });
        
        </script>
        
    </html>