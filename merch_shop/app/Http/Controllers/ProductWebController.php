<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Product;
use function view;

class ProductWebController extends Controller
{
    public function index($slug)
    {
        $product = Product::query()
            ->with('productCategory', 'sortedAttributeValues.productAttribute')
            ->where('slug', $slug)
            ->first();
        if ($product === null){
            abort(404);
        }

        return view('productIndex', ['product' => $product]);
    }
}
