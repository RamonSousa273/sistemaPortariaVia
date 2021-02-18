<?php
session_start();
if (isset($_SESSION['llusuario'])) {
$user = $_SESSION['llusuario'];
include_once("conexao.php");

//Registrar entrada de um veiculo
if (isset($_POST['confirmaEntradaVeiculo'])) {
$local = $user['local'];
$placa = $_POST['placa'];
$veiculo = $_POST['veiculo'];
$frota = $_POST['frota'];
$motorista = $_POST['motorista'];
$horachegada = $_POST['horaChegada'];
$km = $_POST['kmEntrada'];
$porteiro = $user['nome'];
if ($user['nome'] == "") {
$porteiro = $_POST['porteiro'];
}
$hora = date('H:i:s');
$data = date('Y-m-d');
$status = "Dentro";
$sql = "SELECT * FROM veiculos_cadastrados WHERE placa = '$placa'";
$sql = $conn->query($sql) or die($conn->error);
$dado=$sql->fetch_array();
if ($dado['status'] == "Dentro") {
$_SESSION['guardaEntrada'] = array('placa' => $placa,'veiculo' => $veiculo,'frota' => $frota,
'motorista' => $motorista,'kmEntrada' => $km,'porteiro' => $porteiro );
?>
<script>
alert("Veiculo já deu entrada!");
window.location.href = "veiculos.php";
</script>
<?php
}else{
if (!is_numeric($km)) {
$_SESSION['guardaEntrada'] = array('placa' => $placa,'veiculo' => $veiculo,'frota' => $frota,
'motorista' => $motorista,'kmEntrada' => $km,'porteiro' => $porteiro );
?>
<script>
alert("Digite um km numerico!");
window.location.href = "veiculos.php";
</script>
<?php
}else{
if ($placa != "" && $veiculo != "" && $frota != "" && $motorista != "" && $km != "" && $porteiro != "") {
$sql2 = "SELECT * FROM veiculos_cadastrados WHERE placa = '$placa'";
$sql2 = $conn->query($sql2) or die($conn->error);
$dado = $sql2->fetch_array();
if ($dado['km_anterior'] > $km) {
$_SESSION['guardaEntrada'] = array('placa' => $placa,'veiculo' => $veiculo,'frota' => $frota,
'motorista' => $motorista,'kmEntrada' => $km,'porteiro' => $porteiro );
?>
<script>
alert("KM menor que na ultima viagem!");
window.location.href = "veiculos.php";
</script>
<?php
}else{
$sql2 = "UPDATE veiculos_cadastrados SET km_anterior = '$km' WHERE veiculos_cadastrados.placa = '$placa'";
$sql2=$conn->query($sql2) or die($conn->error);
$sql = "INSERT INTO
veiculoses(data_entrada, hora_entrada,frota,veiculo,km_entrada,placa,hora_chegada,motorista_entrada,Local,porteiro,status)
VALUES ('$data','$hora','$frota','$veiculo','$km','$placa','$horachegada','$motorista','$local','$porteiro','$status')";
$grava = mysqli_query($conn, $sql);
$sql = "UPDATE veiculos_cadastrados SET status = 'Dentro' WHERE veiculos_cadastrados.placa = '$placa'";
$sql = mysqli_query($conn, $sql);
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}
}else{
$_SESSION['guardaEntrada'] = array('placa' => $placa,'veiculo' => $veiculo,'frota' => $frota,
'motorista' => $motorista,'kmEntrada' => $km,'porteiro' => $porteiro );
?>
<script>
alert("Faltam dados!");
window.location.href = "veiculos.php";
</script>
<?php
}
}
}
}
//Registrar saída de um veiculo
if (isset($_POST['confirmaSaidaVeiculo'])) {
$local = $user['local'];
$hora = date('H:i:s');
$data = date('Y-m-d');
$veiculo = $_POST['veiculo'];
$placa = $_POST['placa'];
$frota = $_POST['frota'];
$motorista = $_POST['motorista'];
$km = $_POST['kmSaida'];
$porteiro = $user['nome'];
if ($user['nome'] == "") {
$porteiro = $_POST['porteiro'];
}
$status = "Fora";
$sql = "SELECT * FROM veiculos_cadastrados WHERE placa = '$placa'";
$sql = $conn->query($sql) or die($conn->error);
$dado = $sql->fetch_array();
if ($dado['status'] == "Fora") {
$_SESSION['guardaSaida'] = array('placa' => $placa,'veiculo' => $veiculo,'frota' => $frota,
'motorista' => $motorista,'km' => $km,'porteiro' => $porteiro );
?>
<script>
alert("Veiculo já registrou saída!");
window.location.href = "veiculos.php";
</script>
<?php
}
else{

if (!is_numeric($km)) {
$_SESSION['guardaSaida'] = array('placa' => $placa,'veiculo' => $veiculo,'frota' => $frota,
'motorista' => $motorista,'km' => $km,'porteiro' => $porteiro );
?>
<script>
alert("Digite um km numerico!");
window.location.href = "veiculos.php";
</script>
<?php
}else{
if ($veiculo != "" && $placa != "" && $frota != "" && $motorista != "" && $km != "" && $porteiro != "") {
$sql2 = "SELECT * FROM veiculos_cadastrados WHERE placa = '$placa'";
$sql2 = $conn->query($sql2) or die($conn->error);
$dado = $sql2->fetch_array();
if ($dado['km_anterior'] > $km) {
$_SESSION['guardaSaida'] = array('placa' => $placa,'veiculo' => $veiculo,'frota' => $frota,
'motorista' => $motorista,'km' => $km,'porteiro' => $porteiro );
?>
<script>
alert("KM menor que na ultima viagem!");
window.location.href = "veiculos.php";
</script>
<?php
}else{
$sql = "UPDATE veiculos_cadastrados SET status = 'Fora' WHERE veiculos_cadastrados.placa = '$placa'";
$sql=$conn->query($sql) or die($conn->error);
$sql2 = "UPDATE veiculos_cadastrados SET km_anterior = '$km' WHERE veiculos_cadastrados.placa = '$placa'";
$sql2=$conn->query($sql2) or die($conn->error);
$sql = "INSERT INTO
veiculoses(data_saida, hora_saida,frota,km_saida,motorista_saida,placa,porteiro,veiculo,Local,status)
VALUES ('$data','$hora','$frota','$km','$motorista','$placa','$porteiro','$veiculo','$local','$status')";
$grava = mysqli_query($conn, $sql);
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}
}else{
$_SESSION['guardaSaida'] = array('placa' => $placa,'veiculo' => $veiculo,'frota' => $frota,
'motorista' => $motorista,'km' => $km,'porteiro' => $porteiro );
?>
<script>
alert("Faltam dados!");
window.location.href = "veiculos.php";
</script>
<?php
}
}
}
}
//Registrar entrada de pessoa
if (isset($_POST['confirmaEntradaPessoa'])) {
$local = $user['local'];
$data = date('Y-m-d');
$hora = date('H:i:s');
$nome = $_POST['nome'];
$empresa = $_POST['empresa'];
$rg = $_POST['rg'];
$veiculo = $_POST['veiculo'];
$placa = $_POST['placa'];
$contato = $_POST['contatoVia'];
$porteiro = $user['nome'];
if ($nome != "" && $rg != "" && $contato != "" && $porteiro != "") {
// code...
$sql = "INSERT INTO
pessoas(data, hora_chegada, nome, empresa, rg, veiculo, placa, contato_via, porteiro,local)
VALUES ('$data','$hora','$nome','$empresa','$rg','$veiculo','$placa','$contato','$porteiro','$local')";
$grava = mysqli_query($conn, $sql);
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}else{
?>
<script>
alert("Faltam dados!");
window.location.href = "corpo.html";
</script>
<?php
}
}
//Registrar saída de pessoa
if (isset($_POST['confirmaSaidaPessoa'])) {
$id = $_POST['id'];
$hora = date('H:i:s');
if ($id != "") {
// code...
$sql = "UPDATE pessoas SET hora_saida = '$hora' WHERE pessoas.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}else{
?>
<script>
alert("Pessoa não selecionada!");
window.location.href = "corpo.html";
</script>
<?php
}
}
//Registrar cadastro de veiculo (Anexo 1)
if (isset($_POST['confirmaCadastroVeiculo'])) {
$local = $user['local'];
$veiculo = $_POST['veiculo'];
$placa = $_POST['placa'];
$frota = $_POST['frota'];
$motorista = $_POST['motorista'];
$sql = "SELECT * FROM veiculos_cadastrados";
$sql2 = $conn->query($sql) or die($conn->error);
$quantia = 0;
while($dado = $sql2->fetch_array()){
if ($dado['placa'] == $placa) {
$quantia = 1;
}
}
if ($quantia == 0) {
$sql = "INSERT INTO veiculos_cadastrados(frota, motorista, placa, veiculo,local)
VALUES ('$frota','$motorista','$placa','$veiculo','$local')";
$grava = mysqli_query($conn, $sql);
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}else{
?>
<script>
alert("Já cadastrado");
window.location.href = "corpo.html";
</script>
<?php
}
}
//Registrar cadastro de pessoa (Anexo 2)
if (isset($_POST['confirmaCadastroPessoa'])) {
$local = $user['local'];
$nome = $_POST['nome'];
$veiculo = $_POST['veiculo'];
$empresa = $_POST['empresa'];
$placa = $_POST['placa'];
$rg =  $_POST['rg'];
$sql = "SELECT * FROM pessoas_cadastradas";
$sql2 = $conn->query($sql) or die($conn->error);
$quantia = 0;
while($dado = $sql2->fetch_array()){
if ($dado['rg'] == $rg) {
$quantia = 1;
}
}
if ($quantia == 0) {
$sql = "INSERT INTO pessoas_cadastradas(nome, veiculo, empresa, placa, rg,local)
VALUES ('$nome', '$veiculo', '$empresa', '$placa', '$rg','$local')";
$grava = mysqli_query($conn, $sql);
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}else{
?>
<script>
alert("Já cadastrado");
window.location.href = "corpo.html";
</script>
<?php
}
}

//Registrar volta de veiculo da casa
if (isset($_POST['confirmaVoltaVeiculo'])) {
$data = date('Y-m-d');
$id = $_POST['confirmaVoltaVeiculo'];
$hora = date('H:i:s');
$horachegada = $_POST['horaChegada'];
$km = $_POST['kmVoltaa'];
$motorista = $_POST['motorista'];
if (!is_numeric($km)) {
?>
<script>
alert("Digite um km numerico!");
window.location.href = "corpo.html";
</script>
<?php
}else{
if ($id != "" && $km != "" && $motorista != "") {
// code...
$sql = "SELECT * FROM veiculoses WHERE id_registro = '$id'";
$sql2 = $conn->query($sql) or die($conn->error);
$dado = $sql2->fetch_array();
$num = $dado['km_saida'];
$placa = $dado['placa'];
if ($km < $num && $dado['status'] != "Manutencao") {
$_SESSION['veiculoEnt'] = "entra";
?>
<script>
alert("KM menor que o anterior!");
window.location.href = "veiculos.php";
</script>
<?php
}else{
if ($dado['status']=="Manutencao") {
$sql = "UPDATE veiculos_cadastrados SET status = 'Dentro' WHERE veiculos_cadastrados.placa = '$dado[placa]'";
$sql2=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculoses SET data_entrada = '$data' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculoses SET motorista_entrada = '$motorista' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
$sql2 = "UPDATE veiculoses SET hora_chegada = '$horachegada' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql2) or die($conn->error);
$sql = "UPDATE veiculoses SET hora_entrada = '$hora' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculoses SET km_entrada = '$km' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
}else{
$sql2 = "UPDATE veiculos_cadastrados SET km_anterior = '$km' WHERE veiculos_cadastrados.placa = '$placa'";
$sql2=$conn->query($sql2) or die($conn->error);
$sql2 = "UPDATE veiculoses SET hora_chegada = '$horachegada' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql2) or die($conn->error);
$sql = "UPDATE veiculos_cadastrados SET status = 'Dentro' WHERE veiculos_cadastrados.placa = '$dado[placa]'";
$sql2=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculoses SET data_entrada = '$data' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculoses SET motorista_entrada = '$motorista' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculoses SET hora_entrada = '$hora' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculoses SET km_entrada = '$km' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
}
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}
}else{
?>
<script>
alert("Faltam dados!");
window.location.href = "corpo.html";
</script>
<?php
}
}
}
//Registrar saida de um agregado
if (isset($_POST['confirmaSaidaAgregado'])) {
$km2 = 0;
$km = $_POST['kmSaida'];
$data = date('Y-m-d');
$id = $_POST['confirmaSaidaAgregado'];
$hora = date('H:i:s');
if (!is_numeric($km)) {
?>
<script>
alert("Digite um km numerico!");
window.location.href = "corpo.html";
</script>
<?php
}else{
$sql = "SELECT * FROM veiculoses WHERE id_registro = '$id'";
$sql2 = $conn->query($sql) or die($conn->error);
$dado = $sql2->fetch_array();
$placa=$dado['placa'];
$sql = "SELECT * FROM veiculoses WHERE placa = '$placa' AND data_saida = '$data'";
$sql2 = $conn->query($sql) or die($conn->error);
while($dado = $sql2->fetch_array()){
$km2 = $dado['km_entrada'];
$placa = $dado['placa'];
}
if ($id != "" && $km != "") {
$sql2 = "UPDATE veiculos_cadastrados SET km_anterior = '$km' WHERE veiculos_cadastrados.placa = '$placa'";
$sql2=$conn->query($sql2) or die($conn->error);
$sql = "SELECT * FROM veiculoses WHERE id_registro = '$id'";
$sql2 = $conn->query($sql) or die($conn->error);
$dado = $sql2->fetch_array();
$sql = "UPDATE veiculoses SET motorista_saida = '$dado[motorista_entrada]' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculoses SET data_saida = '$data' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculoses SET hora_saida = '$hora' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
if ($km2 > 0) {
$sql = "UPDATE veiculoses SET km_saida = '$km2' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculoses SET km_entrada = '$km' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);
}else{
$sql = "UPDATE veiculoses SET km_saida = '$km' WHERE veiculoses.id_registro = '$id'";
$sql2=$conn->query($sql) or die($conn->error);}
$sql="UPDATE veiculos_cadastrados SET status = 'Fora' WHERE veiculos_cadastrados.placa = '$placa'";
$sql2=$conn->query($sql) or die($conn->error);
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}else{
?>
<script>
alert("Faltam dados!");
window.location.href = "corpo.html";
</script>
<?php
}
}
}
//Registrar saída para manutenção
if (isset($_POST['confirmaSaidaVeiculoManutensao'])) {
$local = $user['local'];
$hora = date('H:i:s');
$data = date('Y-m-d');
$veiculo = $_POST['veiculo'];
$placa = $_POST['placa'];
$frota = $_POST['frota'];
$motorista = $_POST['motorista'];
$km = $_POST['kmSaida'];
$porteiro = $user['nome'];
$status = "Manutencao";
if (!is_numeric($km)) {
$_SESSION['guardaSaida'] = array('placa' => $placa,'veiculo' => $veiculo,'frota' => $frota,
'motorista' => $motorista,'km' => $km,'porteiro' => $porteiro );
?>
<script>
alert("Registr um km numérico");
window.location.href = "veiculos.php";
</script>
<?php
}else{
$sql = "INSERT INTO
veiculoses(data_saida, hora_saida,frota,km_saida,motorista_saida,placa,porteiro,veiculo,Local,status)
VALUES ('$data','$hora','$frota','$km','$motorista','$placa','$porteiro','$veiculo','$local','$status')";
$grava = mysqli_query($conn, $sql);
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}
}
if (isset($_POST['confirmaSaidaVeiculoAbastecimento'])) {
  $local = $user['local'];
$hora = date('H:i:s');
$data = date('Y-m-d');
$veiculo = $_POST['veiculo'];
$placa = $_POST['placa'];
$frota = $_POST['frota'];
$motorista = $_POST['motorista'];
$km = $_POST['kmSaida'];
$porteiro = $user['nome'];
$status = "Abastecimento";
if (!is_numeric($km)) {
$_SESSION['guardaSaida'] = array('placa' => $placa,'veiculo' => $veiculo,'frota' => $frota,
'motorista' => $motorista,'km' => $km,'porteiro' => $porteiro );
?>
<script>
alert("Registr um km numérico");
window.location.href = "veiculos.php";
</script>
<?php
}else{
$sql = "INSERT INTO
veiculoses(data_saida, hora_saida,frota,km_saida,motorista_saida,placa,porteiro,veiculo,Local,status)
VALUES ('$data','$hora','$frota','$km','$motorista','$placa','$porteiro','$veiculo','$local','$status')";
$grava = mysqli_query($conn, $sql);
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}
}
//Confirmar ajustes no cadastro anexo 1
if (isset($_POST['confirmaAjusteCadastro1'])) {
$id = $_POST['confirmaAjusteCadastro1'];
$frota = $_POST['frota'];
$motorista = $_POST['motorista'];
$placa = $_POST['placa'];
$veiculo = $_POST['veiculo'];
$sql = "UPDATE veiculos_cadastrados SET frota = '$frota' WHERE veiculos_cadastrados.id_registro = '$id'";
$sql=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculos_cadastrados SET motorista = '$motorista' WHERE veiculos_cadastrados.id_registro = '$id'";
$sql=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculos_cadastrados SET placa = '$placa' WHERE veiculos_cadastrados.id_registro = '$id'";
$sql=$conn->query($sql) or die($conn->error);
$sql = "UPDATE veiculos_cadastrados SET veiculo = '$veiculo' WHERE veiculos_cadastrados.id_registro = '$id'";
$sql=$conn->query($sql) or die($conn->error);
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}
//confirmar ajustes no cadastro anexo 2
if (isset($_POST['confirmaAjusteCadastro2'])) {
$id = $_POST['confirmaAjusteCadastro2'];
$nome = $_POST['nome'];
$veiculo = $_POST['veiculo'];
$empresa = $_POST['empresa'];
$placa = $_POST['placa'];
$rg = $_POST['rg'];
$sql = "UPDATE pessoas_cadastradas SET nome = '$nome' WHERE pessoas_cadastradas.id_registro = '$id'";
$sql=$conn->query($sql) or die($conn->error);
$sql = "UPDATE pessoas_cadastradas SET veiculo = '$veiculo' WHERE pessoas_cadastradas.id_registro = '$id'";
$sql=$conn->query($sql) or die($conn->error);
$sql = "UPDATE pessoas_cadastradas SET empresa = '$empresa' WHERE pessoas_cadastradas.id_registro = '$id'";
$sql=$conn->query($sql) or die($conn->error);
$sql = "UPDATE pessoas_cadastradas SET placa = '$placa' WHERE pessoas_cadastradas.id_registro = '$id'";
$sql=$conn->query($sql) or die($conn->error);
$sql = "UPDATE pessoas_cadastradas SET rg = '$rg' WHERE pessoas_cadastradas.id_registro = '$id'";
$sql=$conn->query($sql) or die($conn->error);
?>
<script>
alert("Registrado com sucesso");
window.location.href = "corpo.html";
</script>
<?php
}
if (isset($_POST['cadastrarUsuario'])) {
$user = $_POST['usuario'];
$senha = md5($_POST['senha']);
$tipo = $_POST['tipo'];
$local = $_POST['local'];
$nome = $_POST['nome'];
if ($tipo == "po") {
  if ($user == "" || $senha == "" || $tipo == "" || $local == "" || $nome == "") {
    ?>
    <script>
    alert("Faltam dados!");
    window.location.href = "corpo.html";
    </script>
    <?php
  }else{
    $sql = "INSERT INTO uses (user, sen, tipo, local, nome) VALUES ('$user', '$senha', '$tipo', '$local', '$nome')";
    $grava = mysqli_query($conn, $sql);
    ?>
    <script>
    alert("Cadastrado com sucesso!");
    window.location.href = "corpo.html";
    </script>
    <?php
  }
}else{
  if ($user == "" || $senha == "" || $tipo == "" || $local == "") {
    ?>
    <script>
    alert("Faltam dados!");
    window.location.href = "corpo.html";
    </script>
    <?php
  }else{
    $sql = "INSERT INTO uses (user, sen, tipo, local, nome) VALUES ('$user', '$senha', '$tipo', '$local', '$nome')";
    $grava = mysqli_query($conn, $sql);
    ?>
    <script>
    alert("Cadastrado com sucesso!");
    window.location.href = "corpo.html";
    </script>
    <?php
  }
}
}
if (isset($_POST['confirmaAjusteCadastro'])) {
  $id=$_POST['confirmaAjusteCadastro'];
  $user=$_POST['usuario'];
  $senha=$_POST['senha'];
  $tipo=$_POST['tipo'];
  $local=$_POST['local'];
  $nome=$_POST['nome'];
  $sql = "UPDATE uses SET user = '$user' WHERE uses.id_registro = '$id'";
  $sql=$conn->query($sql) or die($conn->error);
  $sql = "UPDATE uses SET tipo = '$tipo' WHERE uses.id_registro = '$id'";
  $sql=$conn->query($sql) or die($conn->error);
  $sql = "UPDATE uses SET local = '$local' WHERE uses.id_registro = '$id'";
  $sql=$conn->query($sql) or die($conn->error);
  $sql = "UPDATE uses SET nome = '$nome' WHERE uses.id_registro = '$id'";
  $sql=$conn->query($sql) or die($conn->error);
  if ($senha != "") {
    $senha=md5($senha);
    $sql = "UPDATE uses SET sen = '$senha' WHERE uses.id_registro = '$id'";
    $sql=$conn->query($sql) or die($conn->error);
  }
  ?>
  <script>
  alert("Alterado com sucesso!");
  window.location.href = "corpo.html";
  </script>
  <?php
}
if (isset($_POST['confirmaAjuste'])) {
  $id=$_POST['confirmaAjuste'];
  $kms=$_POST['km_saida'];
  $kme=$_POST['km_entrada'];
  $motoristaS=$_POST['motoristaSaida'];
  $motoristaE=$_POST['motoristaEntrada'];
  $placa=$_POST['placa'];
  $veiculo=$_POST['veiculo'];

  $sql = "UPDATE veiculoses SET motorista_saida = '$motoristaS' WHERE veiculoses.id_registro = '$id'";
  $sql=$conn->query($sql) or die($conn->error);
  $sql = "UPDATE veiculoses SET motorista_entrada = '$motoristaE' WHERE veiculoses.id_registro = '$id'";
  $sql=$conn->query($sql) or die($conn->error);
  $sql = "UPDATE veiculoses SET placa = '$placa' WHERE veiculoses.id_registro = '$id'";
  $sql=$conn->query($sql) or die($conn->error);
  $sql = "UPDATE veiculoses SET veiculo = '$veiculo' WHERE veiculoses.id_registro = '$id'";
  $sql=$conn->query($sql) or die($conn->error);

  $sql = "UPDATE veiculoses SET km_saida = '$kms' WHERE veiculoses.id_registro = '$id'";
  $sql=$conn->query($sql) or die($conn->error);
  $sql = "UPDATE veiculoses SET km_entrada = '$kme' WHERE veiculoses.id_registro = '$id'";
  $sql=$conn->query($sql) or die($conn->error);
  $sql = "UPDATE veiculos_cadastrados SET km_anterior = '$kme' WHERE veiculos_cadastrados.placa = '$placa'";
  $sql=$conn->query($sql) or die($conn->error);
  ?>
  <script>
  alert("Alterado com sucesso!");
  window.location.href = "corpo.html";
  </script>
  <?php
}
if (isset($_POST['Ex'])) {
  $id = $_POST['Ex'];
  echo "
  <link rel=\"stylesheet\" href=\"https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css\"
  integrity=\"sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk\"
  crossorigin=\"anonymous\">
  <link rel=\"stylesheet\" href=\"css/master.css\">
  <div class=\"conte\">
  <div class=\"confirm\">
    <form class=\"\" action=\"processa.php\" method=\"post\">
      <h3>Confirma a exclusão deste registro?</h3>  <br>
      <div class=\"lado\">
      <button class=\"btn btn-danger\" type=\"submit\" value=\"$id\" name=\"sim\">Sim</button> <button type=\"submit\" class=\"btn btn-success\" name=\"nao\">Não</button>
      </div>
    </form>
  </div>
  </div>
";

}
if (isset($_POST['sim'])) {
  $id = $_POST['sim'];
  $sql = "DELETE FROM veiculoses WHERE veiculoses.id_registro = '$id'";
  $sql=$conn->query($sql) or die($conn->error);
  ?>
  <script>
  alert("Deletado com sucesso!");
  window.location.href = "corpo.html";
  </script>
  <?php
}
if (isset($_POST['nao'])) {
  ?>
  <script>
  window.location.href = "corpo.html";
  </script>
  <?php
}

}
?>
