<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Payment;

class StatusCanBeChanged implements ValidationRule
{
    protected $currentStatus;
    protected $statusType;

    public function __construct($currentStatus, $statusType = 'order')
    {
        $this->currentStatus = $currentStatus;
        $this->statusType = $statusType;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->statusType === 'order') {
            $this->validateOrderStatus($value, $fail);
        } elseif ($this->statusType === 'payment') {
            $this->validatePaymentStatus($value, $fail);
        }
    }

    protected function validateOrderStatus($newStatus, Closure $fail): void
    {
        $allowedTransitions = [
            OrderStatus::PENDING_PAYMENT->value => [],
            OrderStatus::READY_FOR_PICKUP->value => [
                OrderStatus::PENDING_PAYMENT->value,
                OrderStatus::CANCELLED->value,
                OrderStatus::COMPLETED->value,
            ],
            OrderStatus::COMPLETED->value => [
                // No transitions allowed from completed
            ],
            OrderStatus::CANCELLED->value => [
                // No transitions allowed from cancelled
            ],
            OrderStatus::PENDING->value => [
                OrderStatus::CANCELLED->value
            ]
        ];

        $currentStatusValue = $this->currentStatus instanceof OrderStatus
            ? $this->currentStatus->value
            : $this->currentStatus;

        // If trying to set the same status, allow it
        if ($currentStatusValue === $newStatus) {
            return;
        }

        // Check if the transition is allowed
        if (
            !isset($allowedTransitions[$currentStatusValue]) ||
            !in_array($newStatus, $allowedTransitions[$currentStatusValue])
        ) {

            $currentLabel = OrderStatus::tryFrom($currentStatusValue)
                ? OrderStatus::from($currentStatusValue)->label()
                : $currentStatusValue;
            $newLabel = OrderStatus::tryFrom($newStatus)
                ? OrderStatus::from($newStatus)->label()
                : $newStatus;

            $fail("Status pesanan tidak dapat diubah dari '{$currentLabel}' ke '{$newLabel}'.");
        }
    }

    protected function validatePaymentStatus($newStatus, Closure $fail): void
    {
        $allowedTransitions = [
            PaymentStatus::PENDING->value => [
                PaymentStatus::WAITING_VERIFICATION->value,
                PaymentStatus::FAILED->value,
            ],
            PaymentStatus::WAITING_VERIFICATION->value => [
                PaymentStatus::VERIFIED->value,
            ],
            PaymentStatus::FAILED->value => [],
            PaymentStatus::VERIFIED->value => [
                PaymentStatus::WAITING_VERIFICATION->value,
            ],
        ];

        $currentStatusValue = $this->currentStatus instanceof PaymentStatus
            ? $this->currentStatus->value
            : $this->currentStatus;

        // If trying to set the same status, allow it
        if ($currentStatusValue === $newStatus) {
            return;
        }

        // Check if the transition is allowed
        if (
            !isset($allowedTransitions[$currentStatusValue]) ||
            !in_array($newStatus, $allowedTransitions[$currentStatusValue])
        ) {

            $currentLabel = PaymentStatus::tryFrom($currentStatusValue)
                ? PaymentStatus::from($currentStatusValue)->label()
                : $currentStatusValue;
            $newLabel = PaymentStatus::tryFrom($newStatus)
                ? PaymentStatus::from($newStatus)->label()
                : $newStatus;

            $fail("Status pembayaran tidak dapat diubah dari '{$currentLabel}' ke '{$newLabel}'.");
        }
    }

    /**
     * Get allowed transitions for a given status
     */
    public static function getAllowedTransitions($currentStatus, $statusType = 'order'): array
    {
        $rule = new self($currentStatus, $statusType);

        if ($statusType === 'order') {
            $allowedTransitions = [
                OrderStatus::PENDING_PAYMENT->value => [],
                OrderStatus::READY_FOR_PICKUP->value => [
                    OrderStatus::COMPLETED->value,
                    OrderStatus::CANCELLED->value,
                ],
                OrderStatus::COMPLETED->value => [],
                OrderStatus::CANCELLED->value => [],
                OrderStatus::PENDING->value => [
                    OrderStatus::CANCELLED->value
                ],
            ];
        } else {
            $allowedTransitions = [
                PaymentStatus::PENDING->value => [
                    PaymentStatus::WAITING_VERIFICATION->value,
                    PaymentStatus::FAILED->value,
                ],
                PaymentStatus::WAITING_VERIFICATION->value => [
                    PaymentStatus::VERIFIED->value,
                ],
                PaymentStatus::FAILED->value => [],
                PaymentStatus::VERIFIED->value => [
                    PaymentStatus::WAITING_VERIFICATION->value,
                ],
            ];
        }

        $currentStatusValue = $currentStatus instanceof \BackedEnum
            ? $currentStatus->value
            : $currentStatus;

        return $allowedTransitions[$currentStatusValue] ?? [];
    }
}
