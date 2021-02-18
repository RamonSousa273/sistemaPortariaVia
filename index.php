<?php
if (isset($_COOKIE['login'])) {
include_once("conexao.php");
$user = $_COOKIE['login'];
$sql = "SELECT * FROM uses WHERE user = '$user'";
$sql2 = $conn->query($sql) or die($conn->error);
$dado = $sql2->fetch_array();
if (is_array($dado)) {
session_start();
$_SESSION['llusuario']=$dado;
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
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<title></title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<link rel="stylesheet" href="css/login.css">
</head>
<body>
<div class="divLogin">
<form class="" action="processaLogin.php" method="post">
<input maxlength="12" class="form-control" type="text" name="user" value="" placeholder="Login">
<br>
<input maxlength="12" class="form-control" type="password" name="sen" value="" placeholder="Senha">
<br>
<button class="btn btn-primary btn-lg btn-block" type="submit" name="Login">Login</button>
</form>
</div>
</body>
</html>
