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
    public function index()
    {
        $categories = ProductCategory::query()
            ->with('children')
            ->where('parent_id')
            ->get();
        return view('catalog',['categories' => $categories]);
    }

}
