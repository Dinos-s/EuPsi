<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./assets/eupsi.png">

    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/CadPsicologo.css">
    <link rel="stylesheet" href="./style/Login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>EuPSICO - Cadastro Psicologo</title>
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
            <li><a href="#">Entrar</a></li>
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

    <main id="main-login">
        <div class="cadastra_psicologo login">
            <form action="session.php" method="post">
                <h1>Login</h1>
                <?php
                    if (isset($_GET['erro']) && $_GET['erro'] = 'UserNotFound') {
                        echo "<p class='erro'>Usuário não Cadastrado</p>";
                    }

                    if (isset($_SESSION['msg'])) {
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                ?>
                <label for="nome">Email:</label>
                <input type="email" name="email"  id="email" placeholder="Informe seu email" required>

                <label for="senha">Senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Sua Senha" required>

                <!-- <label for="tipo_usuario">Tipo de usuário:</label>
                <div class="opcoes-usuario">
                    <input type="radio" name="tipo_usuario" id="tipo_psicologo" value="psicologo" required>
                    <label for="tipo_psicologo">Psicólogo</label>

                    <input type="radio" name="tipo_usuario" id="tipo_paciente" value="paciente" required>
                    <label for="tipo_paciente">Paciente</label>
                    
                    <!- <input type="radio" name="tipo_usuario" id="tipo_admin" value="admin" required>
                    <label for="tipo_admin">Administrador</label> ->
                </div> -->

                <!-- <button type="submit" id="btnEnviar">Entrar</button> -->
                <input type="submit" name="submit" value="Entrar" id="btnEnviar">

                <!-- <p class="erro">Caso não tenha, faça o cadastro, clique <a href="./CadPaciente.html">aqui</a> e faça sua consulta!</p> -->
                <p class="erro">Esqueceu a senha, clique <a href="./recuperar-senha.php">aqui</a> e recupere sua senha!</p>
            </form>
            
        </div>
    </main>

    <!-- JANELA MODAL DE CADASTRAO -->
    <div id="id_janela_modal" class='janela_modal'>
        <div class="modal_conteiner">
            <h3>Olá! Bem vindo ao nosso cadastro.</h3>
            <h5>Em qual das opções você se encaixa?</h5>

            <!-- Duas ANCORAS estao com as mesmas class -->
            <a href="./CadPaciente.php" class="janela_modal_cliente">
                <img src="https://assets-global.website-files.com/613f7ca80295647d415b0d85/629f7441846001e38b41cc31_user.svg"
                    loading="lazy" alt="" class="janela_modal_cliente_icons">
                <div class="janela_modal_cliente_titulo">Cliente</div>
                <div class="janela_modal_cliente_frase">Quero fazer sessões de terapias e ver conteúdos sobre saúde
                    emocional</div>
            </a>

            <a href="./CadPsicologo.php" class="janela_modal_cliente">
                <img src="https://assets-global.website-files.com/613f7ca80295647d415b0d85/629f744100a51a93a6febb8c_certif.svg"
                    loading="lazy" alt="" class="janela_modal_cliente_icons">
                <div class="janela_modal_cliente_titulo">Profissional</div>
                <div class="janela_modal_cliente_frase">Quero atender pacientes online e fazer gestão da minha carreira
                </div>
            </a>

            <!-- Botão fechar -->
            <!-- 
                <div class="modal_footer">
                    <a href="#" class="modal_footer_btn_close"> Fechar </a>
                </div> -->

            <a href="#" class="modal_close">&times;</a>
        </div>
    </div>

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
                <li><a href="./procuraPsi.php">procurar psicólogo</a></li>
                <li><a href="#">plano psicologo</a></li>
                <li><a href="./contato.html">contato</a></li>
            </ul> -->
        </section>
    </footer>
    <!-- <script src="./js/script.js"></script> -->
    <!-- <script src="./js/form.js"></script> -->
</body>

</html>