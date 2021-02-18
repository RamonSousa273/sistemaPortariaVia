<?php session_start();
if (isset($_SESSION['llusuario'])) {
$_SESSION['llusuario'] = $_SESSION['llusuario'];
$user = $_SESSION['llusuario'];
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
<body>
<div class="cadastro">
<?php
if (isset($_POST['Veiculo']) || isset($_SESSION['Veiculo'])):
unset( $_SESSION['Veiculo'] );
?>
<br>
<h3 class="VeiculoE">Cadastro Veiculos</h3>
<form class="" action="processa.php" method="post">
<table class="table table-warning">
<thead>
<td>Tipo do veiculo</td>
<td>Placa</td>
<td>Frota</td>
<td>Motorista</td>
</thead>
<tbody>
<td> <input maxlength="15" class="form-control" type="text" name="veiculo" value=""> </td>
<td> <input maxlength="8" class="form-control" placeholder="abc-1234" type="text"
name="placa" value=""> </td>
<td> <select class="form-control" name="frota">
<option class="form-control" value=""></option>
<option class="form-control" value="Agregado">Agregado</option>
<option class="form-control" value="Via">Via</option>
</select> </td>
<td> <input maxlength="20" class="form-control" type="text" name="motorista"
value=""> </td>
</tbody>
</table>
<div class="ajustaBotao">
<button class="btn btn-primary btn-lg btn-block" type="submit"
name="confirmaCadastroVeiculo">Cadastrar</button>
</div>
</form>
<div class="">
<br>
<br>
<br>
<h3 class="VeiculoE">Ajustar cadastro</h3>
<table class="table table-dark table-striped">
<thead>
<td>FROTA</td>
<td>MOTORISTA</td>
<td>PLACA</td>
<td>VEICULO</td>
<td></td>
</thead>
<tbody>
<?php
include_once("conexao.php");
$sql = "SELECT * FROM veiculos_cadastrados";
$sql =  $conn->query($sql) or die($conn->error);
while($dado = $sql->fetch_array()){
?>
<form class="" action="processa.php" method="post">
<tr>
<td> <select class="form-control" name="frota">
<option class="form-control" value=""><?php echo $dado['frota']; ?></option>
<option class="form-control" value="Agregado"><?php if ($dado['frota'] == "Via") {
echo "Agregado";
}else {
echo "Via";
} ?></option>
</select> </td>
<td> <input class="form-control" type="text" name="motorista"
value="<?php echo $dado['motorista']; ?>"> </td>
<td> <input class="form-control" type="text" name="placa" value="<?php echo $dado['placa']; ?>">
</td>
<td>
<input class="form-control" type="text" name="veiculo" value="<?php echo $dado['veiculo']; ?>">
</td>
<td> <button class="btn btn-primary" type="submit" value="<?php echo $dado['id_registro']; ?>"
name="confirmaAjusteCadastro1">Confirmar</button> </td>
</tr>
</form>
<?php } ?>
</tbody>
</table>
</div>
<?php endif; ?>
<?php if (isset($_POST['Pessoa']) || isset($_SESSION['Pessoa'])):
unset( $_SESSION['Pessoa'] );
?>
<br>
<h3 class="VeiculoS">Cadastro Pessoas</h3>
<form class="" action="processa.php" method="post">
<table class="table table-warning">
<thead>
<td>Nome</td>
<td>Tipo do veiculo</td>
<td>Empresa</td>
<td>Placa</td>
<td>RG</td>
</thead>
<tbody>
<td> <input maxlength="30" class="form-control" type="text" name="nome" value=""> </td>
<td> <input maxlength="15" class="form-control" type="text" name="veiculo" value=""> </td>
<td> <input maxlength="20" class="form-control" type="text" name="empresa" value=""> </td>
<td> <input maxlength="8" class="form-control" type="text" placeholder="abc-1234"
name="placa" value=""> </td>
<td> <input maxlength="10" class="form-control" type="text" name="rg" value=""> </td>
</tbody>
</table>
<div class="ajustaBotao">
<button class="btn btn-primary btn-lg btn-block" type="submit"
name="confirmaCadastroPessoa">Cadastrar</button>
</div>
</form>
<?php if ($user['tipo'] != "po"): ?>
<br>
<br>
<br>
<h3 class="VeiculoS">Cadastro Pessoas</h3>
<table class="table table-dark table-striped">
<thead>
<td>NOME</td>
<td>VEICULO</td>
<td>EMPRESA</td>
<td>PLACA</td>
<td>RG</td>
<td></td>
</thead>
<tbody>
<?php
include_once("conexao.php");
$sql = "SELECT * FROM pessoas_cadastradas";
$sql =  $conn->query($sql) or die($conn->error);
while($dado = $sql->fetch_array()){
?>
<form class="" action="processa.php" method="post">
<tr>
<td> <input class="form-control" type="text" name="nome"
value="<?php echo $dado['nome']; ?>"> </td>
<td> <input class="form-control" type="text" name="veiculo"
value="<?php echo $dado['veiculo']; ?>"> </td>
<td> <input class="form-control" type="text" name="empresa"
value="<?php echo $dado['empresa']; ?>"> </td>
<td> <input class="form-control" type="text" name="placa"
value="<?php echo $dado['placa']; ?>"> </td>
<td> <input class="form-control" type="text" name="rg"
value="<?php echo $dado['rg']; ?>"> </td>
<td> <button class="btn btn-primary" type="submit"
value="<?php echo $dado['id_registro']; ?>"
name="confirmaAjusteCadastro2">Confirmar</button> </td>
</tr>
</form>
<?php } ?>
</tbody>
</table>
<?php endif; ?>
<?php endif; ?>
<?php if (isset($_POST['Usuarios']) && $user['tipo'] == "gr"): ?>

  <br>
  <h3 class="VeiculoE">Cadastro Usuarios</h3>
  <table class="table table-warning">
    <thead>
      <tr>
        <td>Usuario</td>
        <td>Senha</td>
        <td>Tipo</td>
        <td>Local</td>
        <td>Nome</td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      <form class="" action="processa.php" method="post">
      <tr>
        <td> <input class="form-control" type="text" name="usuario" value=""> </td>
        <td> <input class="form-control" type="password" name="senha" value=""> </td>
        <td> <select class="form-control" name="tipo">
             <option value=""></option>
             <option value="po">Portaria</option>
             <option value="gr">Gris</option>
             <option value="op">Opereção</option>
        </select> </td>
        <td> <select class="form-control" name="local">
             <option value=""></option>
             <option value="SP">São Paulo</option>
             <option value="PE">Recife</option>
        </select> </td>
        <td> <input class="form-control" type="text" name="nome" value=""> </td>
        <td> <button class="btn btn-success" type="submit" name="cadastrarUsuario">Cadastrar</button> </td>
      </tr>
      </form>
    </tbody>
  </table>
  <br>
  <h3 class="VeiculoE">Usuarios cadastrados</h3>
  <table class="table table-warning">
    <thead>
      <tr>
        <td>Usuario</td>
        <td>Senha</td>
        <td>Tipo</td>
        <td>Local</td>
        <td>Nome</td>
        <td></td>
      </tr>
    </thead>
    <tbody>
      <?php
      include_once("conexao.php");
      $sql = "SELECT * FROM uses";
      $sql =  $conn->query($sql) or die($conn->error);
      while($dado = $sql->fetch_array()){
       ?>
       <form class="" action="processa.php" method="post">
       <tr>
         <td> <input class="form-control" type="text" name="usuario" value="<?php echo $dado['user']; ?>"> </td>
         <td> <input class="form-control" type="password" name="senha" value=""> </td>
         <td> <select class="form-control" name="tipo">
              <?php if ($dado['tipo'] == "po"): ?>
                <option class="form-control" value="po">Portaria</option>
                <option class="form-control" value="gr">Gris</option>
                <option class="form-control" value="op">Operação</option>
              <?php endif; ?>
              <?php if ($dado['tipo'] == "gr"): ?>
                <option class="form-control" value="gr">Gris</option>
                <option class="form-control" value="po">Portaria</option>
                <option class="form-control" value="op">Operação</option>
              <?php endif; ?>
              <?php if ($dado['tipo'] == "op"): ?>
                <option class="form-control" value="op">Operação</option>
                <option class="form-control" value="po">Portaria</option>
                <option class="form-control" value="gr">Gris</option>
              <?php endif; ?>
         </select> </td>
         <td> <select class="form-control" name="local">
                <?php if ($dado['local'] == "SP"): ?>
                  <option class="form-control" value="SP">São Paulo</option>
                  <option class="form-control" value="PE">Recife</option>
                <?php endif; ?>
                <?php if ($dado['local'] == "PE"): ?>
                  <option class="form-control" value="PE">Recife</option>
                  <option class="form-control" value="SP">São Paulo</option>
                <?php endif; ?>
         </select> </td>
         <td> <input class="form-control" type="text" name="nome" value="<?php echo $dado['nome']; ?>"> </td>
         <td> <button class="btn btn-success" type="submit" value="<?php echo $dado['id_registro']; ?>" name="confirmaAjusteCadastro">Confirmar</button> </td>
       </tr>
        </form>
     <?php } ?>
    </tbody>
  </table>
<?php endif; ?>

</div>
</body>
</html>
<?php }else{
?>
<script type="text/javascript">
window.location.href = "index.php";
</script>
<?php
} ?>
