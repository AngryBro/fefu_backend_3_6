<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Resources\ListProductsResources;
use App\Http\Resources\DetailedProductResources;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use App\OpenApi\Parameters\ProductsListParameters;
use App\OpenApi\Parameters\ProductDetailsParameters;
use App\OpenApi\Responses\ProductsListResponse;
use App\Http\Filters\ProductFilter;
use App\OpenApi\Responses\ErrorValidationResponse;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Exception;
use App\Models\Product;
use App\OpenApi\Responses\ErrorCatalogResponse;
use App\OpenApi\Responses\ProductResponse;
use App\OpenApi\Responses\NotFoundResponse;

#[OpenApi\PathItem]
class ProductApiController extends Controller
{
    /**
     * Returning a list of products by slug.
     *
     * @return \Illuminate\Http\Responseble
     */
    #[OpenApi\Operation(tags: ["catalog"])]
    #[OpenApi\Response(factory: ProductsListResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ErrorCatalogResponse::class, statusCode: 422)]
    #[OpenApi\Parameters(factory: ProductsListParameters::class)]
    public function index(Request $request) {
        $slug = $request->query('category_slug');
        $query = ProductCategory::query()->with('children', 'products');

        if ($slug === null) {
            $query->where('parent_id');
        } else {
            $query->where('slug', $slug);
        }

        $categories = $query->get();

        try{
            $products = ProductCategory::getTreeProductsBuilder($categories)
                ->orderBy('id')
                ->paginate();
        }catch(Exception $exception) {
            return response()->json([
                'message' => 'Error',
                'errors' => [$exception->getMessage()],
            ], 422);
        }

        $appliedFilters = $requestData['filters'] ?? [];
        ProductFilter::apply($query, $appliedFilters);

        if (isset($requestData['search_query'])) {
            $products->search($requestData['search_query']);
        }

        $sortMode = $requestData['sort_mode'] ?? null;
        if ($sortMode === 'price_asc') {
            $products->orderBy('price');
        } else if ($sortMode === 'price_desc') {
            $products->orderBy('price', 'desc');
        }

        return ListProductsResources::collection($products);
    }
    /**
     * Returning a product resource by the requested slug
     *
     * @return \Illuminate\Http\Response
     */
    #[OpenApi\Operation(tags: ["catalog"])]
    #[OpenApi\Response(factory: ProductResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: NotFoundResponse::class, statusCode: 404)]
    #[OpenApi\Parameters(factory: ProductDetailsParameters::class)]
    public function show(Request $request) {
        $slug = $request->query('product_slug');
        return new DetailedProductResources(
            Product::query()
                ->with('productCategory', 'sortedAttributeValues.productAttribute')
                ->where('slug', $slug)
                ->firstOrFail()
        );
    }
}
