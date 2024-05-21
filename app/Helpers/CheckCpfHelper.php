<?php

namespace App\Helpers;

class CheckCpfHelper
{

    public static function check($cpf): bool
    {

        $cpf = preg_replace('/[^0-9]/is', '', $cpf);

        if (strlen($cpf) != 11) {
            return false;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public static function onlyNumbers($cpf)
    {
        return str_replace(".", "", str_replace("-", "", $cpf));
    }

    public static function mask($cpf)
    {
        // Remove qualquer caractere não numérico
        $cpf = preg_replace("/\D/", "", $cpf);
        // Formata o CPF com pontos e hífen
        $cpf = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $cpf);
        return $cpf;
    }
}
