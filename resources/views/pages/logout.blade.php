<?php
  $cas_path = "../vendor/phpCAS/CAS.php";
  SSO\SSO::setCASPath($cas_path);
  SSO\SSO::logout();
?>
