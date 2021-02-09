Hi {{$supplier->supplierName}},
Please deliver the items below to us preferably by {{$order->polDateOfDelivery}} :
@foreach($order->orders as $item)
{{$item->poQty}}  {{$item->poDescription}}
@endforeach

Terms are : {{$order->polTermsOfPayment}}