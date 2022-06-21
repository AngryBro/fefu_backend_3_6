<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CatalogResources;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\OpenApi\Responses\CatalogResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\ShowCatalogResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class CatalogApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(tags: ["catalog"])]
    #[OpenApi\Response(factory: CatalogResponse::class, statusCode: 200)]
    public function index()
    {
        return CatalogResources::collection(
            ProductCategory::all()
        );
    }

    /**
     * Display the specified resource.
     * @param string $slug
     * @return \Illuminate\Http\Responseble
     */
    #[OpenApi\Operation(tags: ["catalog"])]
    #[OpenApi\Response(factory: ShowCatalogResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(string $slug){
        return new CatalogResources(
            ProductCategory::query()->where('slug', $slug)->firstOrFail()
        );
    }
}
