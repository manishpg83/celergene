<?php
namespace App\Enums;

enum OrderWorkflowType: string 
{
    case STANDARD = 'standard';
    case MULTI_DELIVERY = 'multi_delivery';
    case CONSIGNMENT = 'consignment';

    public function label(): string 
    {
        return match($this) {
            self::STANDARD => 'Standard Order',
            self::MULTI_DELIVERY => 'Multiple Delivery Order',
            self::CONSIGNMENT => 'Multiple Invoice Order'
        };
    }

    public static function options(): array 
    {
        return [
            self::STANDARD->value => self::STANDARD->label(),
            self::MULTI_DELIVERY->value => self::MULTI_DELIVERY->label(),
            self::CONSIGNMENT->value => self::CONSIGNMENT->label()
        ];
    }
}