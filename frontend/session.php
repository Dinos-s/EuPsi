<?php 
    session_start();

    if(isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])){
        include_once('conect.php');

        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $query = "SELECT * FROM pacientes WHERE email = '$email' AND senha = '$senha'";

        $result = $conexao->query($query);
        if(mysqli_num_rows($result) < 1){
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location: login.php');
            echo "Opa erro";

        }else{
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            header('Location: procuraPsi.html');
            echo "Opa erro";
        }

    } else {
        header('Location: login.php');
    }
?>