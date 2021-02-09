<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->
<thead>
<tr>
    <th>Category Name</th>
    <th>Category Description</th>
    <th>Product</th>
    <th>Amount</th>
</tr>
</thead>
@foreach($categories as $category)
    <tr>
        <td><b>{{$category->categoryName}}</b></td>
        <td>{{$category->categoryDescription}}</td>
        <td></td>
        <td><b>{{count($category->products)}}</b></td>
    </tr>
    @foreach($category->products as $product)
        <tr>
            <td></td>
            <td></td>
            <td>{{$product->productName}}</td>
            <td>{{$product->amount}}</td>

        </tr>
    @endforeach

@endforeach
</body>
</html>