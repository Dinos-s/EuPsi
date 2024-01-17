<?php 
  // três pontos no excesso de texto
  function textoLongo(string $texto, int $limite = 200): string {
    if ($texto && strlen($texto) > $limite) {
      return substr($texto, 0, $limite) . '...';
    } else {
      return $texto;
    }
  }

  // função de validação do cpf
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

  // definindo Os dias da semana 
  function dia_da_semana($numero) {
    switch ($numero) {
      case 1:
        return "Segunda";
      case 2:
        return "Terça";
      case 3:
        return "Quarta";
      case 4:
        return "Quinta";
      case 5:
        return "Sexta";
      case 6:
        return "Sábado";
      case 7:
        return "Domingo";
      default:
        return "Dia inválido";
    }
  }

  function HorasMinutos($hora){
    $horas = substr($hora, 0, 2);
    $minutos = substr($hora, 3, 2);
    return "$horas:$minutos";
  }

  function consultarDados($conexao, $id, $dia, $hora){
    $sql = "SELECT * FROM hora_disponivel WHERE id_psicologo='$id' AND dia_semana='$dia' AND horario = '$hora'";
    $result = $conexao -> query($sql);
    
    if($result -> num_rows > 0) {
      while ($row = $result -> fetch_assoc()){
        // print_r($row);
        $horarios[] = array('dia' => $row['dia_semana'], 'horario' => $row['horario']);
        // echo $row['dia_semana'] . " " . HorasMinutos($row['horario']) . "\n";
        $checked = true;
      }
      return $checked;
    } else {
      return false;
    }
  }

  function apagarHora($conexao, $id, $dia, $hora){
    $sql = "DELETE FROM hora_disponivel WHERE id_psicologo = '$id' AND dia_semana = '$dia' AND horario = '$hora'";
    $result = $conexao -> query($sql);

    if ($result) {
      return true;
    } else {
      return false;
    }
  }
?>