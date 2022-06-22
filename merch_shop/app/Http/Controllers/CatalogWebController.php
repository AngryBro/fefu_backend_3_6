<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CatalogWebController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug=null)
    {
        $categories = ProductCategory::query()
            ->with('children','products');
            if($slug===null) {
                $categories->where('parent_id');
            }
            else {
                $categories->where('slug',$slug);
            }

            $categories = $categories->get();

        $products = ProductCategory::getTreeProductsBuilder($categories)
            ->orderBy('id')
            ->paginate();

        return view('catalog',[
            'categories' => $categories,
            'products' => $products
    ]);
    }

}
