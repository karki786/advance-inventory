@extends('emails.master')

@section('content')
    Dear All,<br/><br/>
    Kindly note that Sales Order (Quotation) No {{$salesOrder->orderNo}}. Please verify
    Amounts and raise an Invoice for it

@endsection