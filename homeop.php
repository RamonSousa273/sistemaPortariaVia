<?php
session_start();
if (isset($_SESSION['llusuario'])) {
$user=$_SESSION['llusuario'];
$local=$user['local'];
include_once("conexao.php");
$data = date('Y-m-d');
$data1 = date('Y-m-d');
$data2 = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<title>Home - Operação</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
<link rel="stylesheet" href="css/master3.css">
<script type="text/javascript">
function exportTableToExcel(tableID, filename = 'Relatorio'){
var downloadLink;
var dataType = 'application/vnd.ms-excel';
var tableSelect = document.getElementById(tableID);
var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
filename = filename?filename+'.xls':'excel_data.xls';
downloadLink = document.createElement("a");
document.body.appendChild(downloadLink);
if(navigator.msSaveOrOpenBlob){
var blob = new Blob(['\ufeff', tableHTML], {
type: dataType
});
navigator.msSaveOrOpenBlob( blob, filename);
}else{
downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
downloadLink.download = filename;
downloadLink.click();
}
}
</script>
</head>
<body>
<?php if (!isset($_POST['dataI'])): ?>
<div class="divRelatorio">
<br>
<h3 class="VeiculoE">Ralatório Veiculos</h3>
<br>
<form class="" action="" method="post">
<p>Data Inicial: <input type="date" name="dataI" value="<?php echo $data1; ?>">
Data Final: <input type="date" name="dataF" value="<?php echo $data2; ?>">
Placa: <input type="text" name="placa" placeholder="AAA-0000" value="">
<input type="submit" name="" value="Buscar">
</p>
</form>
<button class="btn btn-success" onclick="exportTableToExcel('tblData')"><i class="fa fa-file-excel-o"
style="color: white"></i> Exportar para o Excel</button>
<button class="btn btn-danger" type="button" value="Criar PDF" id="btnImprimir" onclick="CriaPDF()">
<i class="fa fa-file-pdf-o" style="color: white"></i> Gerar PDF</button>
<button class="btn btn-light" onclick="window.location.href = 'processaLogout.php'" type="button"
value="" id="btnImprimir"><i class="fa fa-sign-out"></i> Sair </button>
<br>
<div id="tblData2">
<table id="tblData" border="1" class="table table-danger">
<thead>
<tr>
<td>Data saida</td>
<td>Data entrada</td>
<td>Hora saida</td>
<td>Hora entrada</td>
<td>Frota</td>
<td>Motorista saida</td>
<td>Motorista entrada</td>
<td>Placa</td>
<td>Modelo Veiculo</td>
<td>KM saida</td>
<td>KM entrada</td>
<td>Diferença de KM</td>
<td>Porteiro</td>
<td>Status</td>
</tr>
</thead>
<tbody>
<?php $sql = "SELECT * FROM veiculoses WHERE data_saida = '$data1' AND Local = '$local'";
$sql = $conn->query($sql) or die($conn->error);
while($dado = $sql->fetch_array()){
?>
<tr>
<td><?php echo date("d/m/Y", strtotime($dado['data_saida'])); ?></td>
<td><?php echo date("d/m/Y", strtotime($dado['data_entrada'])); ?></td>
<td><?php echo $dado['hora_saida']; ?></td>
<td><?php echo $dado['hora_entrada']; ?></td>
<td><?php echo strtoupper($dado['frota']); ?></td>
<td><?php echo strtoupper($dado['motorista_saida']); ?></td>
<td><?php echo strtoupper($dado['motorista_entrada']); ?></td>
<td><?php echo strtoupper($dado['placa']); ?></td>
<td><?php echo strtoupper($dado['veiculo']); ?></td>
<?php
$kms=$dado['km_saida'];
$kme=$dado['km_entrada'];
if ($dado['km_saida']=="") {
$kms = $dado['km_entrada'];
}
if ($dado['km_entrada']=="") {
$kme = $dado['km_saida'];
}
if ($dado['km_saida']=="" && $dado['km_entrada']=="") {
$kms = 0;
$kme=0;
}
?>
<td><?php echo $kms; ?></td>
<td><?php echo $kme; ?></td>
<td><?php if (($kme-$kms) < 0) {
  echo "--";
}else{
  echo $kme-$kms;
} ?></td>
<td><?php echo $dado['porteiro']; ?></td>
<td> <?php if ($dado['status'] == "Manutenção") {
echo "Manutenção";
}else{
echo "Viagem";
} ?> </td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
<?php endif; ?>
<?php if (isset($_POST['dataI'])):
$data1 = $_POST['dataI'];
$data2 = $_POST['dataF'];
$placa = $_POST['placa'];
?>
<div class="divRelatorio">
<br>
<h3 class="VeiculoE">Raletório Veiculos</h3>
<br>
<form class="" action="" method="post">
<p>Data Inicial: <input type="date" name="dataI" value="<?php echo $data1; ?>">
Data Final: <input type="date" name="dataF" value="<?php echo $data2; ?>">
Placa: <input type="text" name="placa" placeholder="AAA-0000" value="">
<input type="submit" name="" value="Buscar">
</p>
</form>
<button class="btn btn-success" onclick="exportTableToExcel('tblData')"><i class="fa fa-file-excel-o"
style="color: white"></i> Exportar para o Excel</button>
<button class="btn btn-danger" type="button" value="Criar PDF" id="btnImprimir" onclick="CriaPDF()">
<i class="fa fa-file-pdf-o" style="color: white"></i> Gerar PDF</button>
<button class="btn btn-light" onclick="window.location.href = 'processaLogout.php'" type="button"
 value="" id="btnImprimir"><i class="fa fa-sign-out"></i> Sair </button>
<br>
<div id="tblData2">
<table id="tblData" border="1" class="table table-danger">
<thead>
<tr>
<td>Data saida</td>
<td>Data entrada</td>
<td>Hora saida</td>
<td>Hora entrada</td>
<td>Frota</td>
<td>Motorista saida</td>
<td>Motorista entrada</td>
<td>Placa</td>
<td>Modelo Veiculo</td>
<td>KM saida</td>
<td>KM entrada</td>
<td>Diferença de KM</td>
<td>Porteiro</td>
<td>Status</td>
</tr>
</thead>
<tbody>
<?php if ($placa != "") {
  $sql = "SELECT * FROM veiculoses WHERE data_saida >= '$data1'
   AND data_entrada <= '$data2' AND local = '$local' AND placa = '$placa'";
}else{
$sql = "SELECT * FROM veiculoses WHERE data_saida >= '$data1'
 AND data_entrada <= '$data2' AND local = '$local'";}
$sql = $conn->query($sql) or die($conn->error);
while($dado = $sql->fetch_array()){ ?>
<tr>
<td><?php echo date("d/m/Y", strtotime($dado['data_saida'])); ?></td>
<td><?php echo date("d/m/Y", strtotime($dado['data_entrada'])); ?></td>
<td><?php echo $dado['hora_saida']; ?></td>
<td><?php echo $dado['hora_entrada']; ?></td>
<td><?php echo strtoupper($dado['frota']); ?></td>
<td><?php echo strtoupper($dado['motorista_saida']); ?></td>
<td><?php echo strtoupper($dado['motorista_entrada']); ?></td>
<td><?php echo strtoupper($dado['placa']); ?></td>
<td><?php echo strtoupper($dado['veiculo']); ?></td>
<?php
$kms=$dado['km_saida'];
$kme=$dado['km_entrada'];
if ($dado['km_saida']=="") {
$kms = $dado['km_entrada'];
}
if ($dado['km_entrada']=="") {
$kme = $dado['km_saida'];
}
if ($dado['km_saida']=="" && $dado['km_entrada']=="") {
$kms = 0;
$kme=0;
}
?>
<td><?php echo $kms; ?></td>
<td><?php echo $kme; ?></td>
<td><?php if (($kme-$kms) < 0) {
  echo "--";
}else{
  echo $kme-$kms;
} ?></td>
<td><?php echo $dado['porteiro']; ?></td>
<td> <?php if ($dado['status'] == "Manutenção") {
echo "Manutenção";
}else{
echo "Viagem";
} ?> </td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
<?php endif; ?>
</body>
<script>
function CriaPDF() {
var minhaTabela = document.getElementById('tblData2').innerHTML;
var style = "<style>";
style = style + "table {width: 100%;font: 20px Calibri;}";
style = style + "table, th, td {border: solid 1px #DDD; border-collapse: collapse;";
style = style + "padding: 2px 3px;text-align: center;}";
style = style + "</style>";
var win = window.open('', '', 'height=700,width=700');
win.document.write('<html><head>');
win.document.write('<title>Relatorio</title>');
win.document.write(style);
win.document.write('</head>');
win.document.write('<body>');
win.document.write(minhaTabela);
win.document.write('</body></html>');
win.document.close();
win.print();
}
</script>
</html>
<?php } ?>
