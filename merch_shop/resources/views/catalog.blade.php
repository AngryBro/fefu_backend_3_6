<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Каталог</title>
    </head>
    <body>
        <form method="GET">
            <div>
                <label for="search_query">Поиск</label>
                <input type="text" name="search_query" value="{{ request('search_query') }}">
            </div>
            <div>
                <label for="sort_mode">Сортировка по</label>
                <select name="sort_mode">
                    <option value="price_asc" {{ request('sort_mode') === 'price_asc' ? 'selected' : '' }}>возрастанию цены</option>
                    <option value="price_desc" {{ request('sort_mode') === 'price_desc' ? 'selected' : '' }}>убыванию цены</option>
                </select>
            </div>
            @foreach($filters as $filter)
                <div>
                    <h4>{{ $filter->name }}</h4>
                    @foreach($filter->options as $option)
                        <div>
                            <label>
                                <input type="checkbox" value="{{ $option->value }}"
                                name="filters[{{ $filter->key }}][]" {{ $option->isSelected ? 'checked' : ''}}>
                                {{ $option->value }} ({{ $option->productCount }})
                            </label>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <button>Применить</button>
            </form>
        <div>
            Каталог
            @include('catalogList', ['categories', $categories])
            @foreach ($products as $product)
            <article>
                <a href="{{ route('product', $product->slug) }}">
                    <h3>{{ $product->name }}</h3>
                </a>
                <p>{{ $product->price }} руб.</p>
            </article>
            @endforeach
            {{ $products->links() }}
        </div>
    </body>
</html>
