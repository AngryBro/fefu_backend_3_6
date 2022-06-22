<?php

namespace App\OpenApi\Responses;

use App\Models\ProductCategory;
use App\OpenApi\Schemas\CatalogSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema as ObjectsSchema;
use Illuminate\Support\Facades\Schema;


class ShowCatalogResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(ObjectsSchema::object()->properties(
                CatalogSchema::ref('data')
            ))
        );
    }
}
