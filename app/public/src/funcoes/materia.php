<?php
    session_start();
    if (!isset($_SESSION['email']) || !isset($_SESSION['password'])) {
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('Location: ../index.php');
        exit;
    }

    $logado = $_SESSION['email'];


    include_once('../autenticacao/connect.php');


    $materia_id = isset($_GET['id']) ? intval($_GET['id']) : 0;


    if ($materia_id == 0) {
        echo "Matéria inválida!";
        exit;
    }


    $query_materia = $conexao->prepare("SELECT nome FROM materias WHERE id = ?");
    $query_materia->bind_param("i", $materia_id);
    $query_materia->execute();
    $result = $query_materia->get_result();
    $materia = $result->fetch_assoc();

    if (!$materia) {
        echo "Matéria não encontrada!";
        exit;
    }


    $query_subconteudos = $conexao->prepare("SELECT subconteudo_id, nome FROM subconteudos WHERE materia_id = ?");
    $query_subconteudos->bind_param("i", $materia_id);
    $query_subconteudos->execute();
    $result_subconteudos = $query_subconteudos->get_result();
    $subconteudos = $result_subconteudos->fetch_all(MYSQLI_ASSOC);

    $class_cor = "cor-default"; 
    $svg_icon = "default.svg"; 

    if ($materia_id == 1) {
        $class_cor = "cor-materia-1";
        $svg_icon = "icon1.svg";
    } elseif ($materia_id == 2) {
        $class_cor = "cor-materia-2";
        $svg_icon = "icon2.svg";
    } elseif ($materia_id == 3) {
        $class_cor = "cor-materia-3";
        $svg_icon = "icon3.svg";
    } elseif ($materia_id == 4) {
        $class_cor = "cor-materia-4";
        $svg_icon = "icon4.svg"; 
    } elseif ($materia_id == 5) {
        $class_cor = "cor-materia-5";
        $svg_icon = "icon5.svg";
    } elseif ($materia_id == 6) {
        $class_cor = "cor-materia-6";
        $svg_icon = "icon6.svg";
    } elseif ($materia_id == 7) {
        $class_cor = "cor-materia-7";
        $svg_icon = "icon7.svg";
    } elseif ($materia_id == 8) {
        $class_cor = "cor-materia-8";
        $svg_icon = "icon8.svg";
    } elseif ($materia_id == 9) {
        $class_cor = "cor-materia-9";
        $svg_icon = "icon9.svg";
    } elseif ($materia_id == 10) {
        $class_cor = "cor-materia-10";
        $svg_icon = "icon10.svg";
    } elseif ($materia_id == 11) {
        $class_cor = "cor-materia-11";
        $svg_icon = "icon10.svg";
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($materia['nome']); ?></title>
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/materia.css">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include ('../../assets/components/navbar.php'); ?>
            <div class="contentwrapper">
                <div class="materiaswrapper">

                    <h1 class="materiaH1"><?php echo htmlspecialchars($materia['nome']); ?></h1>

                    <div class="grid-container">
                        <?php foreach ($subconteudos as $subconteudo): ?>
                            <a class="subconteudoA" href="escolha.php?subconteudo_id=<?php echo $subconteudo['subconteudo_id']; ?>">
                                <div class="grid-item <?php echo $class_cor; ?>">
                                    <img src="../../assets/img/icons/<?php echo $svg_icon; ?>" alt="Ícone" class="svg-icon" />
                                    <p class="subconteudoP"><?php echo htmlspecialchars($subconteudo['nome']); ?></p>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
      
                </div>
            </div>
            
           
        
    </div>
    <?php include ('../../assets/components/acbbotao.php'); ?>
    <script src="../../assets/js/acessibilidade.js"></script>
</body>
</html>
