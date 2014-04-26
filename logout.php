<?php
  session_start();
  session_unset();
  session_destroy();
  unset($_SESSION);
  session_write_close(); 
  header("Location: /");
?>