@extends('emails.master')

@section('content')
    A new user {{$user->name}} has registered with the Email {{$user->email}}. Kindly approve by clicking the below link.
    You will be required to login and approve the request.
    <br/>
    <a href="{{action('UserController@edit',$user->id)}}">Approve</a>


@endsection