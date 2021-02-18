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
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
    crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    rel="stylesheet">
    <link rel="stylesheet" href="css/master.css">
    <script type="text/javascript">
    function exportTableToExcel(tableID, filename = 'Relatorio'){
      var downloadLink;
      var dataType = 'application/vnd.ms-excel';
      var tableSelect = document.getElementById(tableID);
      var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');

      // Specify file name
      filename = filename?filename+'.xls':'excel_data.xls';

      // Create download link element
      downloadLink = document.createElement("a");

      document.body.appendChild(downloadLink);

      if(navigator.msSaveOrOpenBlob){
      var blob = new Blob(['\ufeff', tableHTML], {
          type: dataType
      });
      navigator.msSaveOrOpenBlob( blob, filename);
      }else{
      // Create a link to the file
      downloadLink.href = 'data:' + dataType + ', ' + tableHTML;

      // Setting the file name
      downloadLink.download = filename;

      //triggering the function
      downloadLink.click();
  }
}
    </script>

  </head>
  <body>
    <?php if (isset($_POST['Veiculos'])): ?>
      <div class="divRelatorio">
        <br>
        <h3 class="VeiculoE">Raletório Veiculos</h3>
        <br>
        <form class="" action="" method="post">
          <p>Data Inicial: <input type="date" name="dataI" value="<?php echo $data1; ?>">
            Data Final: <input type="date" name="dataF" value="<?php echo $data2; ?>">
            Placa: <input type="text" name="placa" placeholder="aaa-0000" value="">
            <input type="submit" name="" value="Buscar">
           </p>
        </form>
        <button class="btn btn-success" onclick="exportTableToExcel('tblData')"><i
          class="fa fa-file-excel-o" style="color: white"></i> Exportar para o Excel</button>
        <button class="btn btn-danger" type="button" value="Criar PDF" id="btnImprimir"
        onclick="CriaPDF()"><i class="fa fa-file-pdf-o" style="color: white"></i> Gerar PDF</button>
        <br>
        <div id="tblData2">


        <table id="tblData" border="1" class="table table-danger">
          <thead>
            <tr>
              <td>Data saida</td>
              <td>Data entrada</td>
              <td>Hora saida</td>
              <td>Hora chegada</td>
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
              <td></td>
            </tr>
          </thead>
          <tbody>
              <?php
              $placaA = "aaa-0000";
              $sql = "SELECT * FROM veiculoses WHERE data_saida = '$data1' AND local = '$local'";
                  $sql = $conn->query($sql) or die($conn->error);
            while($dado = $sql->fetch_array()){
              ?>
              <form class="" action="editaRegistro.php" method="post">
              <tr>
                <td><?php echo date("d/m/Y", strtotime($dado['data_saida'])); ?></td>
                <td><?php echo date("d/m/Y", strtotime($dado['data_entrada'])); ?></td>
              <td><?php echo $dado['hora_saida']; ?></td>
              <td><?php echo $dado['hora_chegada']; ?></td>
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
              <td> <?php if ($dado['status'] == "Manutencao") {
                echo "Manutenção";
              }else{
                echo "Viagem";
              } ?> </td>
              <?php if ($user['tipo'] == "gr"): ?>
                <td> <button class="btn btn-success" type="submit" value="<?php echo $dado['id_registro']; ?>" name="Editar">Editar</button> </td>
              <?php endif; ?>
              </form>
              <?php if ($user['tipo'] == "gr"): ?>
                <form class="" action="processa.php" method="post">
                  <td> <button class="btn btn-danger" type="submit" value="<?php echo $dado['id_registro']; ?>" name="Ex">Excluir</button></td>
                </form>
              <?php endif; ?>
            <?php  }
           ?>
           </tr>
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
            Placa: <input type="text" name="placa" value="">
            <input type="submit" name="" value="Buscar">
           </p>
        </form>
        <button class="btn btn-success" onclick="exportTableToExcel('tblData')"><i
          class="fa fa-file-excel-o" style="color: white"></i> Exportar para o Excel</button>
        <button class="btn btn-danger" type="button" value="Criar PDF" id="btnImprimir"
        onclick="CriaPDF()"><i class="fa fa-file-pdf-o" style="color: white"></i> Gerar PDF</button>
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
              <td></td>
            </tr>
          </thead>
          <tbody>
            <?php
            if ($placa != "") {
              $sql = "SELECT * FROM veiculoses WHERE data_saida >= '$data1'
               AND data_entrada <= '$data2' AND local = '$local' AND placa = '$placa'";
            }else{
            $sql = "SELECT * FROM veiculoses WHERE data_saida >= '$data1'
             AND data_entrada <= '$data2' AND local = '$local'";}
                  $sql = $conn->query($sql) or die($conn->error);
            while($dado = $sql->fetch_array()){ ?>
              <form class="" action="editaRegistro.php" method="post">
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
              <td> <?php if ($dado['status'] == "Manutencao") {
                echo "Manutenção";
              }else{
                echo "Viagem";
              } ?> </td>
              <?php if ($user['tipo'] == "gr"): ?>
                <td> <button class="btn btn-success" type="submit" value="<?php echo $dado['id_registro']; ?>" name="Editar">Editar</button> </td>
              <?php endif; ?>
              </form>
              <?php if ($user['tipo'] == "gr"): ?>
                <form class="" action="processa.php" method="post">
                  <td> <button class="btn btn-danger" type="submit" value="<?php echo $dado['id_registro']; ?>" name="Ex">Excluir</button></td>
                </form>
              <?php endif; ?>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      </div>
    <?php endif; ?>
    <?php if (isset($_POST['Pessoas'])): ?>
      <div class="divRelatorio">
        <br>
        <h3 class="VeiculoE">Raletório Veiculos</h3>
        <br>
        <form class="" action="" method="post">
          <p>Data Inicial: <input type="date" name="dataI2" value="<?php echo $data1; ?>">
            Data Final: <input type="date" name="dataF2" value="<?php echo $data2; ?>">
            RG: <input type="text" name="RG" value="">
            <input type="submit" name="" value="Buscar">
           </p>
        </form>
        <button class="btn btn-success" onclick="exportTableToExcel('tblData')"><i
          class="fa fa-file-excel-o" style="color: white"></i> Exportar para o Excel</button>
        <button class="btn btn-danger" type="button" value="Criar PDF" id="btnImprimir"
        onclick="CriaPDF()"><i class="fa fa-file-pdf-o" style="color: white"></i> Gerar PDF</button>
        <br>
        <div id="tblData2">
        <table id="tblData" border="1" class="table table-danger">
          <thead>
            <td>Data</td>
            <td>Hora chegada</td>
            <td>Hora saida</td>
            <td>Nome</td>
            <td>Empresa</td>
            <td>RG</td>
            <td>Tipo Veiculo</td>
            <td>Placa</td>
            <td>Contato via</td>
            <td>Porteiro</td>
          </thead>
          <tbody>
            <?php
            $sql = "SELECT * FROM pessoas WHERE data = '$data1' AND local = '$local'";
                  $sql = $conn->query($sql) or die($conn->error);
            while($dado = $sql->fetch_array()){ ?>
              <tr>
                <td><?php echo date("d/m/Y", strtotime($dado['data'])); ?></td>
                <td><?php echo $dado['hora_chegada']; ?></td>
                <td><?php echo $dado['hora_saida']; ?></td>
                <td><?php echo strtoupper($dado['nome']); ?></td>
                <td><?php echo strtoupper($dado['empresa']); ?></td>
                <td><?php echo strtoupper($dado['rg']); ?></td>
                <td><?php echo strtoupper($dado['veiculo']); ?></td>
                <td><?php echo strtoupper($dado['placa']); ?></td>
                <td><?php echo strtoupper($dado['contato_via']); ?></td>
                <td><?php echo strtoupper($dado['porteiro']); ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      </div>
    <?php endif; ?>
    <?php if (isset($_POST['dataI2'])):
      $data1 = $_POST['dataI2'];
      $data2 = $_POST['dataF2'];
      $rg = $_POST['RG'];
      ?>
      <div class="divRelatorio">
        <br>
        <h3 class="VeiculoE">Raletório Veiculos</h3>
        <br>
        <form class="" action="" method="post">
          <p>Data Inicial: <input type="date" name="dataI2" value="<?php echo $data1; ?>">
            Data Final: <input type="date" name="dataF2" value="<?php echo $data2; ?>">
            RG: <input type="text" name="RG" value="">
            <input type="submit" name="" value="Buscar">
           </p>
        </form>
        <button class="btn btn-success" onclick="exportTableToExcel('tblData')"><i
          class="fa fa-file-excel-o" style="color: white"></i> Exportar para o Excel</button>
        <button class="btn btn-danger" type="button" value="Criar PDF" id="btnImprimir"
        onclick="CriaPDF()"><i class="fa fa-file-pdf-o" style="color: white"></i> Gerar PDF</button>
        <br>
        <div id="tblData2">
        <table id="tblData" border="1" class="table table-danger">
          <thead>
            <td>Data</td>
            <td>Hora chegada</td>
            <td>Hora saida</td>
            <td>Nome</td>
            <td>Empresa</td>
            <td>RG</td>
            <td>Tipo Veiculo</td>
            <td>Placa</td>
            <td>Contato via</td>
            <td>Porteiro</td>
          </thead>
          <tbody>
            <?php
            if ($rg == "") {
              $sql = "SELECT * FROM pessoas WHERE data >= '$data1' AND data <= '$data2'
               AND local = '$local'";
                    $sql = $conn->query($sql) or die($conn->error);
            }else{
            $sql = "SELECT * FROM pessoas WHERE data >= '$data1' AND data <= '$data2'
             AND local = '$local' AND rg = '$rg'";
                  $sql = $conn->query($sql) or die($conn->error);
                }
            while($dado = $sql->fetch_array()){ ?>
              <tr>
                <td><?php echo date("d/m/Y", strtotime($dado['data'])); ?></td>
                <td><?php echo $dado['hora_chegada']; ?></td>
                <td><?php echo $dado['hora_saida']; ?></td>
                <td><?php echo strtoupper($dado['nome']); ?></td>
                <td><?php echo strtoupper($dado['empresa']); ?></td>
                <td><?php echo strtoupper($dado['rg']); ?></td>
                <td><?php echo strtoupper($dado['veiculo']); ?></td>
                <td><?php echo strtoupper($dado['placa']); ?></td>
                <td><?php echo strtoupper($dado['contato_via']); ?></td>
                <td><?php echo strtoupper($dado['porteiro']); ?></td>
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
