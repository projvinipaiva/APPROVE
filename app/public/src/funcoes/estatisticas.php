<?php
    session_start();

    if ((!isset($_SESSION['email']) == true) && (!isset($_SESSION['password']) == true)) {
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('Location: ../index.php');
    }
    $logado = $_SESSION['email'];
    $usuarioId = $_SESSION['id'];

    include_once('../autenticacao/connect.php');

    $coresMaterias = [
        'Geral' => 'black',
        'Português' => '#6c57fc', 
        'Matemática' => '#FFDF00', 
        'Biologia' => '#00A86B',   
        'Química' => '#CA2C92',    
        'Física' => '#79DBDC ',     
        'História' => '#653131',   
        'Geografia' => '#FF6D2D',  
        'Filosofia' => '#A0616A',  
        'Sociologia' => '#CCCCCC',
        'Inglês' => '#C34122',     
        'Espanhol' => '#C34122'    
    ];

    if (isset($_POST['materia'])) {
        $materiaSelecionada = $_POST['materia'];

        if ($materiaSelecionada == 'Geral') {
            
            $sqlEstatisticasMateria = "SELECT COUNT(*) as totalPerguntasMateria
                                    FROM perguntas p
                                    JOIN questionarios q ON p.questionario_id = q.questionario_id
                                    JOIN subconteudos s ON q.subconteudo_id = s.subconteudo_id
                                    JOIN materias m ON s.materia_id = m.id";
            $stmtEstatisticasMateria = $conexao->prepare($sqlEstatisticasMateria);
            $stmtEstatisticasMateria->execute();
            $resultTotalPerguntasMateria = $stmtEstatisticasMateria->get_result()->fetch_assoc();

            $totalPerguntasMateria = $resultTotalPerguntasMateria['totalPerguntasMateria'];

        
            $sqlEstatisticasRespondidas = "SELECT COUNT(*) as totalRespondidas, SUM(r.correta) as acertos 
                                        FROM respostas_usuarios r
                                        JOIN perguntas p ON r.pergunta_id = p.pergunta_id
                                        JOIN questionarios q ON p.questionario_id = q.questionario_id
                                        JOIN subconteudos s ON q.subconteudo_id = s.subconteudo_id
                                        JOIN materias m ON s.materia_id = m.id
                                        WHERE r.usuario_id = ?";
            $stmtEstatisticasRespondidas = $conexao->prepare($sqlEstatisticasRespondidas);
            $stmtEstatisticasRespondidas->bind_param('i', $usuarioId);
            $stmtEstatisticasRespondidas->execute();
            $resultRespondidas = $stmtEstatisticasRespondidas->get_result()->fetch_assoc();

            $totalRespondidas = $resultRespondidas['totalRespondidas'];
            $acertos = $resultRespondidas['acertos'];

        
            $percentualAcertos = ($totalRespondidas > 0) ? ($acertos / $totalRespondidas) * 100 : 0;
            $percentualPerguntasRespondidas = ($totalPerguntasMateria > 0) ? ($totalRespondidas / $totalPerguntasMateria) * 100 : 0;

            $corTexto = $coresMaterias['Geral'];
        } else {
         
            $sqlEstatisticasMateria = "SELECT COUNT(*) as totalPerguntasMateria 
                                    FROM perguntas p
                                    JOIN questionarios q ON p.questionario_id = q.questionario_id
                                    JOIN subconteudos s ON q.subconteudo_id = s.subconteudo_id
                                    JOIN materias m ON s.materia_id = m.id
                                    WHERE m.nome = ?";
            $stmtEstatisticasMateria = $conexao->prepare($sqlEstatisticasMateria);
            $stmtEstatisticasMateria->bind_param('s', $materiaSelecionada);
            $stmtEstatisticasMateria->execute();
            $resultTotalPerguntasMateria = $stmtEstatisticasMateria->get_result()->fetch_assoc();

            $totalPerguntasMateria = $resultTotalPerguntasMateria['totalPerguntasMateria'];

          
            $sqlEstatisticasRespondidas = "SELECT COUNT(*) as totalRespondidas, SUM(r.correta) as acertos 
                                        FROM respostas_usuarios r
                                        JOIN perguntas p ON r.pergunta_id = p.pergunta_id
                                        JOIN questionarios q ON p.questionario_id = q.questionario_id
                                        JOIN subconteudos s ON q.subconteudo_id = s.subconteudo_id
                                        JOIN materias m ON s.materia_id = m.id
                                        WHERE r.usuario_id = ? AND m.nome = ?";
            $stmtEstatisticasRespondidas = $conexao->prepare($sqlEstatisticasRespondidas);
            $stmtEstatisticasRespondidas->bind_param('is', $usuarioId, $materiaSelecionada);
            $stmtEstatisticasRespondidas->execute();
            $resultRespondidas = $stmtEstatisticasRespondidas->get_result()->fetch_assoc();

            $totalRespondidas = $resultRespondidas['totalRespondidas'];
            $acertos = $resultRespondidas['acertos'];

            
            $percentualAcertos = ($totalRespondidas > 0) ? ($acertos / $totalRespondidas) * 100 : 0;
            $percentualPerguntasRespondidas = ($totalPerguntasMateria > 0) ? ($totalRespondidas / $totalPerguntasMateria) * 100 : 0;

          
            $corTexto = isset($coresMaterias[$materiaSelecionada]) ? $coresMaterias[$materiaSelecionada] : 'black';
        }
    } else {
        $percentualAcertos = 0;
        $percentualPerguntasRespondidas = 0;
        $corTexto = 'black'; 
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve - Estatísticas</title>
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/estatisticas.css">
    <link rel="stylesheet" href="../../assets/css/navbargambiarra.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include ('../../assets/components/navbargambiarra.php'); ?>

        <div class="contentwrapper">
            <div class="estatisticaswrapper">
                <h1 class="estatisticash1">ESTATÍSTICAS</h1>

                <div class="MateriaWrapper">
                    <form method="POST" action="">
                        <label class="materiaLabel" for="materias">Escolha uma matéria:</label>
                        <select name="materia" id="materias" onchange="this.form.submit()">
                            <option value="Geral" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'Geral') echo 'selected'; ?>>Geral</option>
                            <option value="Português" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'Português') echo 'selected'; ?>>Português</option>
                            <option value="Matemática" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'Matemática') echo 'selected'; ?>>Matemática</option>
                            <option value="Biologia" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'Biologia') echo 'selected'; ?>>Biologia</option>
                            <option value="Química" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'Química') echo 'selected'; ?>>Química</option>
                            <option value="Física" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'Física') echo 'selected'; ?>>Física</option>
                            <option value="História" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'História') echo 'selected'; ?>>História</option>
                            <option value="Geografia" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'Geografia') echo 'selected'; ?>>Geografia</option>
                            <option value="Filosofia" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'Filosofia') echo 'selected'; ?>>Filosofia</option>
                            <option value="Sociologia" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'Sociologia') echo 'selected'; ?>>Sociologia</option>
                            <option value="Inglês" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'Inglês') echo 'selected'; ?>>Inglês</option>
                            <option value="Espanhol" <?php if (isset($materiaSelecionada) && $materiaSelecionada == 'Espanhol') echo 'selected'; ?>>Espanhol</option>
                        </select>
                    </form>
                </div>

                <div class="graficoWrapper">
                    <div class="grafico">
                        <h1 class="estatisticash2">Taxa de acertos</h1>
                        <p style="color: <?php echo $corTexto; ?>;"><?php echo number_format($percentualAcertos, 2); ?>%</p>
                    </div>
                    <div class="grafico">
                        <h1 class="estatisticash2">Perguntas respondidas</h1>
                        <p style="color: <?php echo $corTexto; ?>;"><?php echo number_format($percentualPerguntasRespondidas, 2); ?>%</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include ('../../assets/components/acbbotao.php'); ?>
    <script src="../../assets/js/acessibilidade.js"></script>
</body>
</html>
