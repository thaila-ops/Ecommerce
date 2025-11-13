<?php
//abrir uma sessao
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alquimia III</title>

    <base href="http://<?=$_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"]?>">

    <script src="https://kit.fontawesome.com/a2e0e9b7b8.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

        <!-- include summernote css/js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    

    <script>
        function mensagem(titulo, icone, pagina) {
            Swal.fire({
                title: titulo,
                icone: icone, //error, ok, success, question
            }).then((result) => {
                
                if (icone == "error") {
                    history.back();
                } else {
                    location.href = pagina;
                }

            });
        }
    </script>
</head>
</head>
<body>
  <?php
    //verificar se esta logado - senao estiver login
    //se nao esta logado mas esta enviando dados - validacao
    //se estiver logado - mostro a tela do sistema
    if (($_POST) && (!isset($_SESSION["usuario"]))) {
        //validacao do usuario

        require "../controllers/IndexController.php";

        //print_r($_POST);
        $pagina = new IndexController();
        $pagina->verificar($_POST);

    } else if (!isset($_SESSION["usuario"])) {
        //mostrar a tela de login
        require "../views/login/index.php";
    } else if (isset($_SESSION["usuario"])) {
        //mostro a tela do sistema
        require "menu.php";

        //rotas
        if (isset($_GET["param"])) {
            $param = explode("/", $_GET["param"]);
        }

        $controller = $param[0] ?? "index";
        $view = $param[1] ?? "index";
        $id = $param[2] ?? NULL;

        // categoria -> CategoriaController
        $controller = ucfirst($controller)."Controller";

        //incluir o controller
        if (file_exists("../controllers/{$controller}.php")) {
            require "../controllers/{$controller}.php";

            $control = new $controller();
            $control->$view($id);

        } else {
            require "../views/index/erro.php";
        }
        
    } else {
        echo "<p>Requisição inválida</p>";
    }
    ?>
    
</body>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>