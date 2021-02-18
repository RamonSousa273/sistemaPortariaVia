<?php session_start();
if (isset($_SESSION['llusuario'])) {
$_SESSION['llusuario'] = $_SESSION['llusuario'];
$user = $_SESSION['llusuario'];
if (!isset($_COOKIE['login'])) {?>
  <script type="text/javascript">
    alert("Sessão expirada!");
    window.top.location="index.php";
  </script>
  <?php
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<title></title>
<meta http-equiv="refresh" content="5">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/master2.css">
</head>
<body>
<?php
include_once("conexao.php");
$data = date('Y-m-d');
$sql = "SELECT * FROM pessoas WHERE hora_saida = '' AND local = 'SP'";
$sql2 = $conn->query($sql) or die($conn->error);
$quantia = 0;
while($dado = $sql2->fetch_array()){
$quantia = $quantia+1;
}
if ($quantia == 0) {
$quantia = "";
}
$sql = "SELECT * FROM veiculoses WHERE data_entrada = '0000-00-00' AND frota = 'Via' AND local = 'SP'";
$sql2 = $conn->query($sql) or die($conn->error);
$quantia2 = 0;
while($dado = $sql2->fetch_array()){
$quantia2 = $quantia2+1;
}
if ($quantia2 == 0) {
$quantia2 = "";
}
$sql = "SELECT * FROM veiculoses WHERE data_saida = '0000-00-00' AND frota = 'Agregado' AND local = 'SP'";
$sql2 = $conn->query($sql) or die($conn->error);
$quantia3 = 0;
while($dado = $sql2->fetch_array()){
$quantia3 = $quantia3+1;
}
if ($quantia3 == 0) {
$quantia3 = "";
}
?>
<div class="divTable">
<table class="table">
<tr>
<td colspan="2" class="bg-primary"> <i class="fa fa-car"> <b> Controle Veiculos (ANEXO 1)</b></i> </td>
<td colspan="2" class="bg-dark"> <i id="teste" class="fa fa-user"> <b> Controle Pessoas (ANEXO 2) </b>
</i>  </td>
<td colspan="2" class="bg-danger"> <i class="fa fa-book"> <b> Relatório</i> </b> </td>
<td colspan="3"  class="bg-warning"> <i class="fa fa-user-plus"></i> <b> Cadastrar </b></td>
<td  class="bg-light"> <a target="_top" href="processaLogout.php"><i class="fa fa-sign-out">
</i> Sair</a> </td>
</tr>
<tr>
<td class="VeiculoE"> <form class="" action="veiculos.php" method="post" target="menu">
<button class="btn btn-secondary" type="submit" name="Entrada"><b>Entrada <span
class="badge badge-danger"><?php echo $quantia2; ?></span></b></button>
</form> </td>
<td class="VeiculoS"><form class="" action="veiculos.php" method="post" target="menu">
<button class="btn btn-success" type="submit" name="Saida"><b>Saida <span
class="badge badge-danger"><?php echo $quantia3; ?></b></button>
</form></td>
<td class="VeiculoE"><form class="" action="pessoas.php" method="post" target="menu">
<button class="btn btn-secondary" type="submit" name="Entrada"><b>Entrada</b></button>
</form></td>
<td class="VeiculoS"><form class="" action="pessoas.php" method="post" target="menu">
<button class="btn btn-success" type="submit" name="Saida"><b>Saida</b> <span
class="badge badge-danger"><?php echo $quantia; ?></span></button>
</form></td>
<td class="VeiculoE"><form class="" action="relatorio.php" method="post" target="menu">
<button class="btn btn-secondary" type="submit" name="Veiculos"><b>Anexo 1</b></button>
</form></td>
<td class="VeiculoS"><form class="" action="relatorio.php" method="post" target="menu">
<button class="btn btn-success" type="submit" name="Pessoas"><b>Anexo 2</b></button>
</form></td>
<?php if ($user['tipo'] != "po"): ?>
<td class="VeiculoE"><form class="" action="cadastro.php" method="post" target="menu">
<button class="btn btn-secondary" type="submit" name="Veiculo"><b>Anexo 1</b></button>
</form></td>
<?php endif; ?>
<td  class="<?php if ($user['tipo'] != "po") {
echo "VeiculoS";
}else {
echo "VeiculoE";
} ?>"><form class="" action="cadastro.php" method="post" target="menu">
<button class="<?php if ($user['tipo'] != "po") {
echo "btn btn-success";
}else {
echo "btn btn-secondary";
} ?>" type="submit" name="Pessoa"><b>Anexo 2</b></button>
</form></td>
<?php if ($user['tipo'] != "po"): ?>
<td class="VeiculoE"><form class="" action="cadastro.php" method="post" target="menu">
<button class="btn btn-secondary" type="submit" name="Usuarios"><b>Usuarios</b></button>
</form></td>
<?php endif; ?>
</tr>
</table></div>
</body>
</html>
<?php }else{
?>
<script type="text/javascript">
window.location.href = "index.php";
</script>
<?php
} ?>
