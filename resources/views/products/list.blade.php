@foreach($products as $product)
    <div>{{ $product->name }} - {{ $product->price }}</div>
@endforeach
<a href="{{ route('products.create') }}">Add new product</a>

<form method="GET" action="{{ route('products') }}">
    <input type="text" name="search" placeholder="Search...">
    <input type="number" name="min_price" placeholder="Min Price">
    <input type="number" name="max_price" placeholder="Max Price">
    <select name="sort_by">
        <option value="name">Name</option>
        <option value="price">Price</option>
    </select>
    <button type="submit">Filter</button>
</form>