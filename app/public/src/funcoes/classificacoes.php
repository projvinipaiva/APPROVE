<?php  
    session_start();
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['password']) == true)) {
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('Location: ../index.php');
    }
    $logado = $_SESSION['email'];

    
    include_once('../autenticacao/connect.php');

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Approve - Classificações</title>
        <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
        <link rel="stylesheet" href="../../assets/css/reset.css">
        <link rel="stylesheet" href="../../assets/css/classificacoes.css">
        <link rel="stylesheet" href="../../assets/css/navbargambiarra.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php include ('../../assets/components/navbargambiarra.php'); ?>

            <div class="contentwrapper">
                <div class="classificacoeswrapper">
                    <h1 class="classificacoesh1">CLASSIFICAÇÕES</h1>
                    <div class="classificacoestexto">
                        <h2>O QUE SÃO AS CLASSIFICAÇÕES?</h2>
                        <p>São insígnias que designam um nível de acordo com o seu desempenho na plataforma. </p>
                        <h2>QUAIS SÃO ELAS?</h2>
                        <div class="wrappergrid">
                            <div class="classificacoesgrid">
                                <div class="grid-item">
                                    <img class="grid-img" src="../../assets/img/icons/icon-bronze.svg" alt="">
                                    <p>BRONZE</p>
                                </div>
                                <div class="grid-item">
                                    <img class="grid-img" src="../../assets/img/icons/icon-prata.svg" alt="">
                                    <p>PRATA</p>
                                </div>
                                <div class="grid-item">
                                    <img class="grid-img" src="../../assets/img/icons/icon-ouro.svg" alt="">
                                    <p>OURO</p>
                                </div>
                                <div class="grid-item">
                                    <img class="grid-img" src="../../assets/img/icons/icon-platina.svg" alt="">
                                    <p>PLATINA</p>
                                </div>
                                <div class="grid-item">
                                    <img class="grid-img" src="../../assets/img/icons/icon-desafiante.svg" alt="">
                                    <p>DESAFIANTE</p>
                                </div>
                                <div class="grid-item">
                                    <img class="grid-img" src="../../assets/img/icons/icon-aprovado.svg" alt="">
                                    <p>APROVADO</p>
                                </div>
                            </div>
                        </div>
                        <h2>COMO FUNCIONAM?</h2>
                        <p>Conforme você responde perguntas no Approve, você ganha ou perde 5 pontos de acordo com a quantidade de erros e acertos que você obteve, a cada 100 pontos acumulados você desbloqueia uma nova insígnia.</p>
                    </div>
                </div>
            </div>
        </div>
        <?php include ('../../assets/components/acbbotao.php'); ?>    
        <script src="../../assets/js/acessibilidade.js"></script>
    </body>
    </html>