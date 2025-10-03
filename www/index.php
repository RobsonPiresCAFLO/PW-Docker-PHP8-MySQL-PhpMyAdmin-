<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/estilo.css" rel="stylesheet" media="screen">
    <title>Servidor Web local</title>
    <style type="text/css">
    #logo { width: 100%; text-align: center   }
    hr {    color: gray;   }
    .center { text-align: center;   }
    .image {  max-width: 100%;      }    
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <h1 class="display-1 center">Server Running</h1>
                <hr>
            </div>
            <div class="col center">
                <img src="img/8yx98C.gif">
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col">
                <img src="img/Docker-Logo.png" class="image">
            </div>
            <div class="col center">
                <img src="img/apache3.png " id="logo">
            </div>
            <div class="col center">
                <img src="img/php-logo.png" id="logo">
            </div>
            <div class="col center">
                <img src="img/maria_db.png" id="logo">
            </div>
        </div>

        <div class="row">
            <div class="col center">
                <!-- <img src="img/logos2.jpg" class="image"> -->
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <a href="localhost:8080" class="btn btn-danger btn-lg btn-block" title="Usuario: alunos Senha: alunos">PHPMyAdmin</a>
            </div>
            <div class="col">
                <a href="info.php" class="btn btn-primary btn-lg btn-block" title="Usuario: root Senha: 1fp1caflo">Info PHP</a>
            </div>
            <div class="col">
                <a href="https://www.php.net/manual/pt_BR/index.php" class="btn btn-info btn-lg btn-block">Manual do PHP</a>
            </div>
            <div class="col">
                <a href="https://www.php.net/downloads.php" class="btn btn-success btn-lg btn-block">Download</a>
            </div>
            <div class="col">
                <a href="https://museum.php.net/" class="btn btn-secondary btn-lg btn-block">PHP Museum</a>
            </div>
            <div class="col">
                <a href="lista.php" class="btn btn-warning btn-lg btn-block">Projetos</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <br>
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Atenção!</h4>
                    <p>Ao acessar localhost pelo navegador, o servidor irá carregar os projetos hospedados a partir da
                        pasta: <br><b><?=$_SERVER['DOCUMENT_ROOT'];?></b> no seu computador. Portanto recomenda-se criar
                        uma pasta para cada projeto com seus respectivos arquivos. Arquivo com nome "index.php" ou
                        "index.html" será carregado automaticamente.</p>
                    <hr>
                    <p class="mb-0">Ex: "projeto"<br>No computador crie uma pasta em:
                        <?=$_SERVER['DOCUMENT_ROOT'];?><b>/projeto</b> e você acessará pelo navegador como
                        <b>localhost/projeto</b>.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col center">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-3">
                <img src="img/Logo-IFPI-Floriano-Horizontal.png" alt="logoIFPI" id="logo">
            </div>
            <div class="col-sm-9 center">
                <p class="titulo"><b>EasyPHP</b>: Apache HTTP Server - PHP - MariaDB - Software Livre</p>
                <p>
                <?php
                    $date = new DateTime();
                    echo "Data e Horário atual: " . $date->format('d/m/Y H:i:s') ;
                    echo " Time zone em uso: " . $date->getTimezone()->getName();
                    echo " Versão do PHP: " . phpversion();
                ?>
                </p>
                <p class="titulo">Programação para Web Backend - <?=date('Y')?></p>
            </div>
        </div>

    </div> <!-- fim do container -->

    <script src="assets/js/bootstrap.min.js"
        integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous">
    </script>
    <script src="assets/js/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="assets/js/popper.min.js"
        integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous">
    </script>

</body>

</html>