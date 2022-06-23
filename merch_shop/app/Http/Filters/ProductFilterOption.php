<?php

namespace App\Http\Filters;
use Laravel\Sail\Console\PublishCommand;

class ProductFilterOption
{
    public $value;
    public bool $isSelected;
    public int $productCount;

    public function __construct($value, $isSelected, $productCount)
    {
        $this->value = $value;
        $this->isSelected = $isSelected;
        $this->productCount = $productCount;
    }
}
