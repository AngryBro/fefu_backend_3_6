<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkout</title>
</head>
<body>
<h1>Checkout</h1>
<form method="POST" action="{{{ route('checkout.post') }}}">
    @csrf
    <div>
        <label>Имя</label>
        <input type="text" name="customer_name" value="{{$user->name}}" maxlength="100"/>
        @error('customer_name')
        <div>{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label>Email</label>
        <input type="text" name="customer_email" value="{{$user->email}}" maxlength="100"/>
        @error('customer_email')
        <div>{{ $message }}</div>
        @enderror
    </div>
    <div>
        <label>Тип получения</label>
        <select name="delivery_type" id="delivery_type">
            <option value="courier">Курьер</option>
            <option value="pickup">Самовывоз</option>
        </select>
        @error('delivery_type')
        <div>{{ $message }}</div>
        @enderror
    </div>
    <div>
        <div>
            <label>Город</label>
            <input name="delivery_address[city]" id="delivery_address_city">
            @error('delivery_address.city')
            <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Улица</label>
            <input name="delivery_address[street]" id="delivery_address_street">
            @error('delivery_address.street')
            <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Дом</label>
            <input name="delivery_address[house]" id="delivery_address_house">
            @error('delivery_address.house')
            <div>{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label>Квартира/офис</label>
            <input name="delivery_address[apartment]" id="delivery_address_apartment">
            @error('delivery_address.apartment')
            <div>{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div>
        <label>Способ оплаты</label>
        <select name="payment_method" id="payment_method">
            <option value="card">Картой</option>
            <option value="cash">Наличными</option>
        </select>
        @error('payment_method')
        <div>{{ $message }}</div>
        @enderror
    </div>
    <div>
        <button>Отправить</button>
    </div>
    @error('')
    <div>{{ $message }}</div>
    @enderror
</form>
</body>
</html>
