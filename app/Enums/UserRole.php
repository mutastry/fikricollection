<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case CASHIER = 'cashier';
    case EMPLOYEE = 'employee';
    case OWNER = 'owner';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Admin',
            self::CASHIER => 'Cashier',
            self::EMPLOYEE => 'Employee',
            self::OWNER => 'Owner',
        };
    }

    public function permissions(): array
    {
        return match ($this) {
            self::ADMIN => [
                'manage_songkets',
                'export_songkets',
                'view_dashboard',
                'manage_categories',
            ],
            self::CASHIER => [
                'manage_orders',
                'manage_payments',
                'export_orders',
                'export_payments',
                'view_dashboard',
            ],
            self::EMPLOYEE => [
                'view_songkets',
                'view_dashboard',
                'view_songket_details',
            ],
            self::OWNER => [
                'view_dashboard',
                'view_all_reports',
            ],
        };
    }

    public function canAccess(string $permission): bool
    {
        return in_array($permission, $this->permissions());
    }
}
