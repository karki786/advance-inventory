@extends('layouts.login')
<style>
    .center {
        text-align: center;
        margin-left: auto;
        margin-right: auto;
        margin-bottom: auto;
        margin-top: auto;
    }

    .cls-panel {
        margin-top: 40px;
    }
</style>
@section('title')
    404 Error
@endsection

@section('content')
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default cls-panel">
            <div class="panel-heading">
                <h3 class="panel-title">
                    {!! env('COMPANY_NAME') !!} | No Permissions
                </h3>
            </div>

            <div class="panel-body">
                <div class="hero-unit center">
                    <h1>Insufficient Permissions
                        <small><font face="Tahoma" color="red">Error 403</font></small>
                    </h1>
                    <br/>

                    <p>You do not have sufficient permissions to view the page you requested, contact your webmaster .
                        Use your
                        browsers
                        <b>Back</b> button to navigate to the page you have prevously come from</p>

                    <p><b>Or you could just press this neat little button:</b></p>
                    <a href="{{action('ProductController@index')}}" class="btn btn-flat bg-green"><i
                                class="icon-home icon-white"></i> Take Me Home</a>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')

@endsection