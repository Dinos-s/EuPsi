<?php
    session_start();

    include_once('conect.php');

    if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        header('Location: login.php');
    }
    $logado = $_SESSION['email'];
    // print_r($_SESSION);

    $TipoUser = "SELECT tipo_user FROM psicologos WHERE email = '$logado'";
    $resTipo = $conexao -> query($TipoUser);
    $user = $resTipo -> fetch_assoc();
    $_SESSION['tipo_user'] = $user['tipo_user'];

    if ($logado !== 'gabriel02ramos@gmail.com') {
        header('Location: index.html?erro=nao_autorizado');
        exit();
    }

    if (!empty($_GET['search'])) {
        $data = $_GET['search'];
        $query = "SELECT * FROM psicologos WHERE nome LIKE '%$data%' or email LIKE '%$data%' or crp LIKE '%$data%' ORDER BY id";
    } else {
        $query = "SELECT * FROM psicologos ORDER BY id";
    }

    $result = $conexao->query($query);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./assets/eupsi.png">

    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="./style/Admin.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <title>EuPSICO - (Protótipo)</title>

</head>

<body>
    <header>
        <!-- LOGO -->
        <a href="index.html" class="logo">
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
                    if($_SESSION['tipo_user'] == 'Ad'){
                        echo '<li><a class="active" href="./admin.php">Admin</a></li>';
                    }
                ?>
            </ul>
        </nav>

        <div class="acesso">

            <li><a href="./login.php">Entrar</a></li>
            <!-- <li><a href="CadPaciente.html">Cadastro</a></li> -->
            <li><a href="#id_janela_modal">Cadastro</a></li>
            <!-- <li><a href="ModalCadastro.html">Cadastro</a></li> -->

            <!-- Icones das Redes Sociais -->
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
        
        <div class="pesquisa">
            <input type="text" id="pesquisa" placeholder="Pesquise por um usuário, nome, email, crp">
            <button onclick="dataSearch()">Pesquisar</button>
        </div>

        <nav>
            <p>Mude sua página de visualização:</p> 
            <ul class="menu-admim">
                <li><a class="active" href="./admin.php">Psicologos Cadastrados</a></li>
                <li><a href="./adminPaciente.php">Pacientes Cadastrados</a></li>
                <li><a href="./adminMarcados.php">Pacientes Marcados</a></li>
            </ul>
        </nav>

        <!-- <input type="radio" name="pagina" value="admin.php" id="admin">
        <label for="admin">Psicólogos Cadastrados</label>

        <input type="radio" name="pagina" value="adminPaciente.php" id="adminPaciente">
        <label for="adminPaciente">Pacientes Cadastrados</label> -->
        

        <div class="container">
            <div class="psicologos">
                <h2>Psicólogos Cadastrados</h2>
                <div id="psicologos-list">
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CRP</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Status</th>
                                <th>Data de entrada</th>
                                <th>Tipo de Usuário</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($psicologo = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $psicologo['nome'] . "</td>";
                                echo "<td>" . $psicologo['crp'] . "</td>";
                                echo "<td>" . $psicologo['email'] . "</td>";
                                echo "<td>" . $psicologo['telefone'] . "</td>";
                                // echo "<td><a href='#' class='change-status' data-id='" . $psicologo['id'] . "' data-status='" . $psicologo['status'] . "'>" . match ($psicologo['status']) {
                                //     'I' => 'Inativo',
                                //     'A' => 'Ativo'
                                // } . "</a></td>";
                                echo "<td>
                                        <select class='change-status' data-id='" . $psicologo['id'] . "'>
                                            <option value='A' " . ($psicologo['status'] === 'A' ? 'selected' : '') . ">Ativo</option>
                                            <option value='I' " . ($psicologo['status'] === 'I' ? 'selected' : '') . ">Inativo</option>
                                        </select>
                                    </td>";

                                echo "<td>" . $psicologo['createdAt'] . "</td>";
                                echo "<td>" . match ($psicologo['tipo_user']) {
                                    'Ad' => 'Admin',
                                    'Co' => 'Comum'
                                } . "</td>";
                                echo "<td> <a style='color: #dfd51a' href='deletar.php?id=$psicologo[id]'>Deletar🗑</a> </td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <!-- JANELA MODAL DE CADASTRAO -->
    <div id="id_janela_modal" class='janela_modal'>
        <div class="modal_conteiner">
            <h3>Olá! Bem vindo ao nosso cadastro.</h3>
            <h5>Em qual das opções você se encaixa?</h5>

            <!-- Duas ANCORAS estao com as mesmas class -->
            <a href="./CadPaciente.php" class="janela_modal_cliente">
                <img src="https://assets-global.website-files.com/613f7ca80295647d415b0d85/629f7441846001e38b41cc31_user.svg" loading="lazy" alt="" class="janela_modal_cliente_icons">
                <div class="janela_modal_cliente_titulo">Cliente</div>
                <div class="janela_modal_cliente_frase">Quero fazer sessões de terapias e ver conteúdos sobre saúde
                    emocional</div>
            </a>
            

            <a href="./CadPsicologo.php" class="janela_modal_cliente">
                <img src="https://assets-global.website-files.com/613f7ca80295647d415b0d85/629f744100a51a93a6febb8c_certif.svg" loading="lazy" alt="" class="janela_modal_cliente_icons">
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
            <p>footer 2</p>
            <!-- <p>Eupsi é um Buscador de Psicólogos e Clientes para Terapia Online e Presencial e oferece aos seus usuários o melhor método para encontrar o profissional ideal para sua necessidade. Possuindo um catálogo completo e profissionais experientes e certificados, seu uso será a solução ideal para qualquer dúvida relacionada aos serviços de terapia. Nossos profissionais são especialistas capacitados para lidar com as diversas áreas da psicologia, garantindo assim a melhor terapia para você.</p> -->
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

    <script src="./js/admin.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const changeStatusSelects = document.querySelectorAll('.change-status');

changeStatusSelects.forEach(select => {
    select.addEventListener('change', async function(event) {
        const id = this.dataset.id;
        const newStatus = this.value;

        const response = await fetch('change_status.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `id=${id}&status=${newStatus}`
        });

        if (response.status === 200) {
            // Atualiza o texto do select (opcional)
            this.value = newStatus; // Reafirma o status selecionado
        } else {
            alert('Erro ao alterar o status');
        }
    });
});
});

    </script>
</body>

</html>