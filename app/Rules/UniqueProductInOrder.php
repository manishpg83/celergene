<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class UniqueProductInOrder implements Rule
{
    private $orderDetails;

    public function __construct($orderDetails)
    {
        $this->orderDetails = $orderDetails;
    }

    public function passes($attribute, $value)
    {
        $selectedProductIds = array_column($this->orderDetails, 'product_id');
    
        if ($value == 1) {
            return true;
        }
    
        return count(array_keys($selectedProductIds, $value)) <= 1;
    }

    public function message()
    {
        return 'Duplicate product selected.';
    }
}
