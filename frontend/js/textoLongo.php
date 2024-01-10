<?php 

    // três pontos no excesso de texto
    function textoLongo(string $texto, int $limite = 200): string {
        if ($texto && strlen($texto) > $limite) {
            return substr($texto, 0, $limite) . '...';
        } else {
            return $texto;
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
?>