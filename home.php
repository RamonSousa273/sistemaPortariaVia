<?php
session_start();
if (isset($_SESSION['llusuario'])) {
   ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script>
                    window.onload = function (){
                        window.frames['cabecalho'].location.reload();
                        window.frames['menu'].location.reload();
                    }
                </script>
  </head>
  <frameset rows="130px,*" FRAMESPACING="0">
        <frame frameborder="0" name="cabecalho" src="menu.php" />
        <frameset cols="100%,*" FRAMESPACING="0">
            <frame frameborder="0" name="menu"src="corpo.html" />
        </frameset>
    </frameset>
</html>
<?php }else{
  ?>
  <script type="text/javascript">
  alert("Não Cadastrado");
    window.location.href = "index.php";
  </script>
  <?php
} ?>
