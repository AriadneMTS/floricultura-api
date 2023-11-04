<?php

namespace App\Enums;

use stdClass;

enum PaymentMethods: string {
    case PIX = "Pix";
    case CREDIT_CARD = "Cartão de Crédito";
    case DEBIT_CARD = "Cartão de Débito";
    case MONEY = "Dinheiro";

    public static function fromValue(string $name): string {
        foreach (self::cases() as $method) {
            if($name === $method->name) {
                return $method->value;
            }
        }

        throw new \ValueError("$name not found");
    }

    public static function getPaymentMethods() {
        $all = array_map(function ($method) {
            $object = new stdClass();
            $object->name = $method->name;
            $object->value = $method->value;
            return $object;
        }, self::cases());
        return $all;
    }
}
