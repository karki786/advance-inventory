<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Example 2</title>
    <link rel="stylesheet" href="style.css" media="all"/>
    <style>
        @font-face {
            font-family: SourceSansPro;
            /* src: url(SourceSansPro-Regular.ttf);*/
        }

        tr {
            padding: 5px;
        }

        td {
            padding: 5px;
        }

        .description {

        }

        .prices {
           text-align: right;
        }
    </style>
</head>
<body>
<main>
    <table>
        @foreach ($receipt->items as $item)
            <tr>
                <td class="description">{{$item->productDescription}}x{{$item->quantity}}</td>
                <td class="prices"><b>{{number_format($item->convertedPrice+$item->tax,2)}}</b></td>
            </tr>
        @endforeach
        <tr>
            <td class="prices"><b>Total</b></td>
            <td class="prices"><b>{{number_format($receipt->items->sum('convertedPrice')+$receipt->items->sum('tax'),2)}}</b></td>
        </tr>

    </table>


</main>
<footer>
    Invoice was created on a computer and is valid without the signature and seal.
</footer>
</body>
</html>