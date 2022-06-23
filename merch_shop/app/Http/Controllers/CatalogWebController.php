<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\CatalogFormRequest;
use Exception;

class CatalogWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $slug = null)
    {
        $query = ProductCategory::query()
            ->with('children','products');
        if($slug===null) {
            $query->where('parent_id');
        }
        else {
            $query->where('slug',$slug);
        }

        $categories = $query->get();
        $productQuery = ProductCategory::getTreeproductsBuilder($categories);

        // try{
        //     $productQuery = ProductCategory::getTreepro$productQueryBuilder($categories)
        //         ->orderBy('id')
        //         ->paginate();
        // }catch(Exception $exception) {
        //     abort(422, $exception->getMessage());
        // }

        $filters = ProductFilter::build($productQuery, $requestData['filters'] ?? []);
        ProductFilter::apply($productQuery, $requestData['filters'] ?? []);

        if (isset($requestData['search_query'])) {
            $productQuery->search($requestData['search_query']);
        }

        $sortMode = $requestData['sort_mode'] ?? null;
        if ($sortMode === 'price_asc') {
            $productQuery->orderBy('price');
        } else if ($sortMode === 'price_desc') {
            $productQuery->orderBy('price', 'desc');
        }

        return view('catalog', [
            'categories' => $categories,
            'products' => $productQuery->orderBy('products.id')->paginate(10),
            'filters' => $filters
        ]);
    }
}
