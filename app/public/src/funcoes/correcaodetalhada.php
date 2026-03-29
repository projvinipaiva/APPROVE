<?php 
    session_start();
    
    if((!isset($_SESSION['email']) || !isset($_SESSION['password']))) {
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('Location: ../index.php');
        exit;
    }
    
    $logado = $_SESSION['email'];
    $usuarioId = $_SESSION['id'];

    include_once('../autenticacao/connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve - Correção</title>
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/correcaodetalhada.css">
    <link rel="stylesheet" href="../../assets/css/navbargambiarra.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include ('../../assets/components/navbargambiarra.php'); ?>
        
        <div class="contentwrapper">
            <div class="cdetalhadawrapper">
                <h1 class="cdetalhadah1">CORREÇÃO</h1>
                <?php
                
                    if (isset($_GET['pergunta_id'])) {
                        $perguntaId = intval($_GET['pergunta_id']);
                        
                    
                        if ($conexao) {
                            $sqlCorrecao = "SELECT texto FROM correcoes WHERE pergunta_id = ?";
                            $stmtCorrecao = $conexao->prepare($sqlCorrecao);

                            if ($stmtCorrecao) {
                                $stmtCorrecao->bind_param('i', $perguntaId);
                                $stmtCorrecao->execute();
                                $stmtCorrecao->bind_result($correcaoTexto);

                            
                                if ($stmtCorrecao->fetch()) {
                                    echo "<p class='cdp'>" . nl2br(htmlspecialchars($correcaoTexto)) . "</p>";
                                } else {
                                    echo "<p >Correção não encontrada para a pergunta.</p>";
                                }

                                $stmtCorrecao->close();
                            } else {
                                echo "<p>Erro ao preparar a consulta: " . htmlspecialchars($conexao->error) . "</p>";
                            }
                        } else {
                            echo "<p>Erro de conexão com o banco de dados.</p>";
                        }
                    } else {
                        echo "<p>Identificador de pergunta não informado.</p>";
                    }
                ?>
            
            
            </div>
        </div>
    </div>
    <?php include ('../../assets/components/acbbotao.php'); ?>
    <script src="../../assets/js/acessibilidade.js"></script>
</body>
</html>
