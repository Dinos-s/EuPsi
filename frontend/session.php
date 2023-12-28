<?php 
  session_start();

  if(isset($_POST['submit'])){
    include_once('conect.php');

    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $tipo_usuario = $_POST["tipo_usuario"];

    // Verificar as credenciais
    if ($tipo_usuario == "psicologo") {
      $query = "SELECT * FROM psicologos WHERE email = '{$email}' ";
    } else {
      $query = "SELECT * FROM pacientes WHERE email = '{$email}' ";
    }

    // $query = "SELECT * FROM pacientes WHERE email = '$email'";

    $result = $conexao -> query($query);
    $user = $result -> fetch_assoc();

    if (password_verify($senha, $user['senha'])) {
      $_SESSION['email'] = $email;
      $_SESSION['nome'] = $user['nome'];
      $_SESSION['id'] = $user['id'];
      // header('Location: procuraPsi.php');
      if ($tipo_usuario == "psicologo") {
        header("Location: ../frontend/perfilPsi.php?id={$_SESSION['id']}");
      } else if($tipo_usuario == "paciente") {
        header("Location: ../index.html");
      }
    } else {
      header('Location: login.php?erro=UserNotFound');
    }
  } else {
    header('Location: login.php?erro=UserNotFound');
  }
?>

<!-- <?php

// Conexão com o banco de dados
include_once('conect.php');

// Obter as credenciais do formulário
$email = $_POST["email"];
$senha = $_POST["senha"];
$tipo_usuario = $_POST["tipo_usuario"];

// Verificar as credenciais
if ($tipo_usuario == "psicologo") {
  $sql = "SELECT * FROM psicologos WHERE email = '{$email}' AND senha = '{$senha}'";
} else {
  $sql = "SELECT * FROM pacientes WHERE email = '{$email}' AND senha = '{$senha}'";
}
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

// Se as credenciais forem válidas, autenticar o usuário
if ($row) {
  // Autenticação bem-sucedida
  session_start();
  $_SESSION["tipo_usuario"] = $tipo_usuario;


  // Redirecionar o usuário para a página apropriada
  if ($tipo_usuario == "psicologo") {
    header("Location: ../frontend/perfilPsi.php");
  } else {
    header("Location: ../index.html");
  }
} else {
  // E-mail ou senha inválidos.
  echo "E-mail ou senha inválidos.";
}

?> -->