<?php
session_start();
if (isset($_SESSION['llusuario'])) {
?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
<head>
<meta charset="utf-8">
<title>Portaria - Home</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
rel="stylesheet">
<link rel="stylesheet" href="css/master.css">
</head>
<body class="corpo">
<br>
<?php if (isset($_POST['Entrada'])): ?>
<h3 class="VeiculoE">Entrada</h3>
<div class="ajustaTabela">
<div class="ajustaBotao">
<table class="table table-dark">
<thead>
<tr>
<td>Digite o RG da pessoa</td>
</tr>
</thead>
<tbody>
<tr>
<td> <form class="" action="" method="post">
<input  maxlength="10" class="form-control" type="text" name="EntradaRG" value="">
</td>
</tr>
<tr>
<td><button class="btn btn-primary btn-lg btn-block" type="submit"
name="confirmaEntradaPessoa">Buscar</button></td>
</tr>
</tbody>
</table>
</form>
</div>
</div>
<?php endif; ?>
<?php if (isset($_POST['EntradaRG'])):
$rg = $_POST['EntradaRG'];
include_once("conexao.php");
$sql = "SELECT * FROM pessoas_cadastradas WHERE rg = '$rg'";
$sql2 = $conn->query($sql);
$dado = $sql2->fetch_array();
if (is_array($dado)) {
}else{
$_SESSION['Pessoa'] = 1;
?>
<script type="text/javascript">
alert("Pessoa não cadastrada.");
window.location.href = "cadastro.php";
</script>
<?php
}
?>
<form class="" action="processa.php" method="post" >
<table class="table table-dark">
<thead>
<h3 class="VeiculoE">Entrada</h3>
<tr>
<td>RG</td>
<td>Nome</td>
<td>Empresa</td>
<td>Veiculo</td>
<td>Placa</td>
<td>Contato Via Expressa</td>
</tr>
</thead>
<tbody>
<tr>
<td> <input class="form-control" maxlength="10" type="text" name="rg"
value="<?php echo htmlspecialchars($rg); ?>"> </td>
<td> <input class="form-control" maxlength="20" type="text" name="nome"
value="<?php echo htmlspecialchars($dado['nome']); ?>"> </td>
<td> <input class="form-control" maxlength="30" type="text" name="empresa"
value="<?php echo htmlspecialchars($dado['empresa']); ?>"> </td>
<td> <input class="form-control" maxlength="15" type="text" name="veiculo"
value="<?php echo htmlspecialchars($dado['veiculo']); ?>"> </td>
<td> <input class="form-control" maxlength="8" type="text" name="placa"
value="<?php echo htmlspecialchars($dado['placa']); ?>"> </td>
<td> <input class="form-control" maxlength="30" type="text" name="contatoVia"
value=""> </td>
</tr>
</tbody>
</table>
<div class="ajustaBotao">
<button class="btn btn-primary btn-lg btn-block" type="submit"
name="confirmaEntradaPessoa">Registrar</button>
</div>
</form>
<?php endif; ?>
<?php if (isset($_POST['Saida'])): ?>
<form class="" action="processa.php" method="post">
<table class="table table-dark">
<thead>
<h3 class="VeiculoS">Saida</h3>
<tr >
<td></td>
<td>Nome</td>
<td>Data</td>
<td>Hora chegada</td>
<td>Empresa</td>
<td>RG</td>
<td>Veiculo</td>
<td>Placa</td>
<td>Contato Via Expressa</td>
<td>Porteiro</td>
</tr>
</thead>
<tbody>
<?php
include_once("conexao.php");
$data = date('Y-m-d');
$sql = "SELECT * FROM pessoas WHERE hora_saida = '' AND local = 'SP'";
$sql2 = $conn->query($sql) or die($conn->error);
while($dado = $sql2->fetch_array()){
?>
<tr>
<td> <input type="radio" name="id"
value="<?php echo htmlspecialchars($dado['id_registro']); ?>"> </td>
<td><?php echo htmlspecialchars($dado['nome']); ?></td>
<td><?php echo $dado['data']; ?></td>
<td><?php echo $dado['hora_chegada']; ?></td>
<td><?php echo htmlspecialchars($dado['empresa']); ?></td>
<td><?php echo htmlspecialchars($dado['rg']); ?></td>
<td><?php echo htmlspecialchars($dado['veiculo']); ?></td>
<td><?php echo htmlspecialchars($dado['placa']); ?></td>
<td><?php echo htmlspecialchars($dado['contato_via']); ?></td>
<td><?php echo htmlspecialchars($dado['porteiro']); ?></td>
</tr>
<?php } ?>
</tbody>
</table>
<div class="ajustaBotao">
<button class="btn btn-primary btn-lg btn-block" type="submit"
name="confirmaSaidaPessoa">Registrar</button>
</div>
</form>
<?php endif; ?>
</body>
</html>
<?php }else{
?>
<script type="text/javascript">
alert("Não Cadastrado");
window.location.href = "index.php";
</script>
<?php
 } ?>
