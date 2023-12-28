<?php
    include_once('conect.php');

    // Recupera os parâmetros da URL
    $paramURL = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);
    parse_str($paramURL, $params);  // Transforma a string em um array associativo

    $psiNome = $params['psi'];
    $idPsicologo = $params['id'];

    $query = "SELECT * FROM psicologos WHERE nome='{$psiNome}' AND id='{$idPsicologo}'";

    $result = $conexao->query($query);

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
            $aborda = $userData['abordagem'];
        }
    }
    $abordaId = explode(";", $aborda);

    $queryAbodargem = "SELECT * FROM abordagem WHERE id IN ('" . implode("','", $abordaId) . "')";
    $resAbodar = $conexao -> query($queryAbodargem);
    
    if ($resAbodar -> num_rows > 0) {
        while ($abordagemData = $resAbodar -> fetch_assoc()) {
            $abordaNome[] = $abordagemData['nome'];
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
    <link rel="stylesheet" href="./style/calendar.css">
    <link rel="stylesheet" href="./style/Agendamento.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- incones -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <title>Agendamento</title>
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
                <li><a class="active" href="./procuraPsi.php">procurar psicólogo</a></li>
                <li><a href="#">plano psicologo</a></li>
                <li><a href="./contato.html">contato</a></li>
            </ul>
        </nav>

        <div class="acesso">
            <li><a href="./login.html">Entrar</a></li>
            <!-- <li><a href="CadPaciente.html">Cadastro</a></li> -->
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
        <a href="./procuraPsi.php" class="voltar">
            <i class="fa fa-arrow-left-long"></i>
        </a>
        <div class="agendamento">
            <div class="user">
                <img class="avatar" src="<?php echo $foto ?>" alt="psicologo">
                <section class="info">
                    <h2><?php echo $nome ?></h2>
                    <p>CRP: <span class="crp"><?php echo $crp?></span> | <span class="city"><?php echo $localidade?></span></p>
                    <p><span class="price">R$ 30</span>/ 50 min</p>
                </section>
            </div>
            <div class="calendar">
                <div class="wrapper">
                    <table id="DiasSemana">
                        <!-- <tr class="linhaTitulo">
                            <td colspan="7">Horários Disponíveis</td>
                        </tr> -->
                        <tr id="dayRow">
                            <td class="dia">dom.</td>
                            <td class="dia">seg.</td>
                            <td class="dia">ter.</td>
                            <td class="dia">qua.</td>
                            <td class="dia">qui.</td>
                            <td class="dia">sex.</td>
                            <td class="dia">sáb.</td>
                        </tr>
                    </table>
                    <div class="colunaTempo">
                        <table class="horas-scroll">
                            <tr>
                                <?php
                                    // Gera 7 colunas
                                    for ($i = 1; $i <= 7; $i++) {
                                    echo '<td class="horaColumn' . $i . '">
                                        <ul class="hora-list">
                                        </ul>
                                    </td>';
                                    }
                                ?>                                              
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="saberMais">
                <div class="descPessoal">
                    <h3>Descrição Pessoal</h3>
                    <p class="resumo"><?php echo $resumo?></p>
                </div>
                <div class="maisInfos">
                    <h3>Experiência</h3>
                    <ul class="softskills">
                        <li class="experiencias">Psicanalista</li>
                        <li class="experiencias">Depressão</li>
                    </ul>
                </div>
                <div class="maisInfos">
                    <h3>Especialidade</h3>
                    <ul class="especialidades softskills">
                        <li class="experiencias">Psicoligia</li>
                        <li class="experiencias">Pedriata</li>
                    </ul>
                </div>
                <div class="maisInfos">
                    <h3>Abordagens</h3>
                    
                    <ul class="abordar softskills">
                        <?php foreach($abordaNome as $a) { ?>
                        <li class="experiencias"><?php echo $a?></li>
                        <!-- <li class="experiencias">PSICOLOGIA ANALÍTICA</li>
                        <li class="experiencias">PSICOLOGIA HUMANISTA</li> -->
                        <?php }?>
                    </ul>
                    
                </div>
                <div class="maisInfos">
                    <h3>Formação</h3>
                    <ul class="diploma softskills">
                        <li class="experiencias">
                            <h2 class="title">Psicologia</h2>
                            <h3>Universidade da Saúde Mental</h3>
                            <p class="period">02/2013</p>
                            <p>Bacharelado</p>
                        </li>
                    </ul>
                </div>
            </div>
    </main>

    <!-- JANELA MODAL DE CADASTRAO -->
    <div id="id_janela_modal" class = 'janela_modal'>
        <div class="modal_conteiner">
            <h3>Olá! Bem vindo ao nosso cadastro.</h3>
            <h5>Em qual das opções você se encaixa?</h5>

            <!-- Duas ANCORAS estao com as mesmas class -->
            <a href="./CadPaciente.html" 
               class="janela_modal_cliente">
                 <img src="https://assets-global.website-files.com/613f7ca80295647d415b0d85/629f7441846001e38b41cc31_user.svg" 
                    loading="lazy" 
                    alt="" 
                    class="janela_modal_cliente_icons">
                      <div class="janela_modal_cliente_titulo">Cliente</div>
                      <div class="janela_modal_cliente_frase">Quero fazer sessões de terapias e ver conteúdos sobre saúde emocional</div>
            </a>

            <a href="./CadPsicologo.html" class="janela_modal_cliente">
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
            <p>footer 2</p>
            <!-- <p>Eupsi é um Buscador de Psicólogos e Clientes para Terapia Online e Presencial e oferece aos seus usuários o melhor método para encontrar o profissional ideal para sua necessidade. Possuindo um catálogo completo e profissionais experientes e certificados, seu uso será a solução ideal para qualquer dúvida relacionada aos serviços de terapia. Nossos profissionais são especialistas capacitados para lidar com as diversas áreas da psicologia, garantindo assim a melhor terapia para você.</p> -->
        </section>

        <section class="f3">
            <ul class="menuf">
                <li>Menu</li>
                <li><a href="./index.html">início</a></li>
                <li><a class="active" href="./procuraPsi.php">procurar psicólogo</a></li>
                <li><a href="#">plano psicologo</a></li>
                <li><a href="./contato.html">contato</a></li>
            </ul>
        </section>
    </footer>
    
    <script src="./js/script.js"></script>
</body>

</html>

<!--  -->