<?php
session_start();
include_once('../autenticacao/connect.php');

if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['password']) == true )) {
    unset($_SESSION['email']);
    unset($_SESSION['password']);
    header('Location: ../index.php');
}

$logado = $_SESSION['email'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image = $_FILES['image'];
        $imageName = $image['name'];
        $imageTmpName = $image['tmp_name'];
        $imageSize = $image['size'];
        $imageError = $image['error'];
        $imageType = $image['type'];

        $fileDestination = '../../assets/img/uploads/' . $imageName;

        if (move_uploaded_file($imageTmpName, $fileDestination)) {
            $sql = "UPDATE usuarios SET username = '$name', profile_pic = '$fileDestination' WHERE email = '$logado'";
            $result = mysqli_query($conexao, $sql);

            if ($result) {
                header("Location: perfil.php"); 
            } else {
                echo "Erro ao atualizar as suas informações";
            }
        } else {
            echo "Erro ao fazer o upload da imagem.";
        }
    } else {
        $sql = "UPDATE usuarios SET username = '$name' WHERE email = '$logado'";
        $result = mysqli_query($conexao, $sql);

        if ($result) {
            header("Location: perfil.php"); 
            echo "Erro ao atualizar o nome no banco de dados.";
        }
    }
}

$sql = "SELECT username, profile_pic FROM usuarios WHERE email = '$logado'";
$result = mysqli_query($conexao, $sql);
$userData = mysqli_fetch_assoc($result);
$username = $userData['username'];
$profilePic = isset($userData['profile_pic']) && !empty($userData['profile_pic']) ? $userData['profile_pic'] : '../../assets/img/default-profile.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve - Editar perfil</title>
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
                <h1 class="perfilh1">EDITAR PERFIL</h1>
                <div class="perfilInfo">
                    <form class="editarPerfilForm" action="editarperfil.php" method="post" enctype="multipart/form-data">

                        <img class="perfilFoto" src="<?php echo htmlspecialchars($profilePic); ?>" alt="Foto de perfil">
                        <p>ALTERE A FOTO:</p>
                        <label class="imgLabel" for="image">ENVIAR ARQUIVO</label>
                        <input class="editarPerfilInput" type="file" name="image" id="image">

                        <label for="name">ALTERE O NOME:</label>
                        <input class="editarPerfilInput" type="text" name="name" id="name" value="<?php echo htmlspecialchars($username); ?>" required>
                        <div class="perfiloptions">

                            <button type="submit" class="perfilSalvar">SALVAR</button>  
                            
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include ('../../assets/components/acbbotao.php'); ?>
    <script src="../../assets/js/acessibilidade.js"></script>
</body>
</html>
