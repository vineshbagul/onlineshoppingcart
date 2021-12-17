<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="Sahil Kumar">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Cart</title>
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
  <div id="message"></div>
    <div class="row justify-content-center">
      <div class="col-lg-12">
        <div style="display:<?php if (isset($_SESSION['showAlert'])) {
			echo $_SESSION['showAlert'];
			} else {
			echo 'none';
			} unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><?php if (isset($_SESSION['message'])) {
			echo $_SESSION['message'];
			} unset($_SESSION['showAlert']); ?></strong>
        </div>
        <div class="table-responsive mt-2">
          <table class="table table-bordered table-striped text-center">
            <thead>
              <tr>
                <td colspan="8">
                  <h4 class="text-center text-info m-0">Products in your cart!</h4>
                </td>
              </tr>
              <tr>
                <th>ID</th>

                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Discount</th>
                <th>Final Amount</th>
                <th>
				<?php
				if(isset($_SESSION['people_id']))
				{
				$people_id = $_SESSION['people_id'];
				}
				?>
                  <a href="action.php?people_id=<?= $people_id ?>" class="badge-danger badge p-1" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                </th>
              </tr>
            </thead>
            <tbody>
			<form action="" class="form-submit">
              <?php
				if(isset($_SESSION['people_id']))
				{
				$people_id = $_SESSION['people_id'];
				}
                require 'config.php';
				$qry="SELECT cart.product_id,cart.product_price,cart.quantity,cart.total_price,cart.discount_amount,cart.final_amount,product.product_name 
				FROM cart INNER JOIN product ON cart.product_id = product.product_id 
				WHERE people_id='$people_id';";
                $result = $conn->query($qry);
				$grand_total = 0;
                while ($row = $result->fetch_assoc()):
              ?>
				<tr>
                <td><?= $row['product_id'] ?></td>
                <input type="hidden" class="pid" value="<?= $row['product_id'] ?>">
                <td><?= $row['product_name'] ?></td>
                <td>
                  <i class="fas fa-euro-sign"></i>&nbsp;&nbsp;<?= number_format($row['product_price'],2); ?>
                </td>
                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                <td>
				<i class="fas "></i>&nbsp;&nbsp;<?= number_format($row['quantity'],2); ?>
                <input type="hidden" class="form-control itemQty" value="<?= $row['quantity'] ?>" style="width:75px;">
                </td>
				<td><i class="fas fa-euro-sign"></i>&nbsp;&nbsp;<?= number_format($row['total_price'],2); ?></td>
                <td>
				<i class="fas fa-euro-sign"></i>&nbsp;&nbsp;<?= number_format($row['discount_amount'],2); ?>
                <input type="hidden" class="form-control itemQty" value="<?= $row['discount_amount'] ?>" style="width:75px;">
                </td>
                <td><i class="fas fa-euro-sign"></i>&nbsp;&nbsp;<?= number_format($row['final_amount'],2); ?></td>
				<input type="hidden" class="people_id" value=<?="$people_id"?>>
                <td></td>
              </tr>
              <?php $grand_total += $row['final_amount']; ?>
              <?php endwhile; ?>
              <tr>
                <td colspan="4">
                  <a href="index.php" class="btn btn-success"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Continue
                    Shopping</a>
                </td>
                <td colspan="2"><b>Grand Total</b></td>
                <td><b><i class="fas fa-euro-sign"></i>&nbsp;&nbsp;<?= number_format($grand_total,2); ?></b></td>
                <td>
                  <a href="checkout_new.php" class="btn btn-info <?= ($grand_total > 1) ? '' : 'disabled'; ?>"><i class="far fa-credit-card"></i>&nbsp;&nbsp;Checkout</a>
                </td>
              </tr>
			  </form>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Change the item quantity
    $(".itemQty").on('change', function() {
      var $el = $(this).closest('tr');

      var pid = $el.find(".pid").val();
      var pprice = $el.find(".pprice").val();
      var qty = $el.find(".itemQty").val();
      location.reload(true);
      $.ajax({
        url: 'action.php',
        method: 'post',
        cache: false,
        data: {
          qty: qty,
          pid: pid,
          pprice: pprice
        },
        success: function(response) {
          console.log(response);
        }
      });
    });

    // Load total no.of items added in the cart and display in the navbar
    load_cart_item_number();

    function load_cart_item_number() {
      $.ajax({
        url: 'action.php',
        method: 'get',
        data: {
          cartItem: "cart_item"
        },
        success: function(response) {
          $("#cart-item").html(response);
        }
      });
    }
	
	$(".deletecartitem").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var people_id = $form.find(".people_id").val();
      var product_id = $form.find(".pid").val();
	  
      $.ajax({
        url: 'action.php',
        method: 'post',
        data: {
          product_id: product_id,
		  people_id: people_id
        },
        success: function(response) {
          $("#message").html(response);
        }
      });
    });
  });
  </script>
</body>

</html>