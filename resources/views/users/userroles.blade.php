@extends('layouts.master')

@section('title')
    {!! env('COMPANY_NAME') !!} | @lang('user.User Roles')
@endsection



@section('content')
    <h1 class="text-center">@lang('user.User Roles')</h1>
    <hr/>
    <div class=" alert alert-info">
        You can change a Users Role <a class="btn btn-sm btn-flat bg-green" href="{{action('UserController@edit',Auth::user()->id)}}">Here</a>.<br/>
        <b>If you are just setting things up first assign all permissions to the Guest Role before you do this. This Unlocks all features for you to finish your set up</b>
    </div>
    @if(isset($role))
        {!! Form::model($role, ['action' => ['UserRolesController@update', $role->id], 'method' =>
        'patch'])
        !!}
    @else
        {!! Form::open(array('action' => 'UserRolesController@store', 'files'=>false)) !!}
    @endif
    <div class="panel panel-default cls-panel">
        <div class="panel-heading">
            <h3 class="panel-title">
                @lang('user.Add/Edit Roles')
            </h3>
        </div>

        <div class="panel-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group{!! $errors->has('name') ? ' has-error' : '' !!}">
                        {!! Form::label('name',  trans('user.Role Name') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                            {!! Form::text('name', null, ['class' => 'form-control','placeholder'=>'Role Name']) !!}
                            <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                        </div>
                        {!! $errors->first('name', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group{!! $errors->has('description') ? ' has-error' : '' !!}">
                        {!! Form::label('description',  trans('user.Description') ) !!}
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-list"></i></span>
                            {!! Form::text('description', null, ['class' => 'form-control','placeholder'=>'Description']) !!}
                            <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                        </div>
                        {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="panel-footer">
            <button type="submit" class="btn btn-flat bg-green btn-block">@lang('user.Save Role')</button>
        </div>
    </div>
    {!! Form::close() !!}

    <table class="table table-paper table-condensed table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>@lang('user.Name')</th>
            <th>@lang('user.Description')</th>
            <th>@lang('user.Date Created')</th>
            <th>@lang('user.Date Updated')</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>

        <?php $i = 1; ?>
        @foreach ($userroles as $role)
            <tr class="">
                <th scope="row">{{$i}}</th>
                <td>{{ucwords($role->name)}}</td>
                <td>{{$role->description}}</td>
                <td>{{Carbon::parse($role->created_at)->format('d/m/Y')}} </td>
                <td>{{Carbon::parse($role->updated_at)->format('d/m/Y')}} </td>
                <td>
                    <div aria-label="Actions" role="group" class="btn-group">
                        <a href="#delete-popup" class="open-popup-link btn btn-flat bg-red"
                           data-url="{{action('RoleController@destroy', $role->id)}}"><i
                                    class="fa fa-remove"></i>Delete</a>
                        <a class="btn btn-flat bg-blue" href="{{action('RoleController@create', array('id'=>$role->id))}}"> <i
                                    class="   fa fa-edit"></i> Assing Permissions to Role</a>
                    </div>
                </td>
                <?php $i++; ?>
            </tr>
        @endforeach

        </tbody>
    </table>
@endsection

@section('js')

@endsection