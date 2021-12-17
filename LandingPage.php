<?php
session_start();
if(isset($_SESSION['people_id']))
{
	$people_id = $_SESSION['people_id'];
	//var_dump($people_id);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="vinesh">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Shopping Cart System</title>
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
          <a class="nav-link" href="thankyou.php"><i class='fas fa-user-alt '></i><span id="lastorder" class="badge badge-danger"></span>&nbsp;&nbsp;Last order</a>
        </li>
         <li class="nav-item">
          <a class="nav-link" href="logout.php"><i class="fas fa-caret-square-right"></i>&nbsp;&nbsp;Log Out</a>
        </li>
      </ul>
    </div>
  </nav>
  <!-- Navbar end -->

  <!-- Displaying Products Start -->
  <div class="container">
    <div id="message"></div>
    <div class="row mt-2 pb-3">
      <?php
  			include 'config.php';
  			$stmt = $conn->prepare('SELECT product_id,product_name,product_desc,product_price,brand,category_name FROM product,category where category.category_id = product.category_id');
  			$stmt->execute();
  			$result = $stmt->get_result();
  			while ($row = $result->fetch_assoc()):
  		?>
      <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
        <div class="card-deck">
          <div class="card p-2 border-secondary mb-2">
            <!-- <img src="<?= $row['product_image'] ?>" class="card-img-top" height="250"> -->
            <div class="card-body p-1">
              <h5 class="card-title text-center text-info"><?= $row['product_name'] ?></h5>
			  <h6 class="card-title text-center text-info">Brand: <?= $row['brand'] ?></h6>
			  <h6 class="card-title text-center text-info">Category: <?= $row['category_name'] ?></h6>
			  <h6 class="card-title text-center text-info">Product Desc: <?= $row['product_desc'] ?></h6>
              <h5 class="card-text text-center text-danger"><i class="fas fa-euro-sign"></i>&nbsp;&nbsp;<?= number_format($row['product_price'],2) ?>/-</h5>

            </div>
            <div class="card-footer p-1">
              <form action="" class="form-submit">
                <div class="row p-2">
                  <div class="col-md-6 py-1 pl-4">
                    <b>Quantity : </b>
                  </div>
                  <div class="col-md-6">
                    <input type="number" class="form-control" id="pqty" value="">
                  </div>
                </div>
				<input type="hidden" class="people_id" value=<?="$people_id"?>>
                <input type="hidden" class="pid" value="<?= $row['product_id'] ?>">
                <input type="hidden" class="pname" value="<?= $row['product_name'] ?>">
                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">
                <button class="btn btn-info btn-block addItemBtn"><i class="fas fa-cart-plus"></i>&nbsp;&nbsp;Add to
                  cart</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php endwhile; ?>
    </div>
  </div>
  <!-- Displaying Products End -->

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Send product details in the server

    $(".addItemBtn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var pname = $form.find(".pname").val();
      var pprice = $form.find(".pprice").val();
      var pqty = $form.find("#pqty").val();
	  var people_id = $form.find(".people_id").val();

      $.ajax({
        url: 'action.php',
        method: 'post',
        data: {
          pid: pid,
          pprice: pprice,
          pqty: pqty,
		  people_id: people_id
        },
        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
          load_cart_item_number();
        }
      });
    });

    // Load total no.of items added in the cart and display in the navbar
    load_cart_item_number();

    function load_cart_item_number() {
		var people_id = people_id;
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
  });
  </script>
</body>

</html>