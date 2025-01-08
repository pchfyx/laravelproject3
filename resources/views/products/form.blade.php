<form action="{{ route($product->exists ? 'products.update' : 'products.store', $product) }}" method="POST">
    @csrf
    @if($product->exists)
        @method('PUT')
    @endif
    <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}">
    <textarea name="description">{{ old('description', $product->description ?? '') }}</textarea>
    <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}">
    <select name="category_id">
        @foreach($categories as $category)
            <option value="{{ $category->id }}" @if(old('category_id', $product->category_id ?? null) == $category->id) selected @endif>{{ $category->name }}</option>
        @endforeach
    </select>
    <button type="submit">Submit</button>
</form>