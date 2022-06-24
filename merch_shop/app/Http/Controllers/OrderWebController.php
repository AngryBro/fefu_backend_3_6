<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use Illuminate\Routing\Controller;
use App\Models\Cart;
use App\Models\Address;
use Illuminate\Support\Facades\Auth;

class OrderWebController extends Controller
{

    public function index()
    {
        return view('checkout', [
            'user' => Auth::user()
        ]);
    }

    public function store(StoreOrderRequest $request)
    {
        $address = null;
        if (!self::containsOnlyNull($request->input('delivery_address'))) {
            $address = Address::storeFromRequest($request);
        }

        //Не бейте, код контроллера спёр и мне стыдно за это.
        //Зато за курс немного понял как работает бэкэнд и написал
        //какашечку, если интересно то ниже ссылка
        // angrybro.sytes.net:8888 ; admin admin или user pass

        $cart = Cart::getOrCreateCart($request->user(), null);

        if ($cart->isEmpty()) {
            return back()->withErrors([
               '' => 'cart is empty'
            ]);
        }

        $cart->user_id = null;
        $cart->session_id = null;
        $cart->save();

        Order::storeFromRequest($request, $address, $cart);

        return redirect(route('profile'));
    }

    private function containsOnlyNull($input)
    {
        return empty(array_filter($input, function ($a) { return $a !== null;}));
    }
}
