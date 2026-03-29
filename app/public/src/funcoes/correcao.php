<?php
    session_start();

    if (!isset($_SESSION['email']) || !isset($_SESSION['password']) || !isset($_SESSION['id'])) {
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        unset($_SESSION['username']);
        unset($_SESSION['id']);
        header('Location: ../index.php');
        exit;
    }

    $logado = $_SESSION['email'];
    $usuarioId = $_SESSION['id'];

    include_once('../autenticacao/connect.php');

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve - Respostas</title>
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/correcao.css">
    <link rel="stylesheet" href="../../assets/css/navbargambiarra.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    
</head>
<body>
    <div class="container">
        <?php include ('../../assets/components/navbargambiarra.php'); ?>
        
        <div class="contentwrapper">
            <div class="correcaowrapper">
                <h1 class="correcaoh1">RESPOSTAS</h1>

                <?php
                
                    $questionarioId = null;

                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['questionario_id'])) {
                        $questionarioId = intval($_POST['questionario_id']);
                    } elseif (isset($_GET['questionario_id'])) {
                        $questionarioId = intval($_GET['questionario_id']);
                    }

                    if ($questionarioId === null) {
                        echo "ID do questionário não informado!";
                        exit;
                    }

                    $sqlVerificar = "SELECT COUNT(*) AS total FROM respostas_questionarios WHERE usuario_id = ? AND questionario_id = ?";
                    $stmtVerificar = $conexao->prepare($sqlVerificar);
                    $stmtVerificar->bind_param('ii', $usuarioId, $questionarioId);
                    $stmtVerificar->execute();
                    $resultVerificar = $stmtVerificar->get_result();
                    $rowVerificar = $resultVerificar->fetch_assoc();

                    $jaRespondido = $rowVerificar['total'] > 0; 
                    $stmtVerificar->close();


                    $pontos = 0;
                    $acertos = 0;
                    $erros = 0;

                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $correcoes = [];
                        $sqlPerguntas = "SELECT pergunta_id, enunciado FROM perguntas WHERE questionario_id = ?";
                        $stmtPerguntas = $conexao->prepare($sqlPerguntas);
                        $stmtPerguntas->bind_param('i', $questionarioId);
                        $stmtPerguntas->execute();
                        $resultPerguntas = $stmtPerguntas->get_result();

                        while ($pergunta = $resultPerguntas->fetch_assoc()) {
                            $perguntaId = $pergunta['pergunta_id'];
                            $enunciado = $pergunta['enunciado'];
                            $respostaUsuario = isset($_POST['pergunta_' . $perguntaId]) ? intval($_POST['pergunta_' . $perguntaId]) : 0;

                            $sqlAlternativaCorreta = "SELECT alternativa_id, texto, correta FROM alternativas WHERE pergunta_id = ? AND correta = 1";
                            $stmtAlternativaCorreta = $conexao->prepare($sqlAlternativaCorreta);
                            $stmtAlternativaCorreta->bind_param('i', $perguntaId);
                            $stmtAlternativaCorreta->execute();
                            $resultAlternativaCorreta = $stmtAlternativaCorreta->get_result();
                            $alternativaCorreta = $resultAlternativaCorreta->fetch_assoc();
                            $stmtAlternativaCorreta->close();

                            $sqlAlternativaUsuario = "SELECT texto FROM alternativas WHERE alternativa_id = ?";
                            $stmtAlternativaUsuario = $conexao->prepare($sqlAlternativaUsuario);
                            $stmtAlternativaUsuario->bind_param('i', $respostaUsuario);
                            $stmtAlternativaUsuario->execute();
                            $stmtAlternativaUsuario->bind_result($respostaUsuarioTexto);
                            $stmtAlternativaUsuario->fetch();
                            $stmtAlternativaUsuario->close();

                            if ($respostaUsuario == $alternativaCorreta['alternativa_id']) {
                                $acertos++;
                                $pontos += 5;
                                $resultado = "Correto";
                            } else {
                                $erros++;
                                $pontos -= 5;
                                $resultado = "Errado";
                            }

                            $correta = ($resultado === "Correto") ? 1 : 0;
                            $sqlResposta = "INSERT INTO respostas_usuarios (usuario_id, pergunta_id, alternativa_id, correta) VALUES (?, ?, ?, ?)";
                            $stmtResposta = $conexao->prepare($sqlResposta);
                            $stmtResposta->bind_param('iiii', $usuarioId, $perguntaId, $respostaUsuario, $correta);
                            $stmtResposta->execute();
                            $stmtResposta->close();

                            $correcoes[] = [
                                'pergunta_id' => $perguntaId,
                                'enunciado' => $enunciado,
                                'resposta_usuario' => $respostaUsuarioTexto,
                                'resultado' => $resultado,
                                'correta' => $alternativaCorreta['texto']
                            ];
                        }
                        $stmtPerguntas->close();

                        $sqlPontuacao = "SELECT pontos FROM pontuacoes WHERE usuario_id = ?";
                        $stmtPontuacao = $conexao->prepare($sqlPontuacao);
                        $stmtPontuacao->bind_param('i', $usuarioId);
                        $stmtPontuacao->execute();
                        $resultPontuacao = $stmtPontuacao->get_result();

                        if ($resultPontuacao->num_rows > 0) {
                            $pontuacaoAtual = $resultPontuacao->fetch_assoc()['pontos'];
                            $pontosNovos = max(0, $pontuacaoAtual + $pontos);

                            $sqlUpdate = "UPDATE pontuacoes SET pontos = ? WHERE usuario_id = ?";
                            $stmtUpdate = $conexao->prepare($sqlUpdate);
                            $stmtUpdate->bind_param('ii', $pontosNovos, $usuarioId);
                            $stmtUpdate->execute();
                            $stmtUpdate->close();
                        } else {
                            $pontos = max(0, $pontos);
                            $sqlInsert = "INSERT INTO pontuacoes (usuario_id, pontos) VALUES (?, ?)";
                            $stmtInsert = $conexao->prepare($sqlInsert);
                            $stmtInsert->bind_param('ii', $usuarioId, $pontos);
                            $stmtInsert->execute();
                            $stmtInsert->close();
                        }

                        $sqlRegistro = "INSERT INTO respostas_questionarios (usuario_id, questionario_id) VALUES (?, ?)";
                        $stmtRegistro = $conexao->prepare($sqlRegistro);
                        $stmtRegistro->bind_param('ii', $usuarioId, $questionarioId);
                        $stmtRegistro->execute();
                        $stmtRegistro->close();
                    } elseif ($jaRespondido) {
                        $correcoes = [];
                    
                        $sqlRespostas = "SELECT DISTINCT pergunta_id, alternativa_id 
                                        FROM respostas_usuarios 
                                        WHERE usuario_id = ? AND pergunta_id IN 
                                        (SELECT pergunta_id FROM perguntas WHERE questionario_id = ?)";
                        $stmtRespostas = $conexao->prepare($sqlRespostas);
                        $stmtRespostas->bind_param('ii', $usuarioId, $questionarioId);
                        $stmtRespostas->execute();
                        $resultRespostas = $stmtRespostas->get_result();
                        
                        while ($resposta = $resultRespostas->fetch_assoc()) {
                            $perguntaId = $resposta['pergunta_id'];
                            $alternativaId = $resposta['alternativa_id'];
                            
                            $sqlPergunta = "SELECT enunciado FROM perguntas WHERE pergunta_id = ?";
                            $stmtPergunta = $conexao->prepare($sqlPergunta);
                            $stmtPergunta->bind_param('i', $perguntaId);
                            $stmtPergunta->execute();
                            $stmtPergunta->bind_result($enunciado);
                            $stmtPergunta->fetch();
                            $stmtPergunta->close();
                            
                            $sqlAlternativa = "SELECT texto FROM alternativas WHERE alternativa_id = ?";
                            $stmtAlternativa = $conexao->prepare($sqlAlternativa);
                            $stmtAlternativa->bind_param('i', $alternativaId);
                            $stmtAlternativa->execute();
                            $stmtAlternativa->bind_result($respostaUsuarioTexto);
                            $stmtAlternativa->fetch();
                            $stmtAlternativa->close();
                            
                            $sqlAlternativaCorreta = "SELECT texto FROM alternativas WHERE pergunta_id = ? AND correta = 1";
                            $stmtAlternativaCorreta = $conexao->prepare($sqlAlternativaCorreta);
                            $stmtAlternativaCorreta->bind_param('i', $perguntaId);
                            $stmtAlternativaCorreta->execute();
                            $stmtAlternativaCorreta->bind_result($respostaCorretaTexto);
                            $stmtAlternativaCorreta->fetch();
                            $stmtAlternativaCorreta->close();
                    
                            $correcoes[] = [
                                'pergunta_id' => $perguntaId,
                                'enunciado' => $enunciado,
                                'resposta_usuario' => $respostaUsuarioTexto,
                                'resultado' => "Respondido",
                                'correta' => $respostaCorretaTexto 
                            ];
                        }
                        $stmtRespostas->close();
                    }

                                foreach ($correcoes as $correcao) {
                                    echo "<p class='correcaop'><strong>Pergunta:</strong> " . htmlspecialchars($correcao['enunciado']) . "</p>";
                                    echo "<p class='correcaop'><strong>Sua resposta:</strong> " . htmlspecialchars($correcao['resposta_usuario']) . " - " . htmlspecialchars($correcao['resultado']) . "</p>";
                                    echo "<p  class='correcaopcorreta'><strong>Resposta correta:</strong> " . htmlspecialchars($correcao['correta']) . "</p>";
                                
                                    echo '<a href="correcaodetalhada.php?pergunta_id=' . urlencode($correcao['pergunta_id']) . '" class="correcaobtn" target="_blank">Correção</a>';

                                    echo "<hr>";
                                }

                            
                                $sqlPontuacao = "SELECT pontos FROM pontuacoes WHERE usuario_id = ?";
                                $stmtPontuacao = $conexao->prepare($sqlPontuacao);
                                $stmtPontuacao->bind_param('i', $usuarioId);
                                $stmtPontuacao->execute();
                                $resultPontuacao = $stmtPontuacao->get_result();

                                if ($resultPontuacao->num_rows > 0) {
                                    $pontuacaoAtual = $resultPontuacao->fetch_assoc()['pontos'];
                                    $pontosNovos = max(0, $pontuacaoAtual + $pontos);

                                    $sqlUpdate = "UPDATE pontuacoes SET pontos = ? WHERE usuario_id = ?";
                                    $stmtUpdate = $conexao->prepare($sqlUpdate);
                                    $stmtUpdate->bind_param('ii', $pontosNovos, $usuarioId);
                                    $stmtUpdate->execute();
                                    $stmtUpdate->close();
                                } else {
                                    $pontos = max(0, $pontos);
                                    $sqlInsert = "INSERT INTO pontuacoes (usuario_id, pontos) VALUES (?, ?)";
                                    $stmtInsert = $conexao->prepare($sqlInsert);
                                    $stmtInsert->bind_param('ii', $usuarioId, $pontos);
                                    $stmtInsert->execute();
                                    $stmtInsert->close();
                                }

                        
                                if (!$jaRespondido) {
                                    $sqlRegistro = "INSERT INTO respostas_questionarios (usuario_id, questionario_id) VALUES (?, ?)";
                                    $stmtRegistro = $conexao->prepare($sqlRegistro);
                                    $stmtRegistro->bind_param('ii', $usuarioId, $questionarioId);
                                    $stmtRegistro->execute();
                                    $stmtRegistro->close();
                                }
                ?>

            </div>
        </div>
    </div>
    <?php include ('../../assets/components/acbbotao.php'); ?>
    <script src="../../assets/js/acessibilidade.js"></script>
</body>
</html>