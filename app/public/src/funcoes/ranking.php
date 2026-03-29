<?php  
    session_start();
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['password']) == true)) {
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('Location: ../index.php');
    }
    $logado = $_SESSION['email'];

    
    include_once('../autenticacao/connect.php');


    $limite = 100;

   
    $pagina = isset($_GET['pagina']) ? intval($_GET['pagina']) : 1;
    $inicio = ($pagina - 1) * $limite;

    
    $sqlTotal = "
        SELECT COUNT(DISTINCT usuarios.username) AS total_usuarios
        FROM usuarios 
        LEFT JOIN pontuacoes ON usuarios.id = pontuacoes.usuario_id";

    $resultTotal = $conexao->query($sqlTotal);
    $rowTotal = $resultTotal->fetch_assoc();
    $totalUsuarios = $rowTotal['total_usuarios'];

 
    $totalPaginas = ceil($totalUsuarios / $limite);

  
    $sqlRanking = "
        SELECT usuarios.username, SUM(pontuacoes.pontos) AS total_pontos 
        FROM usuarios 
        LEFT JOIN pontuacoes ON usuarios.id = pontuacoes.usuario_id 
        GROUP BY usuarios.username 
        ORDER BY total_pontos DESC
        LIMIT ?, ?";

    $stmtRanking = $conexao->prepare($sqlRanking);
    $stmtRanking->bind_param('ii', $inicio, $limite);
    $stmtRanking->execute();
    $resultRanking = $stmtRanking->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve - Ranking</title>
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/ranking.css">
    <link rel="stylesheet" href="../../assets/css/navbargambiarra.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <?php include ('../../assets/components/navbargambiarra.php'); ?>
    
    <div class="contentwrapper">
        <div class="rankingwrapper">
            <h1 class="rankingh1">RANKING</h1>
            <div class="classificacaoranking">
                <div class="cardsdaclassificacao">
                <div class="classificacaocard">
                    <h2 class="rankingh2">CLASSIFICAÇÃO</h2>

                    <?php
                 
                        $sqlUsuario = "SELECT SUM(pontuacoes.pontos) AS total_pontos FROM pontuacoes WHERE usuario_id = ?";
                        $stmtUsuario = $conexao->prepare($sqlUsuario);
                        $stmtUsuario->bind_param('i', $_SESSION['id']);
                        $stmtUsuario->execute();
                        $resultUsuario = $stmtUsuario->get_result();
                        $rowUsuario = $resultUsuario->fetch_assoc();
                        $totalPontosUsuario = $rowUsuario['total_pontos'] ?? 0;

                    
                        if ($totalPontosUsuario < 100) {
                            $svg_icon = "icon-bronze.svg";
                            $classificacao = "BRONZE";
                        } elseif ($totalPontosUsuario >= 100 && $totalPontosUsuario < 200) {
                            $svg_icon = "icon-prata.svg";
                            $classificacao = "PRATA";
                        } elseif ($totalPontosUsuario >= 200 && $totalPontosUsuario < 300) {
                            $svg_icon = "icon-ouro.svg";
                            $classificacao = "OURO";
                        } elseif ($totalPontosUsuario >= 300 && $totalPontosUsuario < 400) {
                            $svg_icon = "icon-platina.svg";
                            $classificacao = "PLATINA";
                        } elseif ($totalPontosUsuario >= 400 && $totalPontosUsuario < 500) {
                            $svg_icon = "icon-desafiante.svg";
                            $classificacao = "DESAFIANTE";
                        } else {
                            $svg_icon = "icon-aprovado.svg";
                            $classificacao = "APROVADO";
                        }
                        
                    ?>

                    <img src="../../assets/img/icons/<?php echo $svg_icon; ?>" alt="Ícone" class="svg-iconclass" />
                    <p class="rankingp"><?php echo $classificacao; ?></p>

                    <a href="classificacoes.php">
                        <button class="rankinga">COMO FUNCIONA?</button>
                    </a>
                </div>

                <div class="classificacaocard">   
                    <h2 class="rankingh2">TABELA</h2>
                    <div class="table-container">
                        <?php
                        if ($resultRanking->num_rows > 0) {
                            echo "<table class='rankingtable'>";
                            echo "<tr><th>POSIÇÃO</th><th>USUÁRIO</th><th>PONTOS</th></tr>";
                            
                            $posicao = $inicio + 1;
                            while ($row = $resultRanking->fetch_assoc()) {
                                $username = htmlspecialchars($row['username']);
                                $totalPontos = $row['total_pontos'] ?? 0;
                                
                                echo "<tr>";
                                echo "<td>$posicao</td>";
                                echo "<td>$username</td>";
                                echo "<td>$totalPontos</td>";
                                echo "</tr>";

                                $posicao++;
                            }
                            echo "</table>";
                        } else {
                            echo "<p class='rankingp'>Nenhum usuário encontrado.</p>";
                        }
                        ?>
                    </divs>
                   
                    
                   
                </div>
              

                </div>
        </div>
    </div>
</div>
<?php include ('../../assets/components/acbbotao.php'); ?>
<script src="../../assets/js/acessibilidade.js"></script>
</body>
</html>