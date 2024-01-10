<?php 
    function validaCPF($cpf) {
        if (strlen($cpf) !== 11) {
            return false;
        }

        // 1° for = compara e soma os 9 primeiros nums do cpf
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += $cpf[$i] * (10 - $i);
        }

        // Fornece o primeiro digto
        $resto = $soma % 11;
        if ($resto === 0 || $resto === 1) {
            $digito1 = 0;
        } else {
            $digito1 = 11 - $resto;
        }

        // 2° for = compara e soma os 10 primeiros nums do cpf
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += $cpf[$i] * (11 - $i);
        }

        // Fornece o segundo digito
        $resto = $soma % 11;
        if ($resto === 0 || $resto === 1) {
            $digito2 = 0;
        } else {
            $digito2 = 11 - $resto;
        }

        // Valida se os dígitos verficadores com o cpf informado
        $valido = ($cpf[9] === $digito1 && $cpf[10] === $digito2);

        if ($valido) {
            return false;
        } else {
            return true;
        }    
    }

    if (isset($_POST['submit'])) {
        include_once('conect.php');

        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];
        $senha = $_POST['senha'];
        $senhaRept = $_POST['senha-repeat'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $_SESSION['msg'] = 'E-mail digitado é inválido';
          exit;
        }

        if ($senha != $senhaRept) {
            echo 'As senha são Imcompatíveis, verifique as senhas';
        } else {
            if (!validaCPF($cpf)) {
                echo "CPF Inválido";
            } else {
                // As duas linha abaixo servem para codifificar a senha antes de enviar para o banco de dados;
                $options = ['const' => 12];
                $senhaHash = password_hash($senha, PASSWORD_BCRYPT, $options);

                date_default_timezone_set("America/Sao_Paulo");
                $dataAtual = date("Y-m-d H:i:s");

                $result = mysqli_query($conexao, "INSERT INTO pacientes (nome, cpf, email, telefone, senha, createdAt, updatedAt) VALUES ('$nome', '$cpf', '$email', '$telefone', '$senhaHash', '$dataAtual', '$dataAtual')");

                if ($result) {
                    echo "Usuário cadastrado com sucesso!";
                    header('Location: procuraPsi.html');
                } else {
                    echo "Erro ao cadastrar usuário. Por favor, tente novamente.";
                }
            }
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
    <link rel="stylesheet" href="./style/CadPaciente.css">
    <link rel="stylesheet" href="./style/Login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>EuPSICO - Cadastro Paciente</title>
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
        <form id="form" class="cadPaciente" method="post">
            <div class="cadastra_paciente">
                <h1>EuPSICO - Cadastro Paciente</h1>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" placeholder="Nos diga seu nome" required>

                <label for="cpf">CPF:</label>
                <input type="number" name="cpf" id="cpf" placeholder="Informe o seu CPF" required>

                <label for="telefone">Telefone:</label>
                <input required type="number" name="telefone" id="telefone" placeholder="Informe seu telefone">

                <label for="email">Email:</label>
                <input required type="email" name="email" id="email" placeholder="Informe se e-mail">

                <label for="senha">Crie uma senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Crie a sua Senha" required>

                <label for="senha-repeat">Confirme a senha:</label>
                <input type="password" name="senha-repeat" id="senha-repeat" placeholder="Confirmar Senha" required>

                <input type="submit" name="submit"  onclick="cadPaciente()" value="Enviar">

                <p class="erro">Caso já tenha, faça o login, clique <a href="./login.html">aqui</a> !</p>
            </div>
        </form>
    </main>

    <!-- JANELA MODAL DE CADASTRAO -->
    <div id="id_janela_modal" class='janela_modal'>
        <div class="modal_conteiner">
            <h3>Olá! Bem vindo ao nosso cadastro.</h3>
            <h5>Em qual das opções você se encaixa?</h5>

            <!-- Duas ANCORAS estao com as mesmas class -->
            <a href="CadPaciente.php" class="janela_modal_cliente">
                <img src="https://assets-global.website-files.com/613f7ca80295647d415b0d85/629f7441846001e38b41cc31_user.svg"
                    loading="lazy" alt="" class="janela_modal_cliente_icons">
                <div class="janela_modal_cliente_titulo">Cliente</div>
                <div class="janela_modal_cliente_frase">Quero fazer sessões de terapias e ver conteúdos sobre saúde
                    emocional</div>
            </a>

            <a href="CadPsicologo.php" class="janela_modal_cliente">
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
            <p>Eupsi é um Buscador de Psicólogos e Clientes para Terapia Online e Presencial e oferece aos seus usuários
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
    <script src="./js/script.js"></script>
    <!-- <script src="./js/form.js"></script> -->
    <!-- <script src="./js/testes.js"></script> -->
</body>

</html>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./assets/eupsi.png">

    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/CadPaciente.css">
    <link rel="stylesheet" href="./style/Login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <title>EuPSICO - Cadastro Paciente</title>
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
            <li><a href="./login.html">Entrar</a></li>
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
        <form id="form" class="cadPaciente" method="post">
            <div class="cadastra_paciente">
                <h1>EuPSICO - Cadastro Paciente</h1>
                <label for="nome">Nome:</label>
                <input type="text" name="nome" id="nome" placeholder="Nos diga seu nome" required>

                <label for="cpf">CPF:</label>
                <input type="number" name="cpf" id="cpf" placeholder="Informe o seu CPF" required>

                <label for="telefone">Telefone:</label>
                <input required type="number" name="telefone" id="telefone" placeholder="Informe seu telefone">

                <label for="email">Email:</label>
                <input required type="email" name="email" id="email" placeholder="Informe se e-mail">

                <label for="senha">Crie uma senha:</label>
                <input type="password" name="senha" id="senha" placeholder="Crie a sua Senha" required>

                <label for="senha-repeat">Confirme a senha:</label>
                <input type="password" name="senha-repeat" id="senha-repeat" placeholder="Confirmar Senha" required>

                <input type="submit" name="submit"  onclick="cadPaciente()" value="Enviar">

                <p class="erro">Caso já tenha, faça o login, clique <a href="./login.html">aqui</a> !</p>
            </div>
        </form>
    </main>

    <!-- JANELA MODAL DE CADASTRAO -->
    <div id="id_janela_modal" class='janela_modal'>
        <div class="modal_conteiner">
            <h3>Olá! Bem vindo ao nosso cadastro.</h3>
            <h5>Em qual das opções você se encaixa?</h5>

            <!-- Duas ANCORAS estao com as mesmas class -->
            <a href="CadPaciente.php" class="janela_modal_cliente">
                <img src="https://assets-global.website-files.com/613f7ca80295647d415b0d85/629f7441846001e38b41cc31_user.svg"
                    loading="lazy" alt="" class="janela_modal_cliente_icons">
                <div class="janela_modal_cliente_titulo">Cliente</div>
                <div class="janela_modal_cliente_frase">Quero fazer sessões de terapias e ver conteúdos sobre saúde
                    emocional</div>
            </a>

            <a href="CadPsicologo.php" class="janela_modal_cliente">
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
            <p>Eupsi é um Buscador de Psicólogos e Clientes para Terapia Online e Presencial e oferece aos seus usuários
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
    <script src="./js/script.js"></script>
    <!-- <script src="./js/form.js"></script> -->
    <!-- <script src="./js/testes.js"></script> -->
</body>

</html>