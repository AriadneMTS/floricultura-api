<?php

use Carbon\Carbon;

function formatCnpjCpf($value)
{
  $CPF_LENGTH = 11;
  $cnpj_cpf = preg_replace("/\D/", '', $value);

  if (strlen($cnpj_cpf) === $CPF_LENGTH) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  }

  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function formatCreatedAt($value) {
    return Carbon::createFromTimeString($value)->setTimezone("America/Sao_Paulo")->format('d/m/Y H:i');
}

function formatNumberToBRL($value) {
    $numberFormatter = new NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
    return $numberFormatter->format( $value);
}
