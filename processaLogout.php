<?php
session_start();
if (isset($_SESSION['llusuario'])) {
setcookie('login', -1);
unset($_SESSION['llusuario']);


?>
<script type="text/javascript">
  window.location.href = "index.php";
</script>

  <?php
}
 ?>
