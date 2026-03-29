<?php
    session_start();
    include_once('../autenticacao/connect.php');

    // Verifica se o usuário está logado
    if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['password']) == true )) {
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        header('Location: ../index.php');
    }

    $logado = $_SESSION['email'];
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Usuário';

    // Busca os dados do usuário no banco de dados
    $sql = "SELECT username, profile_pic FROM usuarios WHERE email = '$logado'";
    $result = mysqli_query($conexao, $sql);
    $userData = mysqli_fetch_assoc($result);

    $profilePic = isset($userData['profile_pic']) && !empty($userData['profile_pic']) ? $userData['profile_pic'] : '../../assets/img/default-profile.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve - Perfil</title>
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/perfil.css">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include ('../../assets/components/navbar.php'); ?>
        
        <div class="contentwrapper">
            <div class="perfilwrapper">
                <h1 class="perfilh1">PERFIL</h1>
                <div class="perfilInfo">
                    <img class="perfilFoto" src="<?php echo htmlspecialchars($profilePic); ?>" alt="Foto de perfil">
                    <p class="perfilP"><?php echo htmlspecialchars($userData['username']); ?></p>
                </div>
                <div class="perfiloptions">
                    <a href="editarperfil.php">
                        <button type="button" class="perfilEditar">EDITAR</button>
                    </a>    
                  
                    <a href="../autenticacao/sair.php">
                        <button type="button" class="perfilSair"> SAIR </button>
                    </a>
                </div>
            </div>
        </div>
    </div>
  
    <?php include ('../../assets/components/acbbotao.php'); ?>
    <script src="../../assets/js/acessibilidade.js"></script>
</body>
</html>
