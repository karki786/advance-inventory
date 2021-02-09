@extends('emails.master')

@section('content')
    Dear {{$invoice->customerText}},<br/><br/>
    Your payment of {{$invoice->currencyTypeText}} {{$paymentAmount}} has been accpeted.  <br/><br/>
    Your current due amount is {{$invoice->currencyTypeText}} {{$dueAmmount}}"<br/><br/>
    Please find attached a complete summary of your account <br/><br/>
    Thanks for your business

@endsection