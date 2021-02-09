@extends('layouts.master')

@section('title', 'View POS Sale')

@section('content')
   @include('reports.receipt.receipt')


@endsection

@section('js')
    <script>
        $(document).ready(function () {
          
        });
    </script>
@endsection