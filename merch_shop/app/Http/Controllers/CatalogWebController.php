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
    public function index(?string $slug)
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

            try{
                $products = ProductCategory::getTreeProductsBuilder($categories)
                    ->orderBy('id')
                    ->paginate();
            }catch(Exception $exception) {
                abort(422, $exception->getMessage());
            }

        return view('catalog',[
            'categories' => $categories,
            'products' => $products
    ]);
    }

}
