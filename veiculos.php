<?php session_start();
if (isset($_SESSION['llusuario'])) {
  $user = $_SESSION['llusuario'];
   ?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Portaria - Home</title>
    <!-- link para o bootstrap 4.5.0 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
    crossorigin="anonymous">
    <!-- Link para a font awesome -->
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    rel="stylesheet">
    <link rel="stylesheet" href="css/master.css">
  </head>
  <body>
    <?php
     if (isset($_POST['Entrada']) || isset($_SESSION['veiculoEnt'])) {
       unset( $_SESSION['veiculoEnt'] );
       ?>
        <br>
          <h3 class="VeiculoE">Entrada</h3>
          <div class="ajustaTabela">
          <div class="ajustaBotao">
            <table class="table table-primary" >
          <thead>
            <tr>
              <td>Digite a placa do Veículo</td>
            </tr>
          </thead>
          <tbody>
            <tr>
            <td> <form class="" action="" method="post">
              <input maxlength="8"  class="form-control" type="text" name="placaEntrada"
              placeholder="abc-1234" value="">
            </td>
             </tr>
             <tr>
           <td><button class="btn btn-primary btn-lg btn-block" type="submit"
             name="placaEntradabtn">Buscar</button></td>
                </form>
        </tr>
          </tbody>
        </table>
        </div>
        </div>
        <div class="PendenteEntrada">
          <br>
          <table class="table table-dark">
            <h3 class="VeiculoE">Veiculos pendentes de Entrada</h3>
            <thead>
              <tr>
                <td>Data de Saida</td>
                <td>Hora de Saida</td>
                <td>Frota</td>
                <td>KM saida</td>
                <td>Hora chegada</td>
                <td>KM Entrada</td>
                <td>Motorista entrada</td>
                <td>Placa</td>
                <td>Veiculo</td>
              </tr>
            </thead>
            <tbody>
              <?php
              include_once("conexao.php");
              $sql = "SELECT * FROM veiculoses WHERE frota = 'Via' AND data_entrada = '0000-00-00' ";
              $sql2 = $conn->query($sql) or die($conn->error);
               while($dado = $sql2->fetch_array()){
               ?>
               <form class="" action="processa.php" method="post">
                 <tr>
               <td><?php echo $dado['data_saida']; ?></td>
               <td><?php echo $dado['hora_saida']; ?></td>
               <td><?php echo $dado['frota']; ?></td>
               <td><?php echo $dado['km_saida'];  ?></td>
               <td> <input class="form-control" type="time" name="horaChegada" value=""> </td>
               <td> <input class="form-control" type="text" name="kmVoltaa" value=""> </td>
               <?php
               $sql3 = "SELECT * FROM motoristas_via";
               $sql4 = $conn->query($sql3) or die($conn->error);
                ?>
               <td> <select class="form-control" name="motorista">
                 <option value=""></option>
                 <?php while($dado2 = $sql4->fetch_array()){ ?>
                   <option value="<?php echo $dado2['nome']; ?>"><?php echo $dado2['nome']; ?></option>
                 <?php } ?>
               </select> </td>
               <td><?php echo $dado['placa']; ?></td>
               <td><?php echo $dado['veiculo']; ?></td>
               <?php if ($dado['status'] == "Manutencao"){ ?>
               <td> <button class="btn btn-danger" type="submit" name="confirmaVoltaVeiculo"
                 value="<?php echo htmlspecialchars($dado['id_registro']); ?>">Retorno de manutenção</button>

                  </td>
             <?php }elseif($dado['status'] == "Abastecimento"){ ?>
               <td> <button class="btn btn-info" type="submit" name="confirmaVoltaVeiculo"
                value="<?php echo htmlspecialchars($dado['id_registro']); ?>">Retorno de Abastecimento</button> </td>
             <?php }else{
               ?>
               <td> <button class="btn btn-primary" type="submit" name="confirmaVoltaVeiculo"
                value="<?php echo htmlspecialchars($dado['id_registro']); ?>">Retorno de rota</button> </td>
             <?php
             } ?>
               </tr>
               </form>
             <?php } ?>
            </tbody>
          </table>
        </div>
    <?php } ?>
    <?php if (isset($_POST['Saida'])) {?>
        <br>
        <h3 class="VeiculoS">Saida</h3>
        <div class="ajustaTabela">
          <div class="ajustaBoatao">
        <table class="table table-primary" >
          <thead>
            <tr>
              <td>Digite a placa do Veículo</td>
            </tr>
          </thead>
          <tbody>
            <tr>
            <td> <form  class="" action="" method="post">
              <input maxlength="8"  class="form-control" type="text" placeholder="abc-1234"
              name="PlacaSaida" value=""></td>
                </tr>
                <tr>
            <td>
              <div class="ajustaBotao">
              <button class="btn btn-primary btn-lg btn-block" type="submit"
              name="PlacaSaidabtn">Buscar</button>
              </div>
            </form>
            </td>
        </tr>
          </tbody>
        </table>
        </div>
        </div>
        <div class="PendenteSaida">
          <br>
          <table class="table table-dark">
            <thead>
              <h3 class="VeiculoS">Veículos pendentes de saída</h3>
              <tr >
                <td>Data de Entrada</td>
                <td>Hora de Entrada</td>
                <td>Frota</td>
                <td>KM Entrada</td>
                <td>KM Saída</td>
                <td>Motorista</td>
                <td>Placa</td>
                <td>Veiculo</td>
              </tr>
            </thead>
            <tbody>
              <?php
              include_once("conexao.php");
              $data = date('Y-m-d');
              $sql = "SELECT * FROM veiculoses WHERE data_saida = '0000-00-00' AND frota = 'Agregado'
               AND local='SP'";
              $sql2 = $conn->query($sql) or die($conn->error);
               while($dado = $sql2->fetch_array()){
               ?>
               <form class="" action="processa.php" method="post">
               <tr>
                 <td><?php echo htmlspecialchars(date("d/m/Y", strtotime($dado['data_entrada']))); ?></td>
                 <td><?php echo htmlspecialchars($dado['hora_entrada']); ?></td>
                 <td><?php echo htmlspecialchars($dado['frota']); ?></td>
                 <td><?php echo htmlspecialchars($dado['km_entrada']); ?></td>
                 <td id="ajustadinha"> <input class="form-control" type="text" name="kmSaida"
                   value=""> </td>
                 <td id="ajustadinha"> <input class="form-control" type="text" name=""
                   value="<?php echo $dado['motorista_entrada']; ?>"> </td>
                 <td><?php echo htmlspecialchars($dado['placa']); ?></td>
                 <td><?php echo htmlspecialchars($dado['veiculo']); ?></td>
                 <td> <button class="btn btn-primary" type="submit" name="confirmaSaidaAgregado"
                   value="<?php echo htmlspecialchars($dado['id_registro']); ?>">Confirmar</button> </td>
              </tr>
              </form>
            <?php } ?>
            </tbody>
          </table>
        </div>
    <?php } ?>
    <?php if (isset($_POST['placaEntrada'])) {
      $placa = $_POST['placaEntrada'];
      include_once("conexao.php");
      $sql = "SELECT * FROM veiculos_cadastrados WHERE placa LIKE '$placa'";
      $sql2 = $conn->query($sql);
      $dado = $sql2->fetch_array();
      if (is_array($dado)) {
      }else{
        $_SESSION['Veiculo'] = 1;
        ?>
        <script>
          alert("Veiculo não cadastrado!");
          window.location.href = "cadastro.php";
        </script>
        <?php
      }
      $sql3 = "SELECT * FROM veiculos_cadastrados WHERE placa = '$placa'";
      $sql4 = $conn->query($sql);
      $dado1 = $sql4->fetch_array();
      ?>
      <form class="" action="processa.php" method="post">
        <br>
        <table class="table table-primary" >
          <h3 class="VeiculoE">Entrada</h3>
          <thead>
            <tr>
              <td>Placa</td>
              <td>Veículo</td>
              <td>Frota</td>
              <td>Motorista</td>
              <td>Hora chegada</td>
              <td>Km</td>
              <?php if ($user['nome'] == ""): ?>
                <td>Porteiro</td>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <tr>
            <td> <input maxlength="8" class="form-control" type="text" name="placa"
              value="<?php echo htmlspecialchars($dado['placa']); ?>"></td>
            <td> <input maxlength="15" class="form-control" type="text" name="veiculo"
              value="<?php echo htmlspecialchars($dado['veiculo']); ?>"> </td>
            <td> <input maxlength="15" class="form-control" type="text" name="frota"
              value="<?php echo htmlspecialchars($dado['frota']); ?>"> </td>
            <?php if ($dado['frota'] == "Via"){ ?>
              <td> <select class="form-control" name="motorista">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM motoristas_via";
                $sql2 = $conn->query($sql);
                while ($dado = $sql2->fetch_array()) {
                 ?>
                 <option value="<?php echo $dado['nome']; ?>"><?php echo $dado['nome']; ?></option>
               <?php } ?>
              </select> </td>
            <?php }else{ ?>
            <td> <input maxlength="20" class="form-control" type="text" name="motorista"
              value="<?php echo htmlspecialchars($dado['motorista']); ?>"> </td>
            <?php } ?>
            <td> <input maxlength="10" class="form-control" type="time" name="horaChegada"></td>
            <td> <input maxlength="10" class="form-control" type="text" name="kmEntrada"
                value=""> </td>
                <?php if ($user['nome'] == ""): ?>
                  <td> <input class="form-control" type="text" name="porteiro" value=""> </td>
                <?php endif; ?>
          </tr>
          </tbody>
        </table>
        <div class="ajustaBotao">
        <button class="btn btn-primary btn-lg btn-block" type="submit"
        name="confirmaEntradaVeiculo">Registrar</button>
        </div>
      </form>
      <div class="PendenteEntrada">
        <br>
        <table class="table table-dark">
          <h3 class="VeiculoE">Veiculos pendentes de Entrada</h3>
          <thead>
            <tr>
              <td>Data de Saida</td>
              <td>Hora de Saida</td>
              <td>Frota</td>
              <td>KM saida</td>
              <td>Hora chegada</td>
              <td>KM Entrada</td>
              <td>Motorista entrada</td>
              <td>Placa</td>
              <td>Veiculo</td>
            </tr>
          </thead>
          <tbody>
            <?php
            include_once("conexao.php");
            $sql = "SELECT * FROM veiculoses WHERE frota = 'Via' AND data_entrada = '0000-00-00' ";
            $sql2 = $conn->query($sql) or die($conn->error);
             while($dado = $sql2->fetch_array()){
             ?>
             <form class="" action="processa.php" method="post">
               <tr>
             <td><?php echo $dado['data_saida']; ?></td>
             <td><?php echo $dado['hora_saida']; ?></td>
             <td><?php echo $dado['frota']; ?></td>
             <td><?php echo $dado['km_saida']; ?></td>
             <td> <input class="form-control" type="time" name="horaChegada" value=""> </td>
             <td> <input class="form-control" type="text" name="kmVoltaa" value=""> </td>
             <?php
             $sql3 = "SELECT * FROM motoristas_via";
             $sql4 = $conn->query($sql3) or die($conn->error);
              ?>
             <td> <select class="form-control" name="motorista">
               <option value=""></option>
               <?php while($dado2 = $sql4->fetch_array()){ ?>
                 <option value="<?php echo $dado2['nome']; ?>"><?php echo $dado2['nome']; ?></option>
               <?php } ?>
             </select> </td>
             <td><?php echo $dado['placa']; ?></td>
             <td><?php echo $dado['veiculo']; ?></td>
             <td> <button class="btn btn-primary" type="submit" name="confirmaVoltaVeiculo"
               value="<?php echo htmlspecialchars($dado['id_registro']); ?>">Confirmar</button> </td>
             </tr>
             </form>
           <?php } ?>
          </tbody>
        </table>
      </div>
    <?php } ?>
    <?php if (isset($_POST['PlacaSaida'])) {
      $placa = $_POST['PlacaSaida'];
      include_once("conexao.php");
      $sql = "SELECT * FROM veiculos_cadastrados WHERE placa LIKE '$placa'";
      $sql2 = $conn->query($sql);
      $dado = $sql2->fetch_array();
      if (is_array($dado)) {
      }else{
        $_SESSION['Veiculo'] = 1;
        ?>
        <script>
          alert("Veiculo não cadastrado!");
          window.location.href = "cadastro.php";
        </script>
        <?php
      }
      $sql3 = "SELECT * FROM veiculos_cadastrados WHERE placa = '$placa'";
      $sql4 = $conn->query($sql);
      $dado1 = $sql4->fetch_array();
      ?>
      <form class="" action="processa.php" method="post">
        <br>
        <table class="table table-primary" >
          <h3 class="VeiculoS">Saida</h3>
          <thead>
            <tr>
              <td>Placa</td>
              <td>Veículo</td>
              <td>Frota</td>
              <td>Motorista</td>
              <td>Km</td>
              <?php if ($user['nome'] == ""): ?>
                <td>Porteiro</td>
              <?php endif; ?>
            </tr>
          </thead>
          <tbody>
            <tr>
            <td> <input maxlength="8" class="form-control" type="text" name="placa"
              value="<?php echo htmlspecialchars($placa); ?>">  </td>
            <td> <input maxlength="15" class="form-control" type="text" name="veiculo"
              value="<?php echo htmlspecialchars($dado['veiculo']); ?>"> </td>
            <td> <input maxlength="15" class="form-control" type="text" name="frota"
              value="<?php echo htmlspecialchars($dado['frota']); ?>"> </td>
            <?php if ($dado['frota'] == "Via"){ ?>
              <td> <select class="form-control" name="motorista">
                <option value=""></option>
                <?php
                $sql = "SELECT * FROM motoristas_via";
                $sql2 = $conn->query($sql);
                while ($dado = $sql2->fetch_array()) {
                 ?>
                 <option value="<?php echo $dado['nome']; ?>"><?php echo $dado['nome']; ?></option>
               <?php } ?>
              </select> </td>
            <?php }else{ ?>
            <td> <input maxlength="20" class="form-control" type="text" name="motorista"
              value="<?php echo htmlspecialchars($dado['motorista']); ?>"> </td>
            <?php } ?>
            <td> <input maxlength="10" class="form-control" type="text" name="kmSaida"
              value=""> </td>
              <?php if ($user['nome'] == ""): ?>
                <td> <input class="form-control" type="text" name="porteiro" value=""> </td>
              <?php endif; ?>
          </tr>
          </tbody>
        </table>
        <div class="ajustaBotao">
        <button class="btn btn-primary btn-lg btn-block" type="submit"
        name="confirmaSaidaVeiculo"><i class="fa fa-truck" style="color: white"></i> Registrar</button>
        <button class="btn btn-danger btn-lg btn-block" type="submit"
        name="confirmaSaidaVeiculoManutensao"><i class="fa fa-wrench" style="color: white"></i>
         Manutenção</button>
         <button class="btn btn-info btn-lg btn-block" type="submit"
         name="confirmaSaidaVeiculoAbastecimento"><i class="fa fa-filter" style="color: white"></i>
          Abastecimento</button>
        </div>
      </form>
      <div class="PendenteSaida">
        <br>
        <table class="table table-dark">
          <thead>
            <h3 class="VeiculoS">Veículos pendentes de saída</h3>
            <tr >
              <td>Data de Entrada</td>
              <td>Hora de Entrada</td>
              <td>Frota</td>
              <td>KM Entrada</td>
              <td>KM Saída</td>
              <td>Motorista</td>
              <td>Placa</td>
              <td>Veiculo</td>
            </tr>
          </thead>
          <tbody>
            <?php
            include_once("conexao.php");
            $data = date('Y-m-d');
            $sql = "SELECT * FROM veiculoses WHERE data_saida = '0000-00-00' AND frota = 'Agregado'
             AND local='SP'";
            $sql2 = $conn->query($sql) or die($conn->error);
             while($dado = $sql2->fetch_array()){
             ?>
             <form class="" action="processa.php" method="post">
             <tr>
               <td><?php echo htmlspecialchars(date("d/m/Y", strtotime($dado['data_entrada']))); ?></td>
               <td><?php echo htmlspecialchars($dado['hora_entrada']); ?></td>
               <td><?php echo htmlspecialchars($dado['frota']); ?></td>
               <td><?php echo htmlspecialchars($dado['km_entrada']); ?></td>
               <td id="ajustadinha"> <input class="form-control" type="text" name="kmSaida"
                 value=""> </td>
               <td id="ajustadinha"> <input class="form-control" type="text" name=""
                 value="<?php echo $dado['motorista_entrada']; ?>"> </td>
               <td><?php echo htmlspecialchars($dado['placa']); ?></td>
               <td><?php echo htmlspecialchars($dado['veiculo']); ?></td>
               <td> <input class="btn btn-primary" type="submit" name="confirmaSaidaAgregado"
                  value="Confirmar"> </td>
            </tr>
            </form>
          <?php } ?>
          </tbody>
        </table>
      </div>
        <?php } ?>
      <?php if (isset($_SESSION['guardaEntrada'])) {
        $dados = $_SESSION['guardaEntrada'];
        unset( $_SESSION['guardaEntrada'] );
        include_once("conexao.php");
        ?>
        <form class="" action="processa.php" method="post">
          <br>
          <table class="table table-primary" >
            <h3 class="VeiculoE">Entrada</h3>
            <thead>
              <tr>
                <td>Placa</td>
                <td>Veículo</td>
                <td>Frota</td>
                <td>Motorista</td>
                <td>Km</td>
              </tr>
            </thead>
            <tbody>
              <tr>
              <td> <input maxlength="8" class="form-control" type="text" name="placa"
                value="<?php echo htmlspecialchars($dados['placa']); ?>"></td>
              <td> <input maxlength="15" class="form-control" type="text" name="veiculo"
                value="<?php echo htmlspecialchars($dados['veiculo']); ?>"> </td>
              <td> <input maxlength="15" class="form-control" type="text" name="frota"
                value="<?php echo htmlspecialchars($dados['frota']); ?>"> </td>
              <?php if ($dados['frota'] == "Via"){ ?>
                <td> <select class="form-control" name="motorista">
                  <option value="<?php echo $dados['motorista']; ?>"><?php echo $dados['motorista']; ?></option>
                  <?php
                  $sql = "SELECT * FROM motoristas_via";
                  $sql2 = $conn->query($sql);
                  while ($dado = $sql2->fetch_array()) {
                   ?>
                   <option value="<?php echo $dado['nome']; ?>"><?php echo $dado['nome']; ?></option>
                 <?php } ?>
                </select> </td>
              <?php }else{ ?>
              <td> <input maxlength="20" class="form-control" type="text" name="motorista"
                value="<?php echo htmlspecialchars($dados['motorista']); ?>"> </td>
              <?php } ?>
              <td> <input maxlength="10" class="form-control" type="text" name="kmEntrada"
                  value="<?php echo $dados['kmEntrada']; ?>"> </td>
            </tr>
            </tbody>
          </table>
          <div class="ajustaBotao">
          <button class="btn btn-primary btn-lg btn-block" type="submit"
          name="confirmaEntradaVeiculo">Registrar</button>
          </div>
        </form>
        <div class="PendenteEntrada">
          <br>
          <table class="table table-dark">
            <h3 class="VeiculoE">Veiculos pendentes de Entrada</h3>
            <thead>
              <tr>
                <td></td>
                <td>Data de Saida</td>
                <td>Hora de Saida</td>
                <td>Frota</td>
                <td>KM saida</td>
                <td>KM Entrada</td>
                <td>Motorista entrada</td>
                <td>Placa</td>
                <td>Veiculo</td>
              </tr>
            </thead>
            <tbody>
              <?php
              include_once("conexao.php");
              $sql = "SELECT * FROM veiculoses WHERE frota = 'Via' AND data_entrada = '0000-00-00' ";
              $sql2 = $conn->query($sql) or die($conn->error);
               while($dado = $sql2->fetch_array()){
               ?>
               <form class="" action="processa.php" method="post">
                 <tr>
               <td><input type="radio" name="id" value="<?php
               echo htmlspecialchars($dado['id_registro']); ?>"></td>
               <td><?php echo $dado['data_saida']; ?></td>
               <td><?php echo $dado['hora_saida']; ?></td>
               <td><?php echo $dado['frota']; ?></td>
               <td><?php echo $dado['km_saida']; ?></td>
               <td> <input class="form-control" type="text" name="kmVoltaa" value=""> </td>
               <?php
               $sql3 = "SELECT * FROM motoristas_via";
               $sql4 = $conn->query($sql3) or die($conn->error);
                ?>
               <td> <select class="form-control" name="motorista">
                 <option value=""></option>
                 <?php while($dado2 = $sql4->fetch_array()){ ?>
                   <option value="<?php echo $dado2['nome']; ?>"><?php echo $dado2['nome']; ?></option>
                 <?php } ?>
               </select> </td>
               <td><?php echo $dado['placa']; ?></td>
               <td><?php echo $dado['veiculo']; ?></td>
               <td> <input class="btn btn-primary" type="submit" name="confirmaVoltaVeiculo"
                 value="Confirmar"> </td>
               </tr>
               </form>
             <?php } ?>
            </tbody>
          </table>
        </div>
      <?php } ?>
      <?php if (isset($_SESSION['guardaSaida'])) {
        $dados = $_SESSION['guardaSaida'];
        unset( $_SESSION['guardaSaida'] );
        include_once("conexao.php");
        ?>
        <form class="" action="processa.php" method="post">
          <br>
          <table class="table table-primary" >
            <h3 class="VeiculoS">Saida</h3>
            <thead>
              <tr>
                <td>Placa</td>
                <td>Veículo</td>
                <td>Frota</td>
                <td>Motorista</td>
                <td>Km</td>
              </tr>
            </thead>
            <tbody>
              <tr>
              <td> <input maxlength="8" class="form-control" type="text" name="placa"
                value="<?php echo htmlspecialchars($dados['placa']); ?>">  </td>
              <td> <input maxlength="15" class="form-control" type="text" name="veiculo"
                value="<?php echo htmlspecialchars($dados['veiculo']); ?>"> </td>
              <td> <input maxlength="15" class="form-control" type="text" name="frota"
                value="<?php echo htmlspecialchars($dados['frota']); ?>"> </td>
              <?php if ($dados['frota'] == "Via"){ ?>
                <td> <select class="form-control" name="motorista">
                  <option value="<?php echo $dados['motorista']; ?>"><?php echo $dados['motorista']; ?></option>
                  <?php
                  $sql = "SELECT * FROM motoristas_via";
                  $sql2 = $conn->query($sql);
                  while ($dado = $sql2->fetch_array()) {
                   ?>
                   <option value="<?php echo $dado['nome']; ?>"><?php echo $dado['nome']; ?></option>
                 <?php } ?>
                </select> </td>
              <?php }else{ ?>
              <td> <input maxlength="20" class="form-control" type="text" name="motorista"
                value="<?php echo htmlspecialchars( $dados['motorista'] ); ?>"> </td>
              <?php } ?>
              <td> <input maxlength="10" class="form-control" type="text" name="kmSaida"
                value="<?php echo $dados['km']; ?>"> </td>
            </tr>
            </tbody>
          </table>
          <div class="ajustaBotao">
          <button class="btn btn-primary btn-lg btn-block" type="submit"
          name="confirmaSaidaVeiculo"><i class="fa fa-truck" style="color: white"></i> Registrar</button>
          <button class="btn btn-danger btn-lg btn-block" type="submit"
          name="confirmaSaidaVeiculoManutensao"><i class="fa fa-wrench" style="color: white">
          </i> Manutenção</button>
          </div>
        </form>
        <div class="PendenteSaida">
          <br>
          <table class="table table-dark">
            <thead>
              <h3 class="VeiculoS">Veículos pendentes de saída</h3>
              <tr >
                <td></td>
                <td>Data de Entrada</td>
                <td>Hora de Entrada</td>
                <td>Frota</td>
                <td>KM Entrada</td>
                <td>KM Saída</td>
                <td>Motorista</td>
                <td>Placa</td>
                <td>Veiculo</td>
              </tr>
            </thead>
            <tbody>
              <?php
              include_once("conexao.php");
              $data = date('Y-m-d');
              $sql = "SELECT * FROM veiculoses WHERE data_saida = '0000-00-00' AND frota = 'Agregado'
              AND local='SP'";
              $sql2 = $conn->query($sql) or die($conn->error);
               while($dado = $sql2->fetch_array()){
               ?>
               <form class="" action="processa.php" method="post">
               <tr>
                 <td> <input type="radio" name="id"
                   value="<?php echo htmlspecialchars($dado['id_registro']); ?>"> </td>
                 <td><?php echo htmlspecialchars(date("d/m/Y", strtotime($dado['data_entrada']))); ?></td>
                 <td><?php echo htmlspecialchars($dado['hora_entrada']); ?></td>
                 <td><?php echo htmlspecialchars($dado['frota']); ?></td>
                 <td><?php echo htmlspecialchars($dado['km_entrada']); ?></td>
                 <td id="ajustadinha"> <input class="form-control" type="text" name="kmSaida"
                   value=""> </td>
                 <td id="ajustadinha"> <input class="form-control" type="text" name=""
                   value="<?php echo $dado['motorista_entrada']; ?>"> </td>
                 <td><?php echo htmlspecialchars($dado['placa']); ?></td>
                 <td><?php echo htmlspecialchars($dado['veiculo']); ?></td>
                 <td> <input class="btn btn-primary" type="submit" name="confirmaSaidaAgregado"
                    value="Confirmar"> </td>
              </tr>
              </form>
            <?php } ?>
            </tbody>
          </table>
        </div>
          <?php } ?>
  </body>
</html>
<?php }else{
  ?>
  <script type="text/javascript">
    window.location.href = "index.php";
  </script>
  <?php
} ?>
