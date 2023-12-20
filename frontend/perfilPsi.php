<?php
    include_once('conect.php');

    if (!empty($_GET['id'])) {
        $id = $_GET['id'];

        $query = "SELECT * FROM psicologos WHERE id= '$id'";

        $result = $conexao -> query($query);

        if ($result -> num_rows > 0) {
            while ($userData = mysqli_fetch_assoc($result)) {
                $nome = $userData['nome'];
                $email = $userData['email'];
                $crp = $userData['crp'];
                $telefone = $userData['telefone'];
                $resumo = $userData['resumo'];
                $foto = $userData['photo_perfil'];
                $valorSessao = $userData['valorsessao'];
                $tempoSessao = $userData['temposessao'];
                $localidade = $userData['localidade'];
                $experiencia = $userData['experiencia'];
                $especialidade = $userData['especialidade'];
                $formacao = $userData['formacao'];
            }
        } else {
            header('location: CadPsicologo.php');
        }
    } 

    $abordar = "SELECT * FROM abordagem";
    $res = $conexao -> query($abordar);

    if($res -> num_rows > 0) {
        while ($row = $res -> fetch_assoc()){
            $abordagem[] = $row['nome'];
        }
    }
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
            </ul>
        </nav>

        <div class="acesso">
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

                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" value="<?php echo $email?>" placeholder="Digite o seu e-mail">

                <label for="valorsessao">Valor da sessão:</label>
                <input type="number" id="valorsessao" name="valorSessão" placeholder="Nos diga o valor de sua sessão" value="<?php echo $valorSessao?>">

                <label for="temposessao">Tempo da sessão:</label>
                <input type="number" id="temposessao" name="tempoSessão" placeholder="Quanto tempo dura sua sessão (em minutos)" value="<?php echo $tempoSessao?>">

                <div class="input-container">
                    <label for="experiencia">Experiencia(s):</label>
                    <input type="text" id="experiencia" name="experiencia" value="<?php echo $experiencia?>" placeholder="Nos diga quais as suas experiencias">
                    <button class="add-more">+</button>
                </div>

                <div class="input-container">
                    <label for="especialidade">Especialidade(s):</label>
                    <input type="text" id="especialidade" name="especialidade" value="<?php echo $especialidade?>" placeholder="Nos diga qual a sua especialidade">
                    <button class="add-more">+</button>
                </div>

                <div class="input-container">
                    <label for="formacao">Formação:</label>
                    <input type="text" id="formacao" name="formacao" value="<?php echo $formacao?>" placeholder="Informe a sua Formação">
                    <button class="add-more">+</button>
                </div>

                <div class="input-container">
                    <label for="Localidade">Localidade:</label>
                    <input required type="text" id="Localidade" name="localidade" value="<?php echo $localidade?>" placeholder="Informe o seu local de atendimento">
                    <button class="add-more">+</button>
                </div>

                <label for="telefone">Telefone:</label>
                <input required type="tel" id="telefone" placeholder="Informe seu telefone" name="telefone" value="<?php echo $telefone?>">

                <label>Abordagem:</label>
                <!-- <div class="abordagem">
                    <div>
                        <input type="checkbox" name="abordagem[]" value="psicologia_humanista">
                        <label>PSICOLOGIA HUMANISTA</label>
                    </div>

                    <div>
                        <input type="checkbox" name="abordagem[]" value="cognitivo_comportamental">
                        <label>COGNITIVO COMPORTAMENTAL (TCC)</label>
                    </div>

                    <div>
                        <input type="checkbox" name="abordagem" value="fenomenologia_existencial">
                        <label>FENOMENOLOGIA EXISTENCIAL</label>
                        <br>
                    </div>

                    <div>
                        <input type="checkbox" name="abordagem" value="gestalt_terapia">
                        <label>GESTÃO TERAPIA</label>
                        <br>
                    </div>

                    <div>
                        <input type="checkbox" name="abordagem" value="psicanalise">
                        <label>PSICANÁLISE</label>
                        <br>
                    </div>

                    <div>
                        <input type="checkbox" name="abordagem" value="psicologia_analitica">
                        <label>PSICOLOGIA ANALÍTICA</label>
                        <br>
                    </div>

                    <div>
                        <input type="checkbox" name="abordagem" value="psicologia_humanista">
                        <label>PSICOLOGIA HUMANISTA</label>
                    </div>
                </div> -->
                <div class="abordagem">
                    <?php foreach ($abordagem as $a) { ?>
                        <div>
                            <input type="checkbox" name="abordagem[]" value="<?php echo $a?>">
                            <label><?php echo $a ?></label>
                        </div>
                    <?php } ?>
                </div>

                <label for="resumo">Descrição Pessoal:</label>
                <textarea name="resumo" id="resumo" cols="30" rows="10"><?php if (!empty($resumo)) { echo $resumo; } ?></textarea>

                <!-- <button class="enviarForm" type="submit" onclick="updatePsi()">Atualizar/Enviar Dados</button> -->
                <input type="hidden" name="id" value="<?php echo $id?>">
                <input type="hidden" name="old_perfil" value="<?php echo $foto?>">
                <input type="submit" name='update' value="Atualizar/Enviar Dados" class="enviarForm">
            </div>
        </form>
    </main>

    <footer>
        <section class="f1">
            <img src="./assets/eupsi.png" alt="EuPSI" class="logo">
        </section>

        <section class="f2">
            <p>Eupsico é um Buscador de Psicólogos e Clientes para Terapia Online e Presencial e oferece aos seus usuários
                o melhor método para encontrar o profissional ideal para sua necessidade. Possuindo um catálogo completo
                e profissionais experientes e certificados, seu uso será a solução ideal para qualquer dúvida
                relacionada aos serviços de terapia. Nossos profissionais são especialistas capacitados para lidar com
                as diversas áreas da psicologia, garantindo assim a melhor terapia para você.</p>
        </section>

        <section class="f3">
            <ul class="menuf">
                <li>Menu</li>
                <li><a href="./index.html">início</a></li>
                <li><a href="./procuraPsi.html">procurar psicólogo</a></li>
                <li><a href="#">plano psicologo</a></li>
                <li><a href="./contato.html">contato</a></li>
            </ul>
        </section>
    </footer>
    <script src="./js/form.js"></script>
    <script src="./js/script.js"></script>
</body>

</html>