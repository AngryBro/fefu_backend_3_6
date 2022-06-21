<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\CatalogSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use App\OpenApi\Schemas\PaginatorLinksSchema;
use App\OpenApi\Schemas\PaginatorMetaSchema;

class CatalogResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(
                Schema::object()->properties(
                    Schema::array('data')->items(CatalogSchema::ref()),
                )
            )
        );
    }
}
