<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{$order->supplierName}}</title>
    <link rel="stylesheet" href="style.css" media="all"/>
    <style>
        @font-face {
            font-family: SourceSansPro;
            /* src: url(SourceSansPro-Regular.ttf);*/
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        body {
            position: relative;
            width: 21cm;
            height: 29.7cm;
            margin: 0 auto;
            color: #555555;
            background: #FFFFFF;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-family: SourceSansPro;
        }

        header {
            padding: 10px 0;
            margin-bottom: 20px;
            border-bottom: 1px solid #AAAAAA;
        }

        #logo {

            margin-top: 8px;
        }

        #logo img {
            height: 70px;
        }

        #company {

            text-align: right;
        }

        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #0087C3;

        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: right;
        }

        #invoice h1 {
            color: #0087C3;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 20px;
        }

        table th,
        table td {
            padding: 20px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3 {
            color: #57B223;
            font-size: 1.2em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.6em;
            background: #57B223;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {
        }

        table .total {
            background: #57B223;
            color: #FFFFFF;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.2em;
        }

        table tbody tr:last-child td {
            border: none;
        }

        table tfoot td {
            padding: 10px 20px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #57B223;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table tfoot tr td:first-child {
            border: none;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            border-top: 1px solid #AAAAAA;
            padding: 8px 0;
            text-align: center;
        }


    </style>
</head>
<body>
<header class="clearfix">
    <table style="width: 100%; background-color: white;">
        <tr>
            <td style="text-align: left; background: white;">
                <div id="logo">
                    <img src="{{url("logo/{$company->logo}")}}">
                </div>
            </td>
            <td style=" background: white;">
                <div id="company">
                    <h2 class="name">{{$company->companyName}}</h2>
                    <div>{{$company->street}}, {{$company->zipCode}},{{$company->country}} </div>
                    <div>{{$company->phone}}</div>
                    <div><a href="mailto:{{Auth::user()->email}}">{{Auth::user()->email}}</a></div>
                </div>
            </td>
        </tr>
    </table>


</header>
<main>
    <table style="width: 90%; background-color: white;">
        <tr>
            <td style="text-align: left; background: white;">
                <div id="client">
                    <div class="to">Supplier:</div>
                    <h2 class="name">{{$order->supplier->supplierName}}</h2>
                    <div class="address">{{$order->supplier->address}}</div>
                    <div class="email"><a href="mailto:{{$order->supplier->email}}">{{$order->supplier->email}}</a>
                    </div>
                </div>
            </td>
            <td style=" background: white;">
                <div id="invoice">
                    <h1>PO {{$order->lpoNumber}}</h1>
                    <div class="date">Date of PO: {{$order->lpoDate}}</div>
                    <div class="date">Deliver By: {{$order->deliverBy}}</div>
                </div>
            </td>
        </tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="0">
        <thead>
        <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPTION</th>
            <th class="unit">UNIT PRICE</th>
            <th class="qty">QUANTITY</th>
            <th class="total">TOTAL</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
        @foreach($order->orders as $lpo)
            <tr>
                <td class="no">{{$i}}</td>
                <td class="desc">{{$lpo->productDescription}}</td>
                <td class="unit">{{$order->lpoCurrencyType}} {{number_format($lpo->unitCost,2)}}</td>
                <td class="qty">{{$lpo->amount}}</td>
                <td class="total">{{$order->lpoCurrencyType}} {{number_format($lpo->total,2)}}</td>
            </tr>
            <?php $i++; ?>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">SUBTOTAL</td>
            <td>{{$order->lpoCurrencyType}} {{number_format($order->orders->sum('total'),2)}}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">TAX</td>
            <td>{{$order->lpoCurrencyType}} {{number_format($order->orders->sum('tax'),2)}}</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="2">GRAND TOTAL</td>
            <td>{{$order->lpoCurrencyType}} {{number_format($order->orders->sum('total')+$order->orders->sum('tax'),2)}}</td>
        </tr>
        </tfoot>
    </table>
    <div id="thanks">Thank you!</div>
    <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">{{$order->remarks}}</div>
    </div>
</main>
<footer>
    PO was created on a computer and is valid without the signature and seal.
</footer>
</body>
</html>