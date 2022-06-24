<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartModificationRequest;
use App\Http\Resources\CartResource;
use Illuminate\Http\Request;
use App\OpenApi\Responses\CartResponse;
use Illuminate\Routing\Controller;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;
use App\Models\Product;
use App\OpenApi\Body\CartModificationRequestFormData;
use App\OpenApi\Responses\ErrorCartModificationResponse;

#[OpenApi\PathItem]
class CartApiController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  CartModificationRequest  $request
     * @return CartResource
     */

    #[OpenApi\RequestBody(factory: CartModificationRequestFormData::class)]
    #[OpenApi\Response(factory: CartResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: ErrorCartModificationResponse::class, statusCode: 422)]
    #[OpenApi\Operation(tags: ['cart'], method: 'POST')]
    public function __invoke(CartModificationRequest $request)
    {
        $data = $request->validated('modifications');

        $user = Auth::user();
        $sessionId = session()->getId();
        $cart = Cart::getOrCreateCart($user, $sessionId);

        $productIds = array_column($data, 'product_id');
        $productsById = Product::whereIn($productIds)->get()->keyBy('id');

        foreach ($data as $modification)
        {
            $cart->setProductQuantity($productsById[$modification['product_id']], $modification['quantity']);
        }
        $cart->recalculateCart();
        $cart->save();

        return new CartResource($cart);
    }
}
