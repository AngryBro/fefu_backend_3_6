<?php

namespace App\OpenApi\Responses;

use App\OpenApi\Schemas\NewsSchema;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Response;
use Vyuldashev\LaravelOpenApi\Factories\ResponseFactory;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema as ObjectsSchema;

class ShowNewsResponse extends ResponseFactory
{
    public function build(): Response
    {
        return Response::ok()->description('Successful response')->content(
            MediaType::json()->schema(ObjectsSchema::object()->properties(
                NewsSchema::ref('data')
            ))
        );
    }
}