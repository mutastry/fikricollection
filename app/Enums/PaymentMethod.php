<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case BANK_TRANSFER = 'bank_transfer';
    case QRIS = 'qris';
    case E_WALLET = 'e_wallet';
    case PAY_IN_STORE = 'pay_in_store';

    public function label(): string
    {
        return match ($this) {
            self::BANK_TRANSFER     => 'Bank Transfer',
            self::QRIS              => 'QRIS',
            self::E_WALLET          => 'E-Wallet',
            self::PAY_IN_STORE      => 'Pay in Store',
        };
    }

    public function requiresProof(): bool
    {
        return match ($this) {
            self::BANK_TRANSFER     => true,
            self::QRIS              => true,
            self::E_WALLET          => true,
            self::PAY_IN_STORE      => false,
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::BANK_TRANSFER     => 'blue',
            self::QRIS              => 'red',
            self::E_WALLET          => 'green',
            self::PAY_IN_STORE      => 'purple',
        };
    }
}
