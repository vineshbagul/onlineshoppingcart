<?php

session_start();
unset($_SESSION["Email"]);
unset($_SESSION["Password"]);
session_destroy();
session_set_cookie_params(0);

header('location:index.php');

?>