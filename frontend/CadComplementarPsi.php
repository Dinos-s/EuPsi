<?php
    session_start();

    include_once('conect.php');
    include('./js/Helpers.php');

    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        $query = "SELECT * FROM psicologos WHERE id= '$id'";

        $result = $conexao -> query($query);

        if ($result -> num_rows > 0) {
            while ($userData = mysqli_fetch_assoc($result)) {
                $nome = $userData['nome'];
                $email = $userData['email'];
                $crp = $userData['crp'];
                $cpf = $userData['cpf'];
                $telefone = $userData['telefone'];
                $resumo = $userData['resumo'];
                // $foto = $userData['photo_perfil'];
                // $valorSessao = $userData['valorsessao'];
                // $tempoSessao = $userData['temposessao'];
                // $localidade = $userData['localidade'];
                // $experiencia = $userData['experiencia'];
                // $especialidade = $userData['especialidade'];
                // $formacao = $userData['formacao'];
                // $aborda = $userData['abordagem'];
                $typeUser = $userData['tipo_user'];
            }
        } else {
            header('location: CadPsicologo.php');
        }
    } 
    
    // $abordagens_selecionadas = explode(';', $aborda);

    $abordar = "SELECT * FROM abordagem";
    $res = $conexao -> query($abordar);
    
    if($res -> num_rows > 0) {
        while ($row = $res -> fetch_assoc()){
            $abordagem[] = array('id' => $row['id'], 'nome' => $row['nome']);
        }
    }

    $horas = "SELECT * FROM hora_disponivel WHERE id_psicologo = '$id'";
    $retorno = $conexao -> query($horas);
    if($retorno -> num_rows > 0) {
        while ($row = $retorno -> fetch_assoc()){
            $hora[] = array('idPsi' => $row['id_psicologo'], 'dia' => $row['dia_semana'], 'horario' => $row['horario']);
        }
    }

    print_r($_SESSION);
    $loggedInUserId = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./assets/eupsi.png">

    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/CadPsicologo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>EuPSICO - Cadastro Psicologo</title>
    <style>
        .container {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        }

        .item{
            display: flex;
            flex-direction: column;
            background: red;
            margin: 10px;
        }
    </style>
</head>

