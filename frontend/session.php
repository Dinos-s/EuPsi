<?php 
  session_start();
  include_once('conect.php');

  if(isset($_POST['submit'])){

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    //validando email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      echo "E-mail invalido " . $email;
      header('location: login.php');
      exit;
    }

    // $tipo_usuario = $_POST["tipo_usuario"];

    // // Verificar as credenciais
    // if ($tipo_usuario == "psicologo") {
    //   $query = "SELECT * FROM psicologos WHERE email = '{$email}' ";
    // } else {
    //   $query = "SELECT * FROM pacientes WHERE email = '{$email}' ";
    // }

    $queryPa = "SELECT * FROM pacientes WHERE email = '{$email}'";
    $queryPsi = "SELECT * FROM psicologos WHERE email = '{$email}'";

    $resultPsi = $conexao -> query($queryPsi);
    $resultPa = $conexao -> query($queryPa);

    if ($resultPsi -> num_rows > 0) {
      $Psi = $resultPsi -> fetch_assoc();
      if (password_verify($senha, $Psi['senha'])) {
        $_SESSION['nome'] =  $Psi['nome'];
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $Psi['id'];
        header("Location: ../frontend/perfilPsi.php?id={$_SESSION['id']}");
      } else {
        header('Location: login.php');
      }

    } else if ($resultPa -> num_rows > 0) {
      $Pa = $resultPa -> fetch_assoc();
      if (password_verify($senha, $Pa['senha'])) {
        $_SESSION['nome'] = $Pa['nome'];
        $_SESSION['email'] = $email;
        $_SESSION['id'] = $Pa['id'];
        header('location: ../frontend/procuraPsi.php');
      } else {
        header('location: login.php');
      }
    }


  //   if (password_verify($senha, $user['senha'])) {
  //     $_SESSION['email'] = $email;
  //     $_SESSION['nome'] = $user['nome'];
  //     $_SESSION['id'] = $user['id'];
  //     // header('Location: procuraPsi.php');
  //     if ($tipo_usuario == "psicologo") {
  //       header("Location: ../frontend/perfilPsi.php?id={$_SESSION['id']}");
  //     } else if($tipo_usuario == "paciente") {
  //       header("Location: ../index.html");
  //     }
  //   } else {
  //     header('Location: login.php?erro=UserNotFound');
  //   }
  // } else {
  //   header('Location: login.php?erro=UserNotFound');
  }
?>