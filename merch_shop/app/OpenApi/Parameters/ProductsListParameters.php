<?php

namespace App\OpenApi\Parameters;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema as ObjectsSchema;
use Vyuldashev\LaravelOpenApi\Factories\ParametersFactory;

class ProductsListParameters extends ParametersFactory {
    /**
     * @return Parameter[]
     */
    public function build(): array {
        return [
            Parameter::query()
                ->name('category_slug')
                ->required(true)
                ->schema(ObjectsSchema::string()),
            Parameter::query()
                ->name('search_query')
                ->required(false)
                ->schema(ObjectsSchema::string()),
            Parameter::query()
                ->name('sort_mode')
                ->required(false)
                ->schema(ObjectsSchema::string()),
            Parameter::query()
                ->name('filters')
                ->required(false)
                ->schema(ObjectsSchema::array()),
            Parameter::query()
                ->name('filters.*')
                ->required(true)
                ->schema(ObjectsSchema::array())
        ];
    }
}
