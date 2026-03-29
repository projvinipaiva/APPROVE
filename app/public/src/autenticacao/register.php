<?php
    if (isset($_POST['submit'])) {
        include_once('connect.php');

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Hash da senha usando password_hash
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Verificar se a imagem foi enviada sem erros
        if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $image = $_FILES['image'];
            $imageName = $image['name'];
            $imageTmpName = $image['tmp_name'];

            $allowed = array('jpg', 'jpeg', 'png', 'gif');
            $imageExt = strtolower(pathinfo($imageName, PATHINFO_EXTENSION));

            if (in_array($imageExt, $allowed)) {
                $newImageName = uniqid('', true) . "." . $imageExt;
                $fileDestination = '../../assets/img/uploads/' . $newImageName;

                if (move_uploaded_file($imageTmpName, $fileDestination)) {
                    // Inserir os dados no banco de dados com a senha criptografada
                    $sql = "INSERT INTO usuarios (username, email, password, profile_pic) 
                            VALUES ('$name', '$email', '$hashedPassword', '$fileDestination')";

                    $result = mysqli_query($conexao, $sql);

                    if ($result) {
                        header('Location: login.php');
                    } else {
                        echo "Erro ao cadastrar o usuário.";
                    }
                } else {
                    echo "Erro ao fazer o upload da imagem.";
                }
            } else {
                echo "Formato de arquivo não permitido. Use JPG, JPEG, PNG ou GIF.";
            }
        } else {
            echo "Erro no envio da imagem.";
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve - Cadastro</title>
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/autenticacao.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rakkas&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
</head>
<body>
<div class="englobaTudoCadastro">
        <div class="containerCadastro">
            <div class="wrapper">
            <form method="post" autocomplete="off" action="register.php" enctype="multipart/form-data">
    <h1 class="registerH1">CADASTRO</h1>
    <div class="inputBox">
        <label for="name">NOME</label>
        <input type="text" id="name" name="name" placeholder="DIGITE O SEU NOME" required />
    </div>
    <div class="inputBox">
        <label for="email">EMAIL</label>
        <input type="email" id="email" name="email" placeholder="DIGITE O SEU EMAIL" required />
    </div>
    <div class="inputBox">
        <label for="password">SENHA</label>
        <input type="password" id="password" name="password" placeholder="DIGITE A SUA SENHA" required />
    </div>
    <div class="inputBox">
        <P class="pLabel">FOTO DE PERFIL</P>
        <label class="imgLabel" for="image">ADICIONAR IMAGEM</label>
        <input type="file" id="image" name="image" required />
    </div>
    <button type="submit" value="Register" name="submit" class="btn">CADASTRAR</button>
    <div class="registerLink">
        <p>Já possui uma conta?<a href="login.php" class="cadastr"> Entrar</a></p>
    </div>
</form>

            </div>
            <img class="img2" src="../../assets/img/muie2.png" alt="" />
        </div>
        <div class="footerHome">
            <p class="footerHomeP">APPROVE ® 2024</p>
        </div> 
    </div>
    <?php include ('../../assets/components/acbbotao.php'); ?>
    <script src="../../assets/js/acessibilidade.js"></script>

</body>
</html>

