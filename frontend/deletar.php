<?php 
    if (!empty($_GET['id'])) {
        include_once('conect.php');

        $id = $_GET['id'];
        $sqlSel = "SELECT * FROM users WHERE id = $id";

        $result = $conexao -> query($sqlSel);

        if ($result -> num_rows > 0) {
            $sqlDel = "DELETE FROM users WHERE id=$id";
            $del = $conexao -> query($sqlDel);
        }
    }
    header('Location: sistema.php');
?>