<?php

namespace App\OpenApi\Body;

use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class CartModificationRequestFormData extends RequestBodyFactory
{
    public function build(): RequestBody
    {
        return RequestBody::create()
            ->required()
            ->description('Cart modification')
            ->content(MediaType::json()->schema(
                Schema::object()->properties(
                    Schema::array('modifications')->items(
                        Schema::object()->properties(
                            Schema::integer('product_id'),
                            Schema::integer('quantity')
                        )
                    )
                )
            ));
    }
}
