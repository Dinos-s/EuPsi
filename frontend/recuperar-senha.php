<?php 
    session_start();

    include_once('conect.php');

    $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
    if (!empty($dados)) {
        // var_dump($dados);
        $email = $dados['email'];

        $query_email = "SELECT id, nome, email FROM psicologos WHERE email = '{$email}' ";
        $result_user = $conexao -> query($query_email);

        if (($result_user) AND ($result_user -> num_rows != 0)) {
            $row_user = $result_user -> fetch_assoc();

            $options = ['const' => 12];
            $chave_recSenha = password_hash($row_user['id'], PASSWORD_BCRYPT, $options);

            $query_up = "UPDATE psicologos SET chave_recSenha = '{$chave_recSenha}' WHERE id = '{$row_user['id']}'";

            // print_r($chave_recSenha);

            if ($result_up = $conexao -> query($query_up)) {
                $link_Rec = "http://localhost/frontend/recSenha.php?chave=$chave_recSenha";
            } else {
                $_SESSION['msg'] = "<p style='color: red'>Erro: Tente novamente</a>";
            }
        } else {
            $_SESSION['msg'] = "<p style='color: red'>Erro: Email não cadastrado</a>";
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
    <link rel="stylesheet" href="./style/Login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>EuPSICO - Recuperar Senha</title>
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
            <form method="post">
                <h1>Recuperar Senha</h1>
                <?php
                    if (isset($_GET['erro']) && $_GET['erro'] == 'UserNotFound') {
                        echo "<p class='erro'>Usuário não Cadastrado</p>";
                    }

                    if (isset($result_up)) {
                        echo "<a href='$link_Rec'>Gere uma nova senha</a>";
                    }
                ?>

                <label for="nome">Email:</label>
                <input type="email" name="email"  id="email" placeholder="Email cadastrado" required>

                <!-- <button type="submit" id="btnEnviar">Entrar</button> -->
                <input type="submit" name="RecSenha" value="Recuperar senha" id="btnEnviar">

                <!-- <p class="erro">Caso não tenha, faça o cadastro, clique <a href="./CadPaciente.html">aqui</a> e faça sua consulta!</p> -->
                <p class="erro">Lembrou a senha? Clique <a href="./login.php">aqui</a> e faça o seu login!</p>
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
                <li><a href="./procuraPsi.php">procurar psicólogo</a></li>
                <li><a href="#">plano psicologo</a></li>
                <li><a href="./contato.html">contato</a></li>
            </ul>
        </section>
    </footer>
    <!-- <script src="./js/script.js"></script> -->
    <!-- <script src="./js/form.js"></script> -->
</body>

</html>