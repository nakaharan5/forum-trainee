<?php
include_once 'conector.php';
session_start();
if (empty($_SESSION['intruso'])) {
    print "<script>location.href= 'index.php';</script>";
}
$_SESSION["PagOrig"] = "Perfil";
date_default_timezone_set('America/Sao_Paulo');
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <style>
        .btn-primary:hover {
            background-color: #6CC216;
            border-color: transparent;

        }

        .btn-primary {
            background-color: #8BDE38;
            width: 500px;
            border-color: transparent;
        }
    </style>
    <link rel="stylesheet" href="./Home.css">
</head>

<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script>
        setInterval(function() {
            $.post("processavis.php", {
                contar: '',
            }, function(data) {
                $('#online').text(data);
            })
        }, 5000);
    </script>

    <div class="background-image"></div> <!--Background-->

    <nav class="container">
        <div class="logo">
            <img src="./imagens/LOGO.png" alt="">
        </div>
        <div class="usuario" onclick="abrirMenu()">
            <img src="./imagens/usuario-p.png" alt="">
            <div id="menu" class="menuUser">
                <?php
                if (!empty($_SESSION['adm'])) {
                ?>
                    <a style="color:#FFFFFF" href="Adm.php">Adm</a>
                    <a style="color:#FFFFFF" href="dados.php">Dados</a>
                <?php
                }
                ?>
                <a style="color:#FFFFFF" href="Home.php">Feed</a>
                <a style="color:#FFFFFF" href="logout.php">Sair</a>
            </div>
        </div>
        </div>
    </nav>

    <script>
        function abrirMenu() {
            const menu = document.getElementById("menu")
            let aberto = window.getComputedStyle(menu).getPropertyValue("display")
            if (aberto == "none") {
                menu.style.display = "flex"

            } else {
                menu.style.display = "none"
            }
        }
    </script>

    <div class="introducao">
        <input type="file" class="foto-perfil" name="fotoPerfil" id="fotoPerfil" accept="image/*" style="display: none;">
        <label for="fotoPerfil" ><img src="./imagens/usuario.png" alt="Foto de Perfil"></label>
        <!img class="pata" src="./imagens/usuario.png">
        <h1>Suas Publicações</h1>
    </div>


    <div id="addPubli" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo"> <!-- Div de adicionar algo  // iago -->
        <img id="mais" src="./imagens/maism.png">
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">PUBLICAÇÃO</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span> <!--&times=CLose-->
          </button>
        </div>
        <div class="modal-body">
          <form id="modalForm" method="post" action="publicacao.php">
            <div class="form-group">
              <input name="titulo" type="text" class="form-control" id="recipient-name" placeholder="Digite o título" autocomplete="off" maxlength="40">
            </div>
            <div class="form-group">
              <textarea name="texto" class="form-control resize" id="message-text" placeholder="O que você está pensando?" maxlength="150" rows="3"></textarea>
            </div>
            <input type="hidden" name="data_hora" value="<?php echo date('Y-m-d H:i:s'); ?>">
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">ENVIAR</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

    <?php
    $id_usPubli = $_SESSION['id'];
    $sql = "SELECT * FROM publi WHERE id_usPubli = '$id_usPubli' ORDER BY hora DESC";
    $procura = mysqli_query($conn, $sql);

    $linhas = mysqli_fetch_all($procura);

    foreach ($linhas as $linha) {

        //echo "<div>" . $linha["0"] . $linha["1"] . $linha["2"] ."/<div>";
    ?>
        <div id="addPublis">
        <form method="post" action="deletar.php">
                <input name="idP" type="hidden" value="<?php echo $linha[3]; ?>">
                <input type="submit" class="input-with-image" value=" ">
            </form>
            <!-- linha [0] é o titulo no banco de dados -->
            <p><?php echo $linha["0"] ?></p>
            <!-- linha [1] é o texto no banco de dados -->
            <p><?php echo $linha["1"] ?></p>
            <!-- linha [2] é o hora no banco de dados -->
            <p><?php echo date('d-m-Y', strtotime($linha["2"])) ?></p>
        </div>
    <?php
    }
    ?>

</body>

</html>