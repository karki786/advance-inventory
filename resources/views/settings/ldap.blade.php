@extends('layouts.master')

@section('title')
    LDAP Settings
@endsection

@section('sidebar')
    @include('settings.menu')
@endsection

@section('content')
    @if($ldapAnswer == false)
        <div class="alert alert-danger">
            Cannot contact your LDAP server contact your administrator to get you the correct Settings
        </div>
        <hr/>
        LDAP_SERVER = {{env('auth.ldap_server')}} <br/>
        Username = {{env('auth.ldap_username')}} <br/>
        Password =  {{env('auth.ldap_password')}} <br/>
        auth.ldap_tree=  {{env('auth.ldap_tree')}} (This is where in the OU we query your users) <br/>
    @endif
    @if($ldapAnswer == true)
        <div class="alert alert-danger">
            Your LDAP reports the following users present.
        </div>
        <table class="table table-paper table-condensed table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
            </tr>
            </thead>
            <tbody>

            <?php $i = 1; ?>
            @foreach ($users as $user)
                <tr class="">
                    <th scope="row">{{$i}}</th>
                    <td>{{ucwords($user['name'])}}</td>
                    <td>{{ucwords($user['samaccountname'])}}</td>
                    <td>{{$user['mail']}} </td>
                    <?php $i++; ?>
                </tr>
            @endforeach

            </tbody>
        </table>
    @endif
@endsection

@section('js')

@endsection