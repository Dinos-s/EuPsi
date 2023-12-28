<?php 
    session_start();
    
    include_once('conect.php');

    $query = "SELECT * FROM psicologos WHERE status='A' ORDER BY id";

    $result = $conexao->query($query);

    // print_r($_SESSION);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="./assets/eupsi.png">

    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="./style/cards.css">
    <link rel="stylesheet" href="./style/calendar.css">
    <title>Procura Psicólogo - EuPSICO(protótipo)</title>

</head>

<body>
    <header>
        <!-- LOGO -->
        <a href="./index.html" class="logo">
            <img src="./assets/eupsi.png" alt="teste" class="logoIndex">
        </a>

        <!-- MENU -->
        <nav>
            <ul class="menu">
                <li><a href="./index.html">início</a></li>
                <li><a class="active" href="./procuraPsi.php">procurar psicólogo</a></li>
                <li><a href="#">plano psicologo</a></li>
                <li><a href="./contato.html">contato</a></li>
                <?php 
                    if($_SESSION['tipo_user'] == 'Ad'){
                        echo '<li><a href="./admin.php">Admin</a></li>';
                    }

                    $loggedInUserId = $_SESSION['id'];
                    if ($_SESSION['tipo_user'] == 'Co' && $_SESSION['tipo_usuario'] == 'psicologo') {
                        echo "<li><a href='./perfilPsi.php?id=$loggedInUserId'>Perfil</a></li>";
                    }
                ?>
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
        <div class="card-Container">
            <!-- card modelo -->
            <!-- <div class="card">
                <div class="background">
                    <!- <img src="./assets/paisagem.jpg" alt="background"> ->
                </div>
                <div class="avatar">
                    <img src="./assets/images.jpg" alt="picture">
                </div>
                <div class="content">
                    <h4 class="perfil">Gabriel de Matos Ramos</h4>
                    <p class="especialidade">Psícologo Infantil</p>
                    <p class="crp">23579 / CRP - 4° Região</p>
                    <section class="regular">
                        <p class="cidade">Recife - PE</p>
                        <p><span class="price">R$ 90</span>/ 50 min</p>
                    </section>
                </div>
                <div class="calendar">
                    <div class="wrapper">
                        <table id="DiasSemana">
                            <tr id="dayRow"></tr>
                            <tr id="dateRow"></tr>
                        </table>



                        <div id="teste">
                            <table class="horas-scroll">
                                <tr id="colunasHora">
                                    <td id="horaColumn1"></td>
                                    <td id="horaColumn2"></td>
                                    <td id="horaColumn3"></td>
                                    <td id="horaColumn4"></td>
                                    <td id="horaColumn5"></td>
                                    <td id="horaColumn6"></td>
                                    <td id="horaColumn7"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div> -->

            <?php while($psicologo = $result->fetch_assoc()): ?>

                <div class="card">
                    <div class="background"></div>
                    <div class="card_superior">
                        <div class="lado1">
                            <div class="avatar"><img src="<?php echo $psicologo["photo_perfil"]?>" alt="picture"></div>
                            <div class="content">
                                <h4 class="perfil"><?php echo $psicologo["nome"]?></h4>
                                <p class="especialidade"><?php echo $psicologo["especialidade"]?></p>
                                <p class="crp"><?php echo $psicologo["crp"]?> | CRP - 4° Região</p>
                                <section class="regular">
                                    <p class="cidade"><?php echo $psicologo["localidade"]; ?></p>
                                    <p><span class="price">R$ <?php echo $psicologo["valorsessao"]; ?></span>/<?php echo $psicologo["temposessao"]?> min</p>
                                </section>
                            </div>
                        </div>
                        <div class="lado2">
                            <div class="calendar">
                                <div class="wrapper">
                                    <table id="DiasSemana">
                                        <tr class="linhaTitulo">
                                            <td colspan="7">Horários Disponíveis</td>
                                        </tr>
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
                    </div>
                    <div class="card_inferior">
                        <p class="resumo"><?php echo $psicologo["resumo"]?>
                        <!-- <button class="sobreBTN" onclick="window.location.href='agendamento.html?psi=<?php echo urlencode($psicologo["nome"]) ?>' ">Saber Mais...</button> -->
                        <button class="sobreBTN" onclick="window.location.href='agendamento.php?psi=<?php echo urlencode($psicologo["nome"]); ?>&id=<?php echo $psicologo["id"]; ?>'">Saber Mais...</button>
                        </p>
                    </div>
                </div>
            <?php endwhile; ?>
            <!-- <div class="card">
                <div class="background"></div>
                <div class="card_superior">
                    <div class="lado1">
                        <div class="avatar"><img src="<?php echo $psicologo["photo_perfil"]?>" alt="picture"></div>
                        <div class="content">
                            <h4 class="perfil"><?php echo $psicologo["nome"]?></h4>
                            <p class="especialidade"><?php echo $psicologo["especialidade"]?></p>
                            <p class="crp"><?php echo $psicologo["crp"]?> | CRP - 4° Região</p>
                            <section class="regular">
                                <p class="cidade"><?php echo $psicologo["localidade"]; ?></p>
                                <p><span class="price">R$ <?php echo $psicologo["valorsessao"]; ?></span>/50 min</p>
                            </section>
                        </div>
                    </div>
                    <div class="lado2">
                        <div class="calendar">
                            <div class="wrapper">
                                <table id="DiasSemana">
                                    <tr class="linhaTitulo">
                                        <td colspan="7">Horários Disponíveis</td>
                                    </tr>
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
                                            <td class="horaColumn1">
                                                <ul class="hora-list">
                                                    <li><button class="hora-button">07:00</button></li>
                                                    <li><button class="hora-button">07:30</button></li>
                                                    <li><button class="hora-button">08:00</button></li>
                                                    <li><button class="hora-button">08:30</button></li>
                                                    <li><button class="hora-button">09:00</button></li>
                                                    <li><button class="hora-button">09:30</button></li>
                                                    <li><button class="hora-button">10:00</button></li>
                                                    <li><button class="hora-button">10:30</button></li>
                                                    <li><button class="hora-button">11:00</button></li>
                                                    <li><button class="hora-button">11:30</button></li>
                                                    <li><button class="hora-button">12:00</button></li>
                                                    <li><button class="hora-button">12:30</button></li>
                                                    <li><button class="hora-button">13:00</button></li>
                                                    <li><button class="hora-button">13:30</button></li>
                                                    <li><button class="hora-button">14:00</button></li>
                                                    <li><button class="hora-button">14:30</button></li>
                                                    <li><button class="hora-button">15:00</button></li>
                                                    <li><button class="hora-button">15:30</button></li>
                                                    <li><button class="hora-button">16:00</button></li>
                                                    <li><button class="hora-button">16:30</button></li>
                                                    <li><button class="hora-button">17:00</button></li>
                                                    <li><button class="hora-button">17:30</button></li>
                                                    <li><button class="hora-button">18:00</button></li>
                                                    <li><button class="hora-button">18:30</button></li>
                                                    <li><button class="hora-button">19:00</button></li>
                                                    <li><button class="hora-button">19:30</button></li>
                                                    <li><button class="hora-button">20:00</button></li>
                                                    <li><button class="hora-button">20:30</button></li>
                                                    <li><button class="hora-button">21:00</button></li>
                                                    <li><button class="hora-button">21:30</button></li>
                                                </ul>
                                            </td>
                                            <td class="horaColumn2">
                                                <ul class="hora-list">
                                                    <li><button class="hora-button">07:00</button></li>
                                                    <li><button class="hora-button">07:30</button></li>
                                                    <li><button class="hora-button">08:00</button></li>
                                                    <li><button class="hora-button">08:30</button></li>
                                                    <li><button class="hora-button">09:00</button></li>
                                                    <li><button class="hora-button">09:30</button></li>
                                                    <li><button class="hora-button">10:00</button></li>
                                                    <li><button class="hora-button">10:30</button></li>
                                                    <li><button class="hora-button">11:00</button></li>
                                                    <li><button class="hora-button">11:30</button></li>
                                                    <li><button class="hora-button">12:00</button></li>
                                                    <li><button class="hora-button">12:30</button></li>
                                                    <li><button class="hora-button">13:00</button></li>
                                                    <li><button class="hora-button">13:30</button></li>
                                                    <li><button class="hora-button">14:00</button></li>
                                                    <li><button class="hora-button">14:30</button></li>
                                                    <li><button class="hora-button">15:00</button></li>
                                                    <li><button class="hora-button">15:30</button></li>
                                                    <li><button class="hora-button">16:00</button></li>
                                                    <li><button class="hora-button">16:30</button></li>
                                                    <li><button class="hora-button">17:00</button></li>
                                                    <li><button class="hora-button">17:30</button></li>
                                                    <li><button class="hora-button">18:00</button></li>
                                                    <li><button class="hora-button">18:30</button></li>
                                                    <li><button class="hora-button">19:00</button></li>
                                                    <li><button class="hora-button">19:30</button></li>
                                                    <li><button class="hora-button">20:00</button></li>
                                                    <li><button class="hora-button">20:30</button></li>
                                                    <li><button class="hora-button">21:00</button></li>
                                                    <li><button class="hora-button">21:30</button></li>
                                                </ul>
                                            </td>                                            
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card_inferior">
                    <p class="resumo"><?php echo $psicologo["resumo"]?>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem
                        Ipsum has been the industry's standard It has survived not only five centuries, but also the
                        leap into electronic type...<button class="sobreBTN">Saber Mais...</button></p>
                </div>
            </div> -->
        </div>
    </main>

    <!-- JANELA MODAL DE CADASTRAO -->
    <div id="id_janela_modal" class = 'janela_modal'>
        <div class="modal_conteiner">
            <h3>Olá! Bem vindo ao nosso cadastro.</h3>
            <h5>Em qual das opções você se encaixa?</h5>

            <!-- Duas ANCORAS estao com as mesmas class -->
            <a href="./CadPaciente.php" 
               class="janela_modal_cliente">
                 <img src="https://assets-global.website-files.com/613f7ca80295647d415b0d85/629f7441846001e38b41cc31_user.svg" 
                    loading="lazy" 
                    alt="" 
                    class="janela_modal_cliente_icons">
                      <div class="janela_modal_cliente_titulo">Cliente</div>
                      <div class="janela_modal_cliente_frase">Quero fazer sessões de terapias e ver conteúdos sobre saúde emocional</div>
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

    <script src="./js/script.js"></script>
</body>

</html>