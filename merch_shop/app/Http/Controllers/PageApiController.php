<?php

namespace App\Http\Controllers;
use App\Http\Resources\PageResources;
use App\Models\Page;
use App\OpenApi\Responses\ShowPagesResponse;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use App\OpenApi\Responses\ListPagesResponse;
use App\OpenApi\Responses\NotFoundResponse;
use App\Http\Controllers\Controller;

#[OpenApi\PathItem]
class PageApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Responseble
     */
    #[OpenApi\Operation(tags: ["page"])]
    #[OpenApi\Response(factory: ListPagesResponse::class, statusCode: 200)]
    public function index()
    {
        return PageResources::collection(
            Page::query()->paginate(5)
        );
    }
    /**
     * Display the specified resource.
     * @param string $slug
     * @return \Illuminate\Http\Responseble
     */
    #[OpenApi\Operation(tags: ["page"])]
    #[OpenApi\Response(factory: ShowPagesResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    public function show(string $slug)
    {
        return new PageResources(
            Page::query()->where('slug', $slug)->firstOrFail()
        );
    }
}