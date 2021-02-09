<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    {{ HTML::style('dist/css/report.css') }}
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>
<body>
<div id="body">

    <div id="section_header">
    </div>

    <div id="content">

        <div class="page" style="font-size: 7pt">
            <table style="width: 100%;" class="header">
                <tr>
                    <td><h1 style="text-align: left">Statement of Account</h1></td>

                </tr>
            </table>

            <table style="width: 100%; font-size: 8pt;">
                <tr>
                    <td>Customer: <strong>{{$customer->companyName}}</strong></td>

                </tr>

                <tr>
                    <td>Created: <strong>{{\Carbon\Carbon::today()}}</strong></td>

                </tr>

                <tr>
                    <td>Email: <strong>{{$customer->companyEmail}}</strong></td>

                </tr>
                <tr>
                    <td>Credit Limit: <strong>{{$customer->creditLimit}}</strong></td>
                </tr>
                <tr>
                    <td>Credit Days: <strong>{{$customer->days}}</strong></td>
                </tr>
            </table>


            <table class="change_order_items">

                <tr>
                    <td colspan="10"><h2>Unpaid Invoices:</h2></td>
                </tr>

                <tbody>
                <tr>
                    <th>Invoice Number</th>
                    <th>Due Date</th>
                    <th>Invoice Amount</th>
                    <th>Paid Amount</th>
                    <th>Amount Due</th>
                    <th>Payment Remarks</th>
                    <th colspan="4">Total</th>
                </tr>
                <?php $total = 0; ?>
                @foreach($customer->invoices as $invoice)
                    <tr class="even_row">
                        <td style="text-align: center">{{$invoice->invoiceNo}}</td>
                        <td style="text-align: center">{{$invoice->dueDate}}</td>
                        <td style="text-align: center">{{number_format($invoice->items->sum('total')+$invoice->items->sum('tax'),2)}}</td>
                        <td style="text-align: center">{{number_format($invoice->payment->sum('paymentAmount'),2)}}</td>
                        <td style="text-align: right; ">{{number_format($invoice->items->sum('total'),2)}}</td>
                        <td style="text-align: right; ">
                            @foreach($invoice->payment as $payment)
                                Remark: {{$payment->paymentRemarks}}
                                Type : {{$payment->paymentType}},
                            @endforeach
                        </td>
                        <td colspan="4"
                            class="change_order_total_col">{{number_format($invoice->items->sum('total')+$invoice->items->sum('tax')-$invoice->payment->sum('paymentAmount'),2)}}</td>
                    </tr>
                    <?php $total = $total + $invoice->items->sum('total') - $invoice->payment->sum('paymentAmount'); ?>
                @endforeach

                </tbody>


                <tr>
                    <td colspan="8" style="text-align: right;">
                    </td>
                    <td colspan="" style="text-align: right;"><strong>GRAND TOTAL:</strong></td>
                    <td class="change_order_total_col"><strong>{{number_format($total,2)}}</strong></td>
                </tr>
            </table>


        </div>

    </div>
</div>

</body>
</html>