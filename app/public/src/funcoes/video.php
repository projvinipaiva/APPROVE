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

 
    $subconteudoId = isset($_GET['subconteudo_id']) ? intval($_GET['subconteudo_id']) : 0;
    
    if ($subconteudoId == 0) {
        echo "Subconteúdo inválido!";
        exit;
    }
    
 
    $query = $conexao->prepare("SELECT titulo, url FROM videoaulas WHERE subconteudo_id = ?");
    $query->bind_param("i", $subconteudoId);
    $query->execute();
    $result = $query->get_result();
    $video = $result->fetch_assoc();
    
    if (!$video) {
        echo "Nenhum vídeo encontrado para este conteúdo.";
        exit;
    }
    
  
    function getYouTubeEmbedUrl($url) {
      
        preg_match("/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/", $url, $matches);
        return isset($matches[1]) ? "https://www.youtube.com/embed/" . $matches[1] . "?autoplay=1" : '';
    }
    
    $embedUrl = getYouTubeEmbedUrl($video['url']);

    $queryPdf = $conexao->prepare("SELECT titulo, url FROM pdfs WHERE subconteudo_id = ?");
    $queryPdf->bind_param("i", $subconteudoId);
    $queryPdf->execute();
    $resultPdf = $queryPdf->get_result();
    $pdf = $resultPdf->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve - Vídeo</title>
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/video.css">
    <link rel="stylesheet" href="../../assets/css/navbar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php include ('../../assets/components/navbar.php'); ?>
        
        <div class="contentwrapper">
            <div class="videowrapper">
                <h1 class="videoH1"><?php echo htmlspecialchars($video['titulo']); ?></h1>
                <?php if ($embedUrl): ?>
                    <iframe class="videoIframe" width="770" height="450" src="<?php echo htmlspecialchars($embedUrl); ?>" 
                            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen></iframe>
                <?php else: ?>
                    <p>URL de vídeo inválida.</p>
                <?php endif; ?>
                <?php if ($pdf): ?>
                    <a class="videoA" href="<?php echo htmlspecialchars($pdf['url']); ?>" target="_blank">
                    <button class="videoButton">VER PDF</button>
                    </a>
                <?php else: ?>
                    <p>Nenhum PDF encontrado para este conteúdo.</p>
                <?php endif; ?>
            </div>
        </div>
        

    </div>
    <?php include ('../../assets/components/acbbotao.php'); ?>
    <script src="../../assets/js/acessibilidade.js"></script>    
</body>
</html>