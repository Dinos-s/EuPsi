<?php 
    session_start();

    include_once('conect.php');

    $chave = filter_input(INPUT_GET, 'chave', FILTER_DEFAULT);

    if (!empty($chave)) {
        $query_user = "SELECT id FROM psicologos WHERE chave_recSenha = '$chave'";

        $result_user = $conexao -> query($query_user);

        if(($result_user) AND ($result_user -> num_rows != 0)){
            $row_user = $result_user -> fetch_assoc();

            $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            // Hora e data da atualização
            date_default_timezone_set("America/Sao_Paulo");
            $updateAt = date('Y-m-d H:i:s');

            if(!empty($dados['novaSenha'])){
                $options = ['const' => 12];
                $newSenha= password_hash($dados['senha'], PASSWORD_BCRYPT, $options);
                $recSenha = 'NULL';

                $res_senha = "UPDATE psicologos SET senha='$newSenha', chave_recSenha='$recSenha', updatedAt='$updateAt' WHERE id='{$row_user['id']}'";

                if ($result = $conexao -> query($res_senha)) {
                    $_SESSION['msg'] = "<p style='color: green'>Senha atualizada com sucesso!</p>";
                    header('location: login.php');
                } else {
                    echo "<p style='color: red'>Tente novamente!</p>";
                    header('location: login.php');
                }
            }
        } else {
            $_SESSION['msg'] = "<p style='color: red>Erro: Link Inválido</p>";
            header('location: login.php');
        }
    } else {
        $_SESSION['msg'] = "<p style='color: red>Erro: Link Inválido</p>";
        header('location: login.php');
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
            <form method="post">
                <h1>Login</h1>
                <?php
                    if (isset($_GET['erro']) && $_GET['erro'] == 'UserNotFound') {
                        echo "<p class='erro'>Usuário não Cadastrado</p>";
                    }

                    $senha = "";
                    if(isset($dados['senha'])){
                        $senha = $dados['senha'];
                    }
                ?>

                <label for="senha">Digite sua nova senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Sua Nova Senha" required>

                <!-- <button type="submit" id="btnEnviar">Entrar</button> -->
                <input type="submit" name="novaSenha" value="Atualizar senha" id="btnEnviar">

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