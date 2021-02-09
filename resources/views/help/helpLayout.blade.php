@extends('layouts.master')

@section('title')


@endsection

@section('sidebar')

@endsection

@section('content')
    <style>
        h1 {
            font-size: 30px !important;
            font-weight: bold;
        }

        h2 {
            font-weight: bold;
            width: 100%;
            border: 0;
            border-bottom: 1px solid #dddddd;
        }

        p, ol, li {
            line-height: 1.5em !important;
            font-size: 15px;
        }

        img {
            display: inline-block;
            max-width: 100%;
            height: auto;
            padding: 4px;
            line-height: 1.42857143;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            -webkit-transition: all .2s ease-in-out;
            -o-transition: all .2s ease-in-out;
            transition: all .2s ease-in-out;
            display: block;
            max-width: 100%;
            height: auto;
        }
    </style>

    {!! $html !!}


@endsection

@section('js')

@endsection