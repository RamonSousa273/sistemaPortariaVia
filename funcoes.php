<?php
function menu($quantia,$quantia2){
  if ($quantia==0) {
    $quantia = "";
  }
$menu = "
<div class=\"divTable\">
<table class=\"table\">
  <tr>
    <td colspan=\"2\" class=\"bg-primary\"> <i class=\"fa fa-car\"> Controle Veiculos (ANEXO 1)</i> </td>
    <td colspan=\"2\" class=\"bg-dark\"> <i id=\"teste\" class=\"fa fa-user\"> Controle Pessoas (ANEXO 2) </i>
     </td>
    <td colspan=\"2\" class=\"bg-danger\"> <i class=\"fa fa-book\"> Relatório</i>  </td>
    <td colspan=\"2\"  class=\"bg-warning\"> <i class=\"fa fa-user-plus\"></i> Cadastrar </td>
  </tr>
  <tr>
  <td class=\"VeiculoE\"><form class=\"\" action=\"veiculos.php\" method=\"post\">
    <button class=\"btn btn-secondary\" type=\"submit\" name=\"Entrada\">Entrada </button>
  </form></td>
  <td class=\"VeiculoS\"><form class=\"\" action=\"veiculos.php\" method=\"post\">
    <button class=\"btn btn-success\" type=\"submit\" name=\"Saida\">Saida</button>
  </form></td>
  <td class=\"VeiculoE\"><form class=\"\" action=\"pessoas.php\" method=\"post\">
    <button class=\"btn btn-secondary\" type=\"submit\" name=\"Entrada\">Entrada</button>
  </form></td>
  <td class=\"VeiculoS\"><form class=\"\" action=\"pessoas.php\" method=\"post\">
    <button class=\"btn btn-success\" type=\"submit\" name=\"Saida\">Saida
    <span class=\"badge badge-danger\">$quantia</span></button>
  </form></td>
  <td class=\"VeiculoE\"><form class=\"\" action=\"relatorio.php\" method=\"post\">
    <button class=\"btn btn-secondary\" type=\"submit\" name=\"Veiculos\">Veiculos</button>
  </form></td>
  <td class=\"VeiculoS\"><form class=\"\" action=\"relatorio.php\" method=\"post\">
    <button class=\"btn btn-success\" type=\"submit\" name=\"Pessoas\">Pessoas</button>
  </form></td>
  <td class=\"VeiculoE\"><form class=\"\" action=\"cadastro.php\" method=\"post\">
    <button class=\"btn btn-secondary\" type=\"submit\" name=\"Veiculo\">Veiculo</button>
  </form></td>
  <td id=\"botaoPessoas\" class=\"VeiculoS\"><form class=\"\" action=\"cadastro.php\" method=\"post\">
    <button class=\"btn btn-success\" type=\"submit\" name=\"Pessoa\">Pessoa</button>
  </form></td>
  </tr>
</table></div>";
return $menu;
}
 ?>
