<?php
include_once("conexao.php");
 ?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
    integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
    crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"
    rel="stylesheet">
    <link rel="stylesheet" href="css/master.css">
  </head>
  <body>
<?php
if (isset($_POST['Editar'])) {
  $id=$_POST['Editar'];
  $sql = "SELECT * FROM veiculoses WHERE id_registro = '$id'";
  $sql = $conn->query($sql) or die($conn->error);
  $dado = $sql->fetch_array();
}
 ?>
 <table class="table table-dark">
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
       <td></td>
     </tr>
   </thead>
   <tbody>
     <form class="" action="processa.php" method="post">
     <tr>
       <td> <?php echo $dado['data_saida']; ?> </td>
       <td> <?php echo $dado['data_entrada']; ?> </td>
       <td> <?php echo $dado['hora_saida']; ?> </td>
       <td> <?php echo $dado['hora_entrada']; ?> </td>
       <td> <?php echo $dado['frota']; ?> </td>
       <?php
       if ($dado['frota'] == "Via") {?>
        <td> <select class="form-control" name="motoristaSaida">
          <option class="form-control" value="<?php echo $dado['motorista_saida']; ?>"><?php echo $dado['motorista_saida']; ?></option>
          <?php
          $sql = "SELECT * FROM motoristas_via";
          $sql = $conn->query($sql) or die($conn->error);
          while ($dado2 = $sql->fetch_array()) { ?>
            <option class="form-control" value="<?php echo $dado2['nome']; ?>"><?php echo $dado2['nome']; ?></option>
          <?php
          }
           ?>
        </select> </td>
         <?php
       }else{?>
         <td> <input class="form-control" type="text" name="motoristaSaida" value="<?php echo $dado['motorista_saida']; ?>"> </td>
         <?php
       }
        ?>
        <?php
        if ($dado['frota'] == "Via") {?>
         <td> <select class="form-control" name="motoristaEntrada">
           <option class="form-control" value="<?php echo $dado['motorista_entrada']; ?>"><?php echo $dado['motorista_entrada']; ?></option>
           <?php
           $sql = "SELECT * FROM motoristas_via";
           $sql = $conn->query($sql) or die($conn->error);
           while ($dado2 = $sql->fetch_array()) { ?>
             <option class="form-control" value="<?php echo $dado2['nome']; ?>"><?php echo $dado2['nome']; ?></option>
           <?php
           }
            ?>
         </select> </td>
          <?php
        }else{?>
          <td> <input class="form-control" type="text" name="motoristaEntrada" value="<?php echo $dado['motorista_entrada']; ?>"> </td>
          <?php
        }
         ?>
         <td> <input class="form-control" type="text" name="placa" value="<?php echo $dado['placa']; ?>"> </td>
         <td> <input class="form-control" type="text" name="veiculo" value="<?php echo $dado['veiculo']; ?>"> </td>
         <td> <input class="form-control" type="text" name="km_saida" value="<?php echo $dado['km_saida']; ?>"> </td>
         <td> <input class="form-control" type="text" name="km_entrada" value="<?php echo $dado['km_entrada']; ?>"> </td>
         <td> <button class="btn btn-primary" type="submit" value="<?php echo $dado['id_registro']; ?>" name="confirmaAjuste">Confirmar</button> </td>
    </tr>
     </form>
   </tbody>
 </table>
  </body>
</html>
