<?php 
    include_once('conect.php');

    if(isset($_POST['update'])){
        $id = $_POST['id'];
        $perfil = $_FILES['image'];
        $nome = $_POST['nome'];
        $crp = $_POST['crp'];
        $email = $_POST['email'];
        $valorSessao = $_POST["valorSessão"];
        $tempoSessao = $_POST["tempoSessão"];
        $especialidade = $_POST["especialidade"];
        $experiencia = $_POST["experiencia"];
        $formacao = $_POST["formacao"];
        $telefone = $_POST['telefone'];
        $localidade = $_POST['localidade'];
        // $abordagem = $_POST['abordagem'];
        $resumo = $_POST['resumo'];

        // Hora e data da atualização
        date_default_timezone_set("America/Sao_Paulo");
        $updateAt = date('Y-m-d H:i:s');

        //imagem de perfil
        $oldPerfil = $_POST['old_perfil'];

        if (empty($perfil['name'])) {
            $caminho = $oldPerfil; // aqui irei evitar que o campo exija uma foto novamente assim que atualizar os dados;
        } else {
            // Pegando a img de perfil do usuario
            $destino = 'uploads/';
            $imgPerfil = $perfil['name'];
            $newName = uniqid();

            // Pegando a extensão do arquivo
            $extensao = strtolower(pathinfo($imgPerfil, PATHINFO_EXTENSION));

            // verificando o tipo de arquivo enviado
            if ($extensao != "jpg" && $extensao != "jpeg" && $extensao != "png") {
                die("Arquivo invalido");
            }

            // Mover a imagem para um diretório no servidor
            $caminho = $destino . $newName . "." . $extensao;
            move_uploaded_file($perfil['tmp_name'], $caminho);
        }

        $valorSessao = str_replace(",", ".", $valorSessao);

        // Verificar se a checkbox foi marcada
        $abordagem = isset($_POST["abordagem"]) ? $_POST["abordagem"] : array();
        // $abordagem = isset($_POST["id_abord"]) ? $_POST["id_abord"] : array();
        // echo $_POST["abordagem"];
        $abordagens = implode(";", $abordagem);

        $sql = "UPDATE psicologos SET nome='$nome', email='$email', crp='$crp', resumo='$resumo', telefone='$telefone', updatedAt='$updateAt', photo_perfil='$caminho', valorsessao='$valorSessao', temposessao='$tempoSessao', localidade='$localidade', formacao='$formacao', experiencia='$experiencia', especialidade='$especialidade', abordagem = '$abordagens' WHERE id='$id'";

        $result = $conexao -> query($sql);
        // if ($abordagem !== null) {
        //     for ($i=0; $i < count($abordagem); $i++) { 
        //         echo "<p>{$abordagem[$i]}</p>";
        //     }
        // }
    }
    header("Location: perfilPsi.php?id=$id")
?>