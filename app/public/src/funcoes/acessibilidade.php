<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve - Acessibilidade</title>
    <link rel="shortcut icon" href="../../assets/img/favicon.png" type="image/png">
    <link rel="stylesheet" href="../../assets/css/reset.css">
    <link rel="stylesheet" href="../../assets/css/acessibilidade.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap" rel="stylesheet">
    <style>
        .enabled {
            display: none; /* Oculta por padrão */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="contentWrapper">
            <div class="acbWrapper">
                <h1 class="acbH1">ACESSIBILIDADE</h1>
                <div class="btnWrapper">
                    <div class="btnOption">
                        <label class="switch">
                            <input id="switch" type="checkbox" />
                            <span class="slider round"></span>
                        </label>
                        <p class="btnP">MODO ESCURO</p>
                    </div>
                    <p class="descricaoP">Torna as cores do site escuras para evitar a fadiga visual.</p>

                    <div class="btnOption">
                        <label class="switch">
                            <input id="monochromeSwitch" type="checkbox" />
                            <span class="slider round"></span>
                        </label>
                        <p class="btnP">MODO MONOCROMÁTICO</p>
                    </div>
                    <p class="descricaoP">Torna os elementos em preto e branco para facilitar a visão de pessoas com daltonismo.</p>
                    
                    <div class="btnOption">
                        <label class="switch">
                            <input id="vlibrasSwitch" type="checkbox" />
                            <span class="slider round"></span>
                        </label>
                        <p class="btnP">VLIBRAS</p>
                    </div>
                    <p class="descricaoP">Ativa o intérprete de libras para auxiliar pessoas com deficiência auditiva.</p>
                </div>
            </div>
        </div>
    </div>

    <script src="../../assets/js/acessibilidade.js"></script>
   
    
    <div vw class="enabled">
        <div vw-access-button class="active"></div>
        <div vw-plugin-wrapper>
            <div class="vw-plugin-top-wrapper"></div>
        </div>
    </div>
    
    <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
    <script>
        new window.VLibras.Widget('https://vlibras.gov.br/app');

      
    </script>
</body>
</html>
