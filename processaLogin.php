<?php
if (isset($_POST['Login'])) {
$Log = $_POST['user'];
$sen = $_POST['sen'];
$Log = htmlspecialchars($Log);
$sen = htmlspecialchars($sen);
$Log = $Log;
$sen = md5($sen);
include_once("conexao.php");
$sql = "SELECT * FROM uses WHERE user = '$Log' AND sen = '$sen'";
$sql2 = $conn->query($sql) or die($conn->error);
$dado = $sql2->fetch_array();
if ($dado['id_registro'] > 0) {
session_start();
$_SESSION['llusuario']=$dado;
if ($dado['tipo'] == "po") {
$expira = time() + ( 60 * 60 * 12 );
  $cookie = $dado['user'];
  setcookie('login', $cookie, $expira);
}else{
$expira = time() + ( 60 * 60 * 24 * 30 );
$cookie = $dado['user'];
setcookie('login', $cookie, $expira);
}
if ($dado['tipo'] == "op") {
?>
<script type="text/javascript">
window.location.href = "homeop.php";
</script>
<?php
}else{
?>
<script type="text/javascript">
window.location.href = "home.php";
</script>
<?php
}
}
else {
?>
<script type="text/javascript">
alert("Não Cadastrado.");
window.location.href = "index.php";
</script>
<?php
}
}
?>
