<?php
    // session_start();
    include_once('conect.php');

    // Verifique se o usuário está logado como administrador
    // if (!isset($_SESSION['email']) || $_SESSION['email'] !== 'admin@example.com') {
    //     header('Location: login.php');
    //     exit();
    // }

    $id = $_POST['id'];
    $status = $_POST['status'];

    $query = "UPDATE psicologos SET status = '$status' WHERE id = $id";
    $result = $conexao->query($query);

    if ($result) {
        echo 'success';
    } else {
        echo 'error';
    }
?>