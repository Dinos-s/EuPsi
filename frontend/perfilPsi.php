<?php
    session_start();

    include_once('conect.php');
    include('./js/textoLongo.php');

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
                $foto = $userData['photo_perfil'];
                $valorSessao = $userData['valorsessao'];
                $tempoSessao = $userData['temposessao'];
                $localidade = $userData['localidade'];
                $experiencia = $userData['experiencia'];
                $especialidade = $userData['especialidade'];
                $formacao = $userData['formacao'];
                $aborda = $userData['abordagem'];
                $typeUser = $userData['tipo_user'];
            }
        } else {
            header('location: CadPsicologo.php');
        }
    } 
    
    $abordagens_selecionadas = explode(';', $aborda);
    
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

    print_r($hora);
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
    <title>Perfil do Psicólogo</title>
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
                <h2>Complete ou atualize o seu cadastro</h2>

                <label for="imagem">Escolher Imagem:</label>
                <input type="file" name='image' id="imagem" accept="image/*">
                <img id="imagem-preview" src="<?php echo $foto ?>" alt="Imagem do psicólogo">

                <label for="nome">Nome:</label>
                <input type="text" name="nome"value="<?php echo $nome ?>"  id="nome" placeholder="Nos diga seu nome">

                <label for="crp">CRP:</label>
                <input type="text" name='crp' value="<?php echo $crp?>" id="crp" placeholder="Digite seu CRP">

                <label for="cpf">CPF:</label>
                <input type="text" name="cpf" value="<?php echo $cpf?>" id="cpf" placeholder="Digite seu CPF">

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo $email?>" placeholder="Digite o seu e-mail">

                <label for="valorsessao">Valor da sessão:</label>
                <input type="number" id="valorsessao" name="valorSessão" placeholder="Nos diga o valor de sua sessão" value="<?php echo $valorSessao?>">

                <label for="temposessao">Tempo da sessão:</label>
                <input type="number" id="temposessao" name="tempoSessão" placeholder="Quanto tempo dura sua sessão (em minutos)" value="<?php echo $tempoSessao?>">

                <div class="input-container xp">
                    <div id="experiencia-grup">
                        <label for="experiencia">Experiencia(s):</label>
                        <input type="text" id="experiencia" name="experiencia" value="<?php echo $experiencia?>" placeholder="Nos diga quais as suas experiencias">
                        <button class="add-more" type="button">+</button>
                    </div>
                </div>

                <div class="input-container">
                    <div id="especialidade-grup">
                        <label for="especialidade">Especialidade(s):</label>
                        <input type="text" id="especialidade" name="especialidade" value="<?php echo $especialidade?>" placeholder="Nos diga qual a sua especialidade">
                        <button class="add-more" type="button">+</button>
                    </div>
                </div>

                <div class="input-container">
                    <div id="formacao-grup">   
                        <label for="formacao">Formação:</label>
                        <input type="text" id="formacao" name="formacao" value="<?php echo $formacao?>" placeholder="Informe a sua Formação">
                        <button class="add-more" type="button">+</button>
                    </div>
                </div>

                <div class="input-container">
                    <div id="localidade-grup">
                        <label for="Localidade">Localidade:</label>
                        <input required type="text" id="Localidade" name="localidade" value="<?php echo $localidade?>" placeholder="Informe o seu local de atendimento">
                        <button class="add-more" type="button">+</button>
                    </div>
                </div>

                <label for="telefone">Telefone:</label>
                <input required type="tel" id="telefone" placeholder="Informe seu telefone" name="telefone" value="<?php echo $telefone?>">

                <!-- Listagem das abordagens -->
                <label>Abordagem:</label>
                <div class="abordagem">
                    <?php foreach ($abordagem as $a) { 
                        $checked = in_array($a['id'], $abordagens_selecionadas);?>
                        
                        <div>
                            <!-- <?php print_r($a['id'])?> -->
                            <input type="checkbox" name="abordagem[]" value="<?php echo $a['id']?>" <?php echo $checked ? 'checked' : '' ?>>
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
                        
                        $horaInicial -> setTime(7, 0);
                        $horaFinal -> setTime(10, 0);

                        while($horaInicial <= $horaFinal){
                            $dados = consultarDados($conexao, $id, $dia, $horaInicial -> format('H:i')); ?>
                            
                            <label>
                                <input type="checkbox" name="horarios[]" value="<?php echo $dia . "-" . $horaInicial -> format('H:i') ?>"  <?php echo $dados ? "checked" : "" ?> >
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
            <!-- <p>Eupsico é um Buscador de Psicólogos e Clientes para Terapia Online e Presencial e oferece aos seus usuários
                o melhor método para encontrar o profissional ideal para sua necessidade. Possuindo um catálogo completo
                e profissionais experientes e certificados, seu uso será a solução ideal para qualquer dúvida
                relacionada aos serviços de terapia. Nossos profissionais são especialistas capacitados para lidar com
                as diversas áreas da psicologia, garantindo assim a melhor terapia para você.</p> -->
        </section>

        <section class="f3">
            <!-- <ul class="menuf">
                <li>Menu</li>
                <li><a href="./index.html">início</a></li>
                <li><a href="./procuraPsi.html">procurar psicólogo</a></li>
                <li><a href="#">plano psicologo</a></li>
                <li><a href="./contato.html">contato</a></li>
            </ul> -->
        </section>
    </footer>
    <script src="./js/form.js"></script>
    <script src="./js/script.js"></script>
    <!-- <script>
        const experienciaGrup = document.querySelector('.xp');
        const addMoreButton = document.querySelector('.add-more');

        addMoreButton.addEventListener('click', () => {
            const experienciaElement = document.createElement('input');
            experienciaElement.setAttribute('type', 'text');
            experienciaElement.setAttribute('id', 'experiencia');
            experienciaElement.setAttribute('name', 'experiencia[]');
            experienciaElement.setAttribute('placeholder', 'Nos diga quais as suas experiencias');

            experienciaGrup.appendChild(experienciaElement);
        });
    </script> -->
</body>

</html>