<body>
    <header>
        <!-- LOGO -->
        <a href="./index.html" class="logo">
            <img src="./assets/eupsi.png" alt="teste">
        </a>

        <!-- MENU -->
        <nav>
            <ul class="menu">
                <li><a href="./index.html">início</a></li>
                <li><a href="./procuraPsi.php">procurar psicólogo</a></li>
                <li><a href="#">plano psicologo</a></li>
                <li><a href="./contato.html">contato</a></li>
                <?php 
                    if($typeUser == 'Ad'){
                        echo '<li><a href="./admin.php">Admin</a></li>';
                    }else if ($typeUser == 'Co') {
                        echo "<li><a class='active' href='./perfilPsi.php?id=$loggedInUserId'>Perfil</a></li>";
                    }
                ?>
            </ul>
        </nav>

        <div class="acesso">
            <?php if (isset($_SESSION['tipo_user'])) {
                echo '<li><a href="./sair.php">Sair</a></li>';
            }?>
            <li><a href="./login.php">Entrar</a></li>
            <li><a href="#id_janela_modal">Cadastro</a></li>

            <section class="icons_rede_sociais">
                <!-- LINK INSTA -->
                <a href="https://www.instagram.com/eupsi.insta/" target="_blank">
                    <i class="fab fa-instagram"></i>
                </a>

                <!-- LINK WHATSAPP -->
                <a href="https://api.whatsapp.com/send?phone=5581982317474" target="_blank">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </section>
        </div>
    </header>

    <main>
        <form action="update.php" method="post" id="form" enctype="multipart/form-data">
            <div class="cadastra_psicologo">
                <h1>EuPSICO - Cadastro Psicologo</h1>
                <h2>Complete o seu cadastro</h2>

                <label for="imagem">Escolher Imagem:</label>
                <input type="file" name='image' id="imagem" accept="image/*">
                <img id="imagem-preview" src="<?php echo $foto ?>" alt="Imagem do psicólogo">

                <label for="nome">Nome:</label>
                <input type="text" name="nome" value="<?php echo $nome ?>"  id="nome" placeholder="Nos diga seu nome">

                <label for="crp">CRP:</label>
                <input type="text" name='crp' value="<?php echo $crp?>" id="crp" placeholder="Digite seu CRP">

                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" value="<?php echo $cpf?>" id="cpf" placeholder="Digite seu CPF">

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo $email?>" placeholder="Digite o seu e-mail">

                <label for="valorsessao">Valor da sessão:</label>
                <input type="number" id="valorsessao" name="valorSessão" placeholder="Nos diga o valor de sua sessão" >

                <label for="temposessao">Tempo da sessão:</label>
                <input type="number" id="temposessao" name="tempoSessão" placeholder="Quanto tempo dura sua sessão (em minutos)" >

                <label for="horaInicial">Hora Inicial:</label>
                <input type="number" id="horaInicial" name="horaInicial" placeholder="De que horas você começa o seu tempo de psicologo?" >

                <label for="horaFinal">Hora Final:</label>
                <input type="number" id="horaFinal" name="horaFinal" placeholder="De que horas você termina o seu tempo de psicologo?">

                <div class="input-container xp">
                    <div id="experiencia-grup">
                        <label for="experiencia">Experiencia(s):</label>
                        <input type="text" id="experiencia" name="experiencia" placeholder="Nos diga quais as suas experiencias">
                        <button class="add-more" type="button">+</button>
                    </div>
                </div>

                <div class="input-container">
                    <div id="especialidade-grup">
                        <label for="especialidade">Especialidade(s):</label>
                        <input type="text" id="especialidade" name="especialidade" placeholder="Nos diga qual a sua especialidade">
                        <button class="add-more" type="button">+</button>
                    </div>
                </div>

                <div class="input-container">
                    <div id="formacao-grup">   
                        <label for="formacao">Formação:</label>
                        <input type="text" id="formacao" name="formacao" placeholder="Informe a sua Formação">
                        <button class="add-more" type="button">+</button>
                    </div>
                </div>

                <div class="input-container">
                    <div id="localidade-grup">
                        <label for="Localidade">Localidade:</label>
                        <input required type="text" id="Localidade" name="localidade" placeholder="Informe o seu local de atendimento">
                        <button class="add-more" type="button">+</button>
                    </div>
                </div>

                <label for="telefone">Telefone:</label>
                <input required type="tel" id="telefone" placeholder="Informe seu telefone" name="telefone" value="<?php echo $telefone?>">

                <!-- Listagem das abordagens -->
                <label>Abordagem:</label>
                <div class="abordagem">
                    <?php foreach ($abordagem as $a) { ?>
                        <div>
                            <!-- <?php print_r($a['id'])?> -->
                            <input type="checkbox" name="abordagem[]" value="<?php echo $a['id']?>" >
                            <label><?php echo $a['nome'] ?></label>
                        </div>
                    <?php } ?>
                </div>

                <!-- Listar as horas de atendimento -->
                <div class="container">
                    <?php
                    for ($dia = 1; $dia <= 7; $dia++) {
                        echo "<div class='item'>";
                        echo "<div class='day'>" . dia_da_semana($dia) . "</div>"; 
                        $horaInicial = new DateTime();
                        $horaFinal = new DateTime();
                        
                        // As duas linhas abaixo colocam os numeros em horarios 7 -> 7:00;
                        $horaInicial -> setTime(7, 0); // 1° arg: Horas; 2° arg: Minutos; 
                        $horaFinal -> setTime(10, 0);

                        while($horaInicial <= $horaFinal){ ?>

                            <label>
                                <input type="checkbox" name="horarios[]" value="<?php echo $dia . "-" . $horaInicial -> format('H:i') ?>" >
                                <?php echo $horaInicial -> format("H:i")?>
                            </label>

                            <?php $horaInicial -> add(new DateInterval("PT{$tempoSessao}M"));
                        } ?>
                        <?php echo "</div>";
                    }?> 
                </div>

                <label for="resumo">Descrição Pessoal:</label>
                <textarea name="resumo" id="resumo" cols="30" rows="10"><?php if (!empty($resumo)) { echo $resumo; } ?></textarea>

                <!-- <button class="enviarForm" type="submit" onclick="updatePsi()">Atualizar/Enviar Dados</button> -->
                <input type="hidden" name="id" value="<?php echo $id?>">
                <input type="hidden" name="old_perfil" value="<?php echo $foto?>">
                <input type="submit" name='update' value="Atualizar/Enviar Dados" class="enviarForm">

                <p class="erro">Esqueceu a senha, clique <a href="./recuperar-senha.php">aqui</a> e recupere sua senha!</p>
            </div>
        </form>  
    </main>

    <footer>
        <section class="f1">
            <img src="./assets/eupsi.png" alt="EuPSI" class="logo">
        </section>

        <section class="f2">

        </section>

        <section class="f3">

        </section>
    </footer>
    <script src="./js/form.js"></script>
    <script src="./js/script.js"></script>
    
</body>

</html>