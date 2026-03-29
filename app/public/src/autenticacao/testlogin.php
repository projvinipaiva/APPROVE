<?php
session_start();

if (isset($_POST['login']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    
    include_once('connect.php');
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar o usuário pelo email
    $sql = "SELECT * FROM usuarios WHERE email = '$email'";
    $result = $conexao->query($sql);

    if (mysqli_num_rows($result) < 1) {
        // Se o usuário não for encontrado, redirecionar
        unset($_SESSION['email']);
        unset($_SESSION['password']);
        unset($_SESSION['username']);
        unset($_SESSION['id']);
        header('Location: ../index.php');
    } else {
        // Obter os dados do usuário
        $user = $result->fetch_assoc();

        // Verificar se a senha fornecida corresponde ao hash armazenado
        if (password_verify($password, $user['password'])) {
            // Iniciar a sessão se a senha estiver correta
            $_SESSION['email'] = $user['email'];
            $_SESSION['password'] = $user['password'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['id'] = $user['id'];

            header('Location: ../funcoes/home.php');
        } else {
            // Senha incorreta
            header('Location: ../index.php');
        }
    }
} else {
    header('location: ../index.php');
}

?>
