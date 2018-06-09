<?php
  include "sessionheader.php";
  session_unset();
  session_destroy();
  header('Location: login.php');
  exit;
?>
