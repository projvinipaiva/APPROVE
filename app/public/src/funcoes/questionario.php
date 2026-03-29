<?php
    session_start();
   // print_r($_SESSION); 
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['password']) == true ))
    {
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
    <title>Approve - Questões</title>
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/questionario.css">
    <link rel="stylesheet" href="../../assets/css/navbargambiarra.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        
            <?php include ('../../assets/components/navbargambiarra.php'); ?>

            <div class="contentwrapper">
                <div class="questionariowrapper">
                    <?php
            
                        $subconteudoId = intval($_GET['subconteudo_id']);

                    
                        $sql = "SELECT questionario_id FROM questionarios WHERE subconteudo_id = ?";
                        $stmt = $conexao->prepare($sql);
                        $stmt->bind_param('i', $subconteudoId);
                        $stmt->execute();
                        $questionario = $stmt->get_result()->fetch_assoc();

                        if ($questionario) {
                            $questionarioId = $questionario['questionario_id'];
                            
                            $sqlVerificar = "SELECT 1 FROM respostas_questionarios WHERE usuario_id = ? AND questionario_id = ?";
                            $stmtVerificar = $conexao->prepare($sqlVerificar);
                            $stmtVerificar->bind_param('ii', $usuarioId, $questionarioId);
                            $stmtVerificar->execute();
                            $jaRespondido = $stmtVerificar->get_result()->num_rows > 0;
                        
                            if ($jaRespondido) {
                                echo "Você já respondeu a este questionário.";
                                exit;
                            }

                            $sqlPerguntas = "SELECT pergunta_id, enunciado FROM perguntas WHERE questionario_id = ?";
                            $stmtPerguntas = $conexao->prepare($sqlPerguntas);
                            $stmtPerguntas->bind_param('i', $questionarioId);
                            $stmtPerguntas->execute();
                            $resultPerguntas = $stmtPerguntas->get_result();

                            if ($resultPerguntas->num_rows > 0) {
                                echo "<form action='correcao.php' method='POST'>";
                                echo "<input type='hidden' name='questionario_id' value='$questionarioId'>";

                                $perguntaCount = 0;
                                $totalPerguntas = $resultPerguntas->num_rows; 
                                while ($pergunta = $resultPerguntas->fetch_assoc()) {
                                    $perguntaCount++;
                                    echo "<div class='pergunta' id='pergunta_$perguntaCount' >";
                                    echo "<h3 class='perguntah3'>" . nl2br($pergunta['enunciado']) . "</h3>";
                                
                                    $sqlAlternativas = "SELECT alternativa_id, texto FROM alternativas WHERE pergunta_id = ?";
                                    $stmtAlternativas = $conexao->prepare($sqlAlternativas);
                                    $stmtAlternativas->bind_param('i', $pergunta['pergunta_id']);
                                    $stmtAlternativas->execute();
                                    $resultAlternativas = $stmtAlternativas->get_result();
                                
                                    while ($alternativa = $resultAlternativas->fetch_assoc()) {
                                        echo "<label class='alternativaLabel'><input class='perguntainput' type='radio' name='pergunta_" . $pergunta['pergunta_id'] . "' value='" . $alternativa['alternativa_id'] . "' required data-question-id='" . $pergunta['pergunta_id'] . "'> " . $alternativa['texto'] . "</label><br>";
                                    }
                                    echo "</div>";
                                }

                            
                                echo "<button class='questionariobotao' type='button' onclick='prevQuestion()'>Anterior</button>";
                                echo "<button class='questionariobotao' type='button' onclick='nextQuestion()'>Próxima</button>";

                            
                                echo "<input class='questionariobotaofim' type='submit' value='Enviar' id='btnEnviar' style='display: none;'>";

                                echo "</form>";
                            } else {
                                echo "Nenhuma pergunta disponível.";
                            }
                        } else {
                            echo "Nenhum questionário encontrado.";
                        }
                    ?>


                </div>
            </div>
            

        </div>
    
    <script>
        let currentQuestion = 1;
        const totalQuestions = <?php echo $perguntaCount; ?>; 

        document.addEventListener('DOMContentLoaded', function() {
            showQuestion(currentQuestion); 


            document.querySelectorAll('.perguntainput').forEach(input => {
                input.addEventListener('change', updateSubmitButtonVisibility);
            });
        });

        function showQuestion(questionNumber) {
        
            for (let i = 1; i <= totalQuestions; i++) {
                document.getElementById('pergunta_' + i).style.display = (i === questionNumber) ? '' : 'none';
            }

            
            if (questionNumber === totalQuestions) {
                updateSubmitButtonVisibility();
                document.querySelector("button[onclick='nextQuestion()']").style.display = 'none'; 
            } else {
                document.getElementById('btnEnviar').style.display = 'none'; 
                document.querySelector("button[onclick='nextQuestion()']").style.display = ''; 
            }

        
            updateNavigationButtons(questionNumber);
        }

        function updateSubmitButtonVisibility() {
            const allAnswered = [...document.querySelectorAll('.pergunta')].every(pergunta => {
                const inputs = pergunta.querySelectorAll('.perguntainput');
                return [...inputs].some(input => input.checked);
            });


            if (currentQuestion === totalQuestions && allAnswered) {
                document.getElementById('btnEnviar').style.display = '';
            } else {
                document.getElementById('btnEnviar').style.display = 'none';
            }
        }

        function updateNavigationButtons(questionNumber) {
        
            if (questionNumber === 1) {
                document.querySelector("button[onclick='prevQuestion()']").style.display = 'none'; 
            } else {
                document.querySelector("button[onclick='prevQuestion()']").style.display = ''; 
            }
        }

        function nextQuestion() {
            if (currentQuestion < totalQuestions) {
                currentQuestion++;
                showQuestion(currentQuestion);
            }
        }

        function prevQuestion() {
            if (currentQuestion > 1) {
                currentQuestion--;
                showQuestion(currentQuestion);
            }
        }

    </script>


<?php include ('../../assets/components/acbbotao.php'); ?>
<script src="../../assets/js/acessibilidade.js"></script>
</body>
</html>