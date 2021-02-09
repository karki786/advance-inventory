<html>
{{ HTML::style('dist/css/table.css') }}
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<body>
<!-- Headings -->
<thead>
<tr>
    <th>#</th>
    <th>Product Name</th>
    <th>Amount</th>
    <th>Reorder Amount</th>
    <th>Unit Cost</th>
    <th>Selling Cost</th>
    <th>Tax rate</th>
    <th>Category</th>
</tr>
</thead>
<?php $i = 1; ?>
@foreach($products as $product)
    <tr>
        <td scope="row">{{$i}}</td>
        <td><b>{{$product->productName}}</b></td>
        <td>{{$product->amount}}</td>
        <td>{{$product->reorderAmount}}</td>
        <td>{{$product->unitCost}}</td>
        <td>{{$product->sellingCost}}</td>
        <td>{{$product->productTaxRate}}%</td>
        <td>{{$product->categoryName}}</td>
    </tr>
    <?php $i++; ?>
@endforeach
</body>
</html